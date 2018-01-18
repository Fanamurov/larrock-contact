<?php

Route::any('/form/send/{param?}', 'Larrock\ComponentContact\ContactController@send_form')->name('send.form');

Route::group(['prefix' => 'admin'], function(){
    Route::resource('contact', 'Larrock\ComponentContact\AdminContactController');
});