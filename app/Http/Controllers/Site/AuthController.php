<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Site\BaseController;
use App\Http\Requests\GenerateOTPRequest;
use App\Http\Requests\LoginOTPRequest;
use App\Jobs\SendOneTimePassword;
use App\Models\LoginVerificationCode;
use App\Notifications\OneTimePassword;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Validator;
use View;
use Auth;

class AuthController extends BaseController
{
    /**
     * время в минутах когда пройдет срок одноразового пароля
     *
     * @return \Illuminate\View\View
     */
    const EXPIRATION_MINUTES_OF_SMS = 10;

    protected $section = [
        'name' => '',
        'type' => 'authorization',
        'configuration' => [
            'sidebar' => []
        ]
    ];

    // Показать блоки в колонке (алиас раздела в колонке)
    protected $sidebar = [
        "bastyk" => 1,
        "dev-projects" => 1,
        "ref-numbers" => 1,
        "right-banners" => 1,
        "population-figures" => 1,
        "mobile-apps-col" => 1,
    ];

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->section['name'] = __('translations.loginToCabinet');
        // $this->section['name'] = trans('forms.auth.section_name');

        $section = json_decode(json_encode($this->section), false);

        $section->configuration->sidebar = $this->sidebar;

        View::share([
            'indexPage' => false,
            'pagination' => null,
            'section' => $section,
            'extends' => 'site.templates.pages',
            'settings' => [
                'description' => '',
                'keywords' => '',
                'title' => 'АО "Samruk-Kazyna Construction"'
            ],
            'breadcrumbs' => [
                0 => [
                    "link" => '/auth',
                    "name" => __('translations.loginToCabinet')
                ]
            ]
        ]);
    }

    /**
     * Показать форму входа
     *
     * @return \Illuminate\View\View
     */
    public function index(): \Illuminate\View\View
    {
        return view('site.auth.index');
    }

    /**
     * Запрос на авторизацию в системе
     *
     * @param Request $request
     * @return RedirectResponse [type]           [description]
     */
    public function auth(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->input(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ], [
            'email.required' => 'Введите Email для авторизации',
            'password.required' => 'Вы не ввели пароль'
        ]);

        if (!$validator->fails()) {
            $capthca = $request->input('g-recaptcha-response');
            $ip = $_SERVER['REMOTE_ADDR'];

//            if ($capthca != '') {
//                $info = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdL-uAUAAAAAMDcLcHA8OHFnhc024ynhUu-XGmL&response=" . $capthca . "&remoteip=" . $ip));
//
//                if ($info->success == false) {
//                    return redirect()->back()->with('error', 'Вы не подтвердили, что вы не робот!');
//                }
//
//            } else {
//                return redirect()->back()->with('error', 'Вы не подтвердили, что вы не робот!');
//            }

            Auth::attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ], true);
            if (Auth::check()) {
                return redirect()->route(
                    'cabinet.index',
                    ['profile_check_need' => auth()->user()->profileCheckWasMadeBeforeTwoMonths()]
                );
            }
        }

        return redirect()->back()->withErrors($validator)->withInput();
    }


    /**
     * @return Application|Factory|\Illuminate\View\View
     */
    public function ecp()
    {
        return view('site.auth.ecp');
    }

    /**
     * Запрос на авторизацию в системе
     *
     * @param Request $request
     * @return RedirectResponse [type]           [description]
     */
    public function authEcp(Request $request): RedirectResponse
    {
        $user = $this->checkEcp($request);

        if (!is_null($user)) {
            Auth::loginUsingId($user->id, true);

            if (Auth::check()) {
                return redirect()->route('cabinet.index');
            }
        }
        return redirect()->back()->with('error', 'Данный пользователь не зарегистрирован');
    }

    /**
     * @param Request $request
     * @return User|null|RedirectResponse
     */
    private function checkEcp(Request $request)
    {
        $iin = $request->input('subjectIIN');
        if (is_null($iin)) {
            return redirect()->back()->with('error', 'Вы не выбрали ключ ЭЦП');
        }
        return User::where('iin', $iin)->first();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('site.home');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function sms(): \Illuminate\View\View
    {
        return view('site.auth.sms');
    }

    /**
     * @param GenerateOTPRequest $request
     * @return RedirectResponse
     */
    public function generateAndSendOTP(GenerateOTPRequest $request): RedirectResponse
    {
        $loginVerificationCode = $this->generateOtp($request->mobile);
        $this->sendSMS($loginVerificationCode);

        $message = "Your OTP To Login is - " . $loginVerificationCode->otp;
        return redirect()->route('sms.verification', ['user_id' => $loginVerificationCode->user_id])->with(
            'success',
            $message
        );
    }

    /**
     * @param string $mobile_no
     * @return LoginVerificationCode
     */
    public function generateOtp(string $mobile_no): LoginVerificationCode
    {
        $user = User::where('mobile', $mobile_no)->first();

        # User Does not Have Any Existing OTP
        $verificationCode = LoginVerificationCode::where('user_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            return $verificationCode;
        }

        return LoginVerificationCode::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(self::EXPIRATION_MINUTES_OF_SMS)
        ]);
    }

    /**
     * @param LoginVerificationCode $loginVerificationCode
     * @return void
     */
    private function sendSMS(LoginVerificationCode $loginVerificationCode)
    {
        SendOneTimePassword::dispatch(
            User::find($loginVerificationCode->user_id),
            $loginVerificationCode->otp
        )->onConnection('database')->delay(now()->addSeconds(5));
    }

    /**
     * @param int $user_id
     * @return \Illuminate\View\View
     */
    public function verificationSMS(int $user_id): \Illuminate\View\View
    {
        return view('site.auth.sms-verification')->with([
            'user_id' => $user_id
        ]);
    }

    /**
     * @param LoginOTPRequest $request
     * @return RedirectResponse
     */
    public function loginWithOTP(LoginOTPRequest $request): RedirectResponse
    {
        $verificationCode = LoginVerificationCode::where('user_id', $request->user_id)->where(
            'otp',
            $request->otp
        )->first();
        $now = Carbon::now();
        if (!$verificationCode) {
            return redirect()->back()->with('error', 'SMS-код не правильный');
        } elseif ($now->isAfter($verificationCode->expire_at)) {
            return redirect()->back()->with('error', 'SMS-код просрочен')->with(['otp' => $request->otp]);
        }
        $user = User::whereId($request->user_id)->first();

        if ($user) {
            // Expire The OTP
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);
            Auth::login($user);

            return redirect()->route('cabinet.index');
        }
        return redirect()->back()->withErrors(['field', 'SMS-код не правильный'])->withInput();
        // return redirect()->route('otp.login')->with('error', 'Your Otp is not correct');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function checkConsentToDataCollection(): \Illuminate\View\View
    {
        return view('site.auth.consent');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function agreeConsentToDataCollection(Request $request): RedirectResponse
    {
        $request['subjectIIN'] = '900714350610';
        $user = $this->checkEcp($request);
        $user->update([
            'consent_to_data_collection' => 1,
            'date_of_consent' => Carbon::now(),
            'device' => $request->header('User-Agent'),
        ]);
        dd($request->all());

        return redirect()->back();
    }

}
