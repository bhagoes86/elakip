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

    get('user/data', ['uses'  => 'UserController@data', 'as'    => 'user.data']);
    get('user/password/{id}/edit', ['uses' => 'UserController@getPassword', 'as' => 'user.password.edit']);
    put('user/password/{id}', ['uses' => 'UserController@putPassword', 'as' => 'user.password.update']);
    put('user/role/{id}', ['uses' => 'UserController@putRole', 'as' => 'user.role.update']);
    resource('user', 'UserController');

    get('position/data', [
        'uses'  => 'PositionController@data',
        'as'    => 'position.data'
    ]);
    get('position/user/not:{year}', ['uses' => 'PositionController@getSelectUser', 'as' => 'position.user.year']);
    resource('position', 'PositionController');

    resource('media', 'MediaController');

    get('page/data', [
        'uses'  => 'PageController@data',
        'as'    => 'page.data'
    ]);
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

    get('pk/data', [
        'uses'  => 'AgreementController@data',
        'as'    => 'pk.data'
    ]);
    resource('pk', 'AgreementController');
    get('pk/program/data', 'ProgramAgreementController@data');
    get('pk/{pk}/program', ['uses' => 'ProgramAgreementController@index', 'as' => 'pk.program.index']);

    // Dirjen
    get('pk/program/sasaran/data', ['uses' => 'Dirjen\TargetAgreementController@data', 'as' => 'pk.program.sasaran.data']);
    get('pk/{pk}/program/{program}/sasaran', ['uses' => 'Dirjen\TargetAgreementController@index', 'as' => 'pk.program.sasaran.index']);
    get('pk/program/sasaran/indikator/data', ['uses' => 'Dirjen\IndicatorAgreementController@data', 'as' => 'pk.program.sasaran.indikator.data']);
    resource('pk.program.sasaran.indikator', 'Dirjen\IndicatorAgreementController', ['only' => ['index', 'edit', 'update']]);

    // Direktorat
    get('pk/program/kegiatan/data', ['uses' => 'ActivityAgreementController@data', 'as' => 'pk.program.kegiatan.data']);
    get('pk/{pk}/program/{program}/kegiatan', ['uses' => 'ActivityAgreementController@index', 'as' => 'pk.program.kegiatan.index']);
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
