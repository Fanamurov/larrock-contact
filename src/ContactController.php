<?php

namespace Larrock\ComponentContact;

use Alert;
use App\Models\FormsLog;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Validator;
use Mail;

class ContactController extends Controller
{
    public function contact()
	{
		return view('larrock::front.modules.forms.contact', []);
	}

	public function send_form(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'contact' => 'required',
			'agree' => 'required',
		]);
		if($validator->fails()){
			return back()->withInput($request->except('password'))->withErrors($validator);
		}

		//FormsLog::create(['formname' => 'contact', 'params' => $request->all(), 'status' => 'Новое']);

		$mails = collect(array_map('trim', explode(',', env('MAIL_TO_ADMIN', 'robot@martds.ru'))));
		/** @noinspection PhpVoidFunctionResultUsedInspection */
		$send = Mail::send('larrock::emails.contact',
			['name' => $request->get('name'),
				'contact' => $request->get('contact'),
				'comment' => $request->get('comment')],
			function($message) use ($mails){
				$message->from('no-reply@'. array_get($_SERVER, 'HTTP_HOST'), env('MAIL_TO_ADMIN_NAME', 'ROBOT'));
				foreach($mails as $value){
					$message->to($value);
				}
				$message->subject('Отправлена форма заявки '. array_get($_SERVER, 'HTTP_HOST')
				);
			});
		
		Alert::add('success', 'Форма отправлена')->flash();
		return back();
	}
}
