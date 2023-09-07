<?php

namespace App\Http\Controllers\Site\Registrations;

use App\Http\ApiRequest;
use App\Http\Controllers\Site\BaseController;
use App\Http\Requests\Register\RegisterRequest;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\{User, Roles};
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Rules\ValidationMobileRule;
use Illuminate\Http\Request;

class RegistrationsController extends BaseController
{

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
        "population-figures" => 1,
        "right-banners" => 1,
        "mobile-apps-col" => 1,
    ];

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->section['name'] = "Регистрация";

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
        ]);
    }

    /**
     * Показать форму регистрации
     *
     * @return Factory|Application|\Illuminate\View\View [type] [description]
     */
    public function index()
    {
        $this->afterView('Регистрация');

        return view('site.registrations.index');
    }

    /**
     * Action for save registrations data
     * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
            $api = new ApiRequest();
        $info = $api->CheckByPhone([
//            "iin" => $request->input('subjectIIN'),
            "iin" => '900714350610',
            "num_phone" => $request->input('mobile')
        ])->_toArray();

        if ($info['code'] == 200) {
            $data = $info['data'];
            if ($data['result'] == 1) {
                $data = [
                    'code' => 404,
                    'message' => 'Невозможно получить информацию так как в базе отсутсвует номер телефона'
                ];
                return redirect()->route('registrations.index')->withErrors($data);
            } elseif ($data['result'] == 4) {
                $data = [
                    'code' => 500,
                    'message' => 'Данные по контрагенту не загружены в базу данных'
                ];
                return redirect()->route('registrations.index')->withErrors($data);
            } elseif ($data['result'] == 0) {
                $data = [
                    'code' => 200,
                    'message' => 'good'
                ];
                $role = Roles::whereName('guest')->first();

                $user = new User();
                $user->role_id = $role->id;
                $user->good = 1;
                $user->name = $request->input('subjectName');
                $user->iin = $request->input('subjectIIN');
                $user->email = $request->input('email');
                $user->mobile = $request->input('mobile');
                $user->password = $request->input('password');
                $user->work_phone = $request->input('work_phone');
                $user->homephone = $request->input('home_phone');
                $user->address = $request->input('address');
                $user->consent_to_data_collection = $request->input('consent_to_data_collection');
                $user->date_of_consent = Carbon::now();
                $user->device = $request->header('User-Agent');
                $user->last_profile_check_at = Carbon::now();

                // $user->verify = bcrypt(date('Ymdhis') . rand(1000000, 9999999));

                if ($user->save()) {
                    Mail::send('site.emails.registrations', ['user' => $user], function ($message) use ($user) {
                        $message->from('no-reply@skcn.kz', 'АО «Samruk-Kazyna Construction»');
                        $message->subject('Регистрация');
                        $message->to($user->email);
                    });

                    return redirect()->route('auth.index')->with(
                        'success',
                        'Вы успешно зарегистрировались, пройдите авторизацию для входа в личный кабинет'
                    );
                }
            } else {
                $data = [
                    'code' => 404,
                    'message' => 'Не найдет абонент с таким ИИН в базе'
                ];
                return redirect()->route('registrations.index')->withErrors($data);
            }
        } else {
            $data = [
                'code' => 500,
                'message' => 'Ошибка связи с сервером попробуйте позднее'
            ];
            return redirect()->route('registrations.index')->withErrors($data);
        }
    }

    /**
     * View confirmation page
     */
    public function verify($verify)
    {
        $this->afterView(trans('forms.registrations.verify.section_name'));

        $user = User::whereVerify($verify)->first();

        if ($user) {
            $user->good = 1;
            $user->verify = null;
            if ($user->save()) {
                return view('site.registrations.verify', [
                    'success' => true
                ]);
            }
        }

        return view('site.registrations.verify', [
            'success' => false
        ]);
    }

    /**
     * Form enter email for password restore
     */
    public function restore()
    {
        $this->afterView('Сброс пароля', '/registrations/restore');

        return view('site.registrations.restore');
    }

    /**
     * Form view for password restore
     */
    public function restore_post(Request $request): RedirectResponse
    {
        $post = $this->validate(request(), [
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $post['email'])->first();

        if (!is_null($user)) {
            $user->verify = bcrypt(date('Ymdhis') . rand(1000000, 9999999));

            if ($user->save()) {
                Mail::send('site.emails.restore', ['user' => $user], function ($message) use ($post) {
                    $message->from('no-reply@skcn.kz', 'АО «Samruk-Kazyna Construction»');
                    $message->subject('Запрос на восстановление пароля');
                    $message->to($post['email']);
                });
                return redirect()->back()->with(['success' => true]);
            }
        }

        return redirect()->back()->with(['errors' => false]);
    }

    /**
     * Action for restore password
     */
    public function update($verify)
    {
        $this->afterView('Сброс пароля', '/registrations/restore');

        $user = User::where('verify', $verify)->first();

        if (!is_null($user)) {
            return view('site.registrations.update', [
                'success' => true,
                'verify' => $verify
            ]);
        }

        return view('site.registrations.update', [
            'success' => false
        ]);
    }

    /**
     * Save new password
     */
    public function save_new_password($verify)
    {
        $this->afterView('Сброс пароля', '/registrations/restore');
        $post = $this->validate(request(), [
            'password' => 'required|min:5|max:200',
            'confirm' => 'required|same:password',
        ]);

        $user = User::where('verify', $verify)->first();


        if ($user) {
            $user->password = $post['password'];
            $user->verify = null;
            if ($user->save()) {
                return view('site.registrations.update-password', [
                    'success' => true
                ]);
            }
        }

        return view('site.registrations.update-password', [
            'success' => false
        ]);
    }

    public function afterView($sectionName = '', $link = '/registrations')
    {
        $this->section['name'] = $sectionName;

        $section = json_decode(json_encode($this->section), false);

        $section->configuration->sidebar = $this->sidebar;

        View::share([
            'section' => $section,
            'settings' => [
                'description' => '',
                'keywords' => '',
                'title' => 'АО "Samruk-Kazyna Construction"',
            ],
            'breadcrumbs' => [
                0 => [
                    "link" => $link,
                    "name" => $sectionName
                ]
            ]
        ]);
    }

}
