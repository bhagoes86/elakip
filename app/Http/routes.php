<?php

Route::get('/', ['uses' => 'Common\LandingController@index']);

Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

Route::group([
    'middleware' => 'auth',
    'namespace' => 'Privy'
], function () {

    get('dashboard', 'DashboardController@index');

    resource('media', 'MediaController');

    resource('periode', 'PeriodController');

    resource('renstra', 'PlanController');

    resource('renstra.program', 'ProgramController');

    // Dirjen
    resource('renstra.program.sasaran', 'Dirjen\TargetController');
    resource('renstra.program.sasaran.indikator', 'Dirjen\IndicatorController');

    // Direktorat
    resource('renstra.program.kegiatan', 'ActivityController');
    resource('renstra.program.kegiatan.sasaran', 'TargetController');
    resource('renstra.program.kegiatan.sasaran.indikator', 'IndicatorController');

    resource('pk', 'AgreementController');
    resource('pk.program', 'ProgramAgreementController');

    // Dirjen
    resource('pk.program.sasaran', 'Dirjen\TargetAgreementController');
    resource('pk.program.sasaran.indikator', 'Dirjen\IndicatorAgreementController');

    // Direktorat
    resource('pk.program.kegiatan', 'ActivityAgreementController');
    resource('pk.program.kegiatan.sasaran', 'TargetAgreementController');
    resource('pk.program.kegiatan.sasaran.indikator', 'IndicatorAgreementController');

    resource('capaian/fisik', 'PhysicAchievementController');
    resource('capaian/anggaran', 'BudgetAchievementController');

    get('capaian/renstra/fisik', 'Period\PhysicAchievementController@index');
    get('capaian/renstra/anggaran', 'Period\BudgetAchievementController@index');

    resource('kegiatan.evaluasi', 'EvaluationController');
});

Route::get('/{slug}', ['uses' => 'Common\LandingController@page', 'as' => 'public.page']);
