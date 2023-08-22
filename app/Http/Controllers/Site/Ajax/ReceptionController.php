<?php namespace App\Http\Controllers\Site\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Mail;

class ReceptionController extends Controller
{
    /**
     * Запись на прием к акиму или его заместителям
     * @param  integer  $id       Номер записи в системе, для определения того, кому отправлять
     * @param  Request $request
     * @return ajax               Результат в виде ajax массива
     */
    public function reception ($id = null, Request $request)
    {
        $validator = Validator::make($request->input(), [
          'fio' => 'required|max:250',
          'date' => 'required|date_format:"d.m.Y"',
          'time' => 'required|date_format:"H:i"',
          'email' => 'required|email',
          'phone' => 'required|max:100',
          'message' => 'required|min:10|max:2000',
        ], trans('validation_forms.reception'));

        if (!$validator->fails()) {

          // На мыло администратору
          Mail::send('site.emails.forms.reception-admin', ['data' => $request->input()], function ($message) {
            $message->from('no-reply@astana.kz', 'Запись на прием - astana.gov.kz');
            $message->subject('Запись на прием - Акимат Астаны');
            $message->to('anatoliy@ir.kz');
          });

          // На мыло пользователю
          Mail::send('site.emails.forms.reception-user', ['data' => $request->input()], function ($message) use ($request) {
            $message->from('no-reply@astana.kz', 'Запись на прием - astana.gov.kz');
            $message->subject('Запись на прием - Акимат Астаны');
            $message->to($request->input('email'));
          });

          return ['status' => 'success'];

        }

        return ['status' => 'errors', 'messages' => [
          'fio' => $validator->errors()->first('fio'),
          'date' => $validator->errors()->first('date'),
          'time' => $validator->errors()->first('time'),
          'email' => $validator->errors()->first('email'),
          'phone' => $validator->errors()->first('phone'),
          'message' => $validator->errors()->first('message'),
        ]];

    }

}
