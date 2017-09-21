<?php

namespace Larrock\ComponentContact;

use Alert;
use App\Models\FormsLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Validator;
use Mail;

class ContactController extends Controller
{
	public function send_form(Request $request)
	{
		$validator = Validator::make($request->all(), config('larrock-form.'. $request->get('form') .'.rules'));
		if($validator->fails()){
			return back()->withInput($request->except('password'))->withErrors($validator);
		}

		$mails = array_map('trim', explode(',',config('larrock-form.'. $request->get('form') .'.emails')));
		/** @noinspection PhpVoidFunctionResultUsedInspection */
		$send = Mail::send(config('larrock-form.'. $request->get('form') .'.emailTemplate', 'larrock::emails.formDefault'),
            [
                'data' => $request->except(config('larrock-form.'. $request->get('form') .'.emailDataExcept', ['g-recaptcha-response', '_token', 'form'])),
                'form' => $request->get('form')
            ],
			function($message) use ($mails, $request){
				$message->from(config('larrock-form.'. $request->get('form') .'.emailFrom'), env('MAIL_TO_ADMIN_NAME', 'ROBOT'));
				$message->to($mails);
				$message->subject(config('larrock-form.'. $request->get('form') .'.emailSubject'));
			});
		
		Alert::add('success', config('larrock-form.'. $request->get('form') .'.emailSuccessMessage'))->flash();
		return back();
	}
}
