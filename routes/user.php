<?php

if(!Auth::check()){
  Route::get('/','UserController@dashboard');
  Route::group(['prefix' => 'search'], function(){
      Route::post('getTaxonomyName','AjaxController@getTaxonomyName'); //AjaxController
      Route::get('dashboard','SearchTypeCController@searchADashboard');
      Route::get('diversity','SearchTypeCController@searchDiversity');
      Route::get('distribution','SearchTypeCController@searchDistribution');
      Route::post('distribution','SearchTypeCController@getDistribution');
      Route::get('recentrecord','SearchTypeCController@searchRecent');
      Route::post('searchdata','SearchTypeCController@search'); //AjaxController
      Route::get('NameRecord', 'SearchTypeCController@searchByNameRecord');
      Route::post('doNameRecord', 'SearchTypeCController@doSearchNameRecord'); //Ajax
  });
  Route::get('referenceLoan', 'WordingController@referenceLoan');

  // Route::get('/','AuthenController@login');
  Route::get('login','AuthenController@login');
  Route::get('register','AuthenController@register');
  Route::post('register','AuthenController@doRegister');
  Route::get('forgetpassword','AuthenController@forgetpass');
  Route::post('forgetpassword','AuthenController@doforgetpass');
  Route::get('resetpassword/{id}','AuthenController@resetPassword');
  Route::post('resetpassword','AuthenController@doResetPassword');
}
