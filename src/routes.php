<?php

use Larrock\ComponentContact\Facades\LarrockContact;

Route::any('/form/send/{param?}', 'Larrock\ComponentContact\ContactController@sendForm')->name('send.form');

Route::group(['prefix' => 'admin'], function(){
    Route::resource('contact', 'Larrock\ComponentContact\AdminContactController');
});

Breadcrumbs::register('admin.'. LarrockContact::getName() .'.index', function($breadcrumbs){
    $breadcrumbs->push(LarrockContact::getTitle(), '/admin/'. LarrockContact::getName());
});

Breadcrumbs::register('admin.'. LarrockContact::getName() .'.edit', function($breadcrumbs, $data)
{
    $breadcrumbs->parent('admin.'. LarrockContact::getName() .'.index');
    $breadcrumbs->push($data->title);
});