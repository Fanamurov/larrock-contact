<?php

Route::any('/form/send/{param?}', 'Larrock\ComponentContact\ContactController@send_form')->name('send.form');

Route::group(['prefix' => 'admin', 'middleware'=> ['web', 'level:2', 'LarrockAdminMenu', 'SaveAdminPluginsData']], function(){
    Route::resource('contact', 'Larrock\ComponentContact\AdminContactController');
});

/*Breadcrumbs::register('admin.'. LarrockContact::getName() .'.index', function($breadcrumbs){
    $breadcrumbs->push(LarrockContact::getTitle(), '/admin/'. LarrockContact::getName());
});

Breadcrumbs::register('admin.'. LarrockContact::getName() .'.edit', function($breadcrumbs, $data)
{
    $breadcrumbs->parent('admin.'. LarrockContact::getName() .'.index');
    $breadcrumbs->push($data->title);
});*/