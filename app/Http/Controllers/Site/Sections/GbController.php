<?php namespace App\Http\Controllers\Site\Sections;

use App\Http\Controllers\Site\Sections\SectionsController;
use Illuminate\Http\Request;
use App\Models\Gb;
use Mail;

class GbController extends SectionsController
{
	public function index ()
	{
		$template = 'site.templates.gb.short.' . $this->getTemplateFileName($this->section->current_template->file_short);

		$records = $this->section->gb()->whereLang($this->lang)->good()->orderBy('published_at', 'desc')->paginate($this->section->current_template->records);

		return view($template, [
			'records' => $records,
			'pagination' => $records->appends($_GET)->links()
		]);
	}

	public function store (Request $request)
	{
		$this->validate(request(), [
			'name' => 'required|max:255',
			'surname' => 'required|max:255',
			'email' => 'required|email',
			'theme' => 'required|max:255',
			'message' => 'required|min:10',
		], [
			'name.required' => 'Поле <b>Имя</b> обязательно к заполнению',
			'name.max' => '<b>Имя</b> должно быть не более :max символов',
			'surname.required' => 'Поле <b>Фамилия</b> обязательна к заполнению',
			'surname.max' => '<b>Фамилия</b> должно быть не более :max символов',
			'theme.required' => 'Поле <b>Тема</b> обязательна к заполнению',
			'theme.max' => '<b>Тема</b> должно быть не более :max символов',
			'message.required' => 'Поле <b>Вопрос</b> обязателен к заполнению',
			'message.min' => '<b>Вопрос</b> не должен быть менее :min символов',
			'email.required' => 'Поле <b>E-mail</b> обязателен к заполнению'
		]);

		$gb = new Gb();

		$gb->name = $request->input('name') ?? null;
		$gb->surname = $request->input('surname') ?? null;
		$gb->email = $request->input('email') ?? null;
		$gb->theme = $request->input('theme') ?? null;
		$gb->message = $request->input('message') ?? null;
		$gb->lang = $this->lang;
		$gb->section_id = $this->section->id;
		$gb->ip = $request->ip();

		if ($gb->save()) {

			Mail::send('site.emails.gb.user', ['gb' => $gb, 'section' => $this->section], function ($message) use ($gb) {
					$message->from(env('MAIL_USERNAME'), 'no-reply');
					$message->subject('Уведомление');
					$message->to($gb->email);
			});

			Mail::send('site.emails.gb.admin', ['gb' => $gb, 'section' => $this->section], function ($message) use ($gb) {
					$message->from(env('MAIL_USERNAME'), 'no-reply');
					$message->subject('Новый вопрос в раздел - ' . $this->section->name);
					 $message->to('blog@fnsk.kz');
//					$message->to('d.nakipova@fnsk.kz');
					// $message->to('R.sultanov@fnsk.kz');
					// $message->cc('vladimir@ir.kz');
			});

			return redirect()->route('site.gb.index', ['alias' => $this->section->alias])->with(['success' => 'Ваш вопрос успешно отправлен']);
		}

		return redirect()->back()->with(['errors' => 'Произошла внутренняя ошибка системы. Попробуйте позднее.']);
	}
}
