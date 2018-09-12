<?php

Route::get('login','AuthenController@login');
Route::post('login','AuthenController@authenticate');
Route::get('logout','AuthenController@logout');

Route::get('register','AuthenController@register');
Route::post('register','AuthenController@doRegister');
Route::get('forgetpassword','AuthenController@forgetpass');
Route::post('forgetpassword','AuthenController@doforgetpass');
Route::get('resetpassword/{id}','AuthenController@resetPassword');
Route::post('resetpassword','AuthenController@doResetPassword');