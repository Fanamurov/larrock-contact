<?php

use Larrock\ComponentContact\ContactController;

Route::group(['middleware' => ['web', 'AddMenuFront', 'GetSeo', 'AddBlocksTemplate']], function(){
    Route::post('/forms/contact', [
        'as' => 'submit.contacts', 'uses' => ContactController::class .'@send_form'
    ]);
});