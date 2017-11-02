<?php

namespace Larrock\ComponentContact\Middleware;

use Cache;
use Closure;
use View;

class ContactCreateTemplate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $forms = config('larrock-form');
        foreach ($forms as $key => $form){
            if(is_array($form) && isset($form['rows']) && array_get($form, 'render', TRUE) === TRUE){
                $render = Cache::remember('contactForm'. $key, 1440, function() use ($form, $key){
                    $jsValidation = NULL;
                    if(array_has($form, 'rules')){
                        $jsValidation = \JsValidator::make($form['rules'], [], [], '#form'. $key);
                    }
                    return $this->contactBuilder($form, $key, $jsValidation);
                });
                View::share('form_'. $key, $render);
            }
        }

        return $next($request);
    }

    protected function contactBuilder($form, $form_key, $jsValidation = NULL)
    {
        $content['url'] = \URL::current();
        $form_id = $form_key;

        $view_name = 'larrock::front.ContactBuilder.form';
        if(array_key_exists('view', $form) && View::exists($form['view'])){
            $view_name = $form['view'];
        }

        return view($view_name, [
            'form' => $form,
            'content' => $content,
            'form_id' => $form_id,
            'jsValidation' => $jsValidation
        ])->render();
    }
}