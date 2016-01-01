<?php

Route::get('/', ['uses' => 'Common\LandingController@index']);

Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

Route::group([
    'middleware' => 'auth',
    'namespace' => 'Privy'
], function () {

    get('dashboard', [
        'uses' => 'DashboardController@index',
        'as' => 'dashboard'
    ]);

    resource('user', 'UserController');

    resource('position', 'PositionController');

    resource('media', 'MediaController');

    resource('page', 'PageController');

    resource('periode', 'PeriodController');

    get('renstra/data', [
        'uses'  => 'PlanController@data',
        'as'    => 'renstra.data'
    ]);
    resource('renstra', 'PlanController');

    get('renstra/program/data', [
        'uses'  => 'ProgramController@data',
        'as'    => 'renstra.program.data'
    ]);
    resource('renstra.program', 'ProgramController', [
        'except'    => ['create', 'show']
    ]);

    // Dirjen
    get('renstra/program/sasaran/data', [
        'uses'  => 'Dirjen\TargetController@data',
        'as'    => 'renstra.program.sasaran.data'
    ]);
    resource('renstra.program.sasaran', 'Dirjen\TargetController');
    get('renstra/program/sasaran/indikator/data', [
        'uses'  => 'Dirjen\IndicatorController@data',
        'as'    => 'renstra.program.sasaran.indikator.data'
    ]);
    resource('renstra.program.sasaran.indikator', 'Dirjen\IndicatorController');

    // Direktorat
    get('renstra/program/kegiatan/data', [
        'uses'  => 'ActivityController@data',
        'as'    => 'renstra.program.kegiatan.data'
    ]);
    resource('renstra.program.kegiatan', 'ActivityController');
    get('renstra/program/kegiatan/sasaran/data', [
        'uses'  => 'TargetController@data',
        'as'    => 'renstra.program.kegiatan.sasaran.data'
    ]);
    resource('renstra.program.kegiatan.sasaran', 'TargetController');
    get('renstra/program/kegiatan/sasaran/indikator/data', [
        'uses'  => 'IndicatorController@data',
        'as'    => 'renstra.program.kegiatan.sasaran.indikator.data'
    ]);
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

    get('capaian/renstra/fisik', [
        'uses'  => 'Period\PhysicAchievementController@index',
        'as'    => 'capaian.renstra.fisik.index'
    ]);
    get('capaian/renstra/anggaran', [
        'uses'  => 'Period\BudgetAchievementController@index',
        'as'    => 'capaian.renstra.anggaran.index'
    ]);

    resource('kegiatan.evaluasi', 'EvaluationController');
});

Route::get('/{slug}', ['uses' => 'Common\LandingController@page', 'as' => 'public.page']);
