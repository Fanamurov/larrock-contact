<?php

use Larrock\ComponentContact\ContactController;

$middlewares = ['web', 'GetSeo'];
if(file_exists(base_path(). '/vendor/fanamurov/larrock-menu')){
    $middlewares[] = 'AddMenuFront';
}
if(file_exists(base_path(). '/vendor/fanamurov/larrock-blocks')){
    $middlewares[] = 'AddBlocksTemplate';
}
if(file_exists(base_path(). '/vendor/fanamurov/larrock-discount')){
    $middlewares[] = 'DiscountsShare';
}

Route::group(['middleware' => $middlewares], function(){
    Route::post('/forms/contact', [
        'as' => 'submit.contacts', 'uses' => ContactController::class .'@send_form'
    ]);
});