<?php

Route::get('/', ['uses' => 'Common\LandingController@index']);

Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

Route::group([
    'middleware' => 'auth',
    'namespace' => 'Privy'
], function () {

});

Route::get('/{slug}', ['uses' => 'Common\LandingController@page', 'as' => 'public.page']);
