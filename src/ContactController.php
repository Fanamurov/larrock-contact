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
		if($request->has('email') && !empty($request->get('email'))){
		    $mails[] = $request->get('email');
        }

        $uploaded_file = NULL;
        if($request->hasFile('file')) {
            $file = $request->file('file');
            if($file->isValid()){
                $filename = date('Ymd-hsi'). $file->getClientOriginalName();
                $file->move(public_path() .'/media/FormUpload/', $filename);
                $uploaded_file = env('APP_URL') .'/media/FormUpload/'. $filename;
            }
        }

		/** @noinspection PhpVoidFunctionResultUsedInspection */
		$send = Mail::send(config('larrock-form.'. $request->get('form') .'.emailTemplate', 'larrock::emails.formDefault'),
            [
                'data' => $request->except(config('larrock-form.'. $request->get('form') .'.emailDataExcept', ['g-recaptcha-response', '_token', 'form', 'file'])),
                'form' => $request->get('form'),
                'uploaded_file' => $uploaded_file
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
