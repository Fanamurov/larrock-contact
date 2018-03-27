<?php

namespace Larrock\ComponentContact\Middleware;

use Cache;
use Closure;
use View;
use Larrock\ComponentContact\Facades\LarrockContact;

class ContactCreateTemplate
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $forms = Cache::rememberForever('CreateFormsContact', function () {
            return LarrockContact::getForms();
        });
        foreach ($forms as $form){
            View::share('form_'. $form->name, (string)$form);
        }

        return $next($request);
    }
}