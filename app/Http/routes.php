<?php

Route::get('/', ['uses' => 'Common\LandingController@index']);

Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');


Route::group([
    'middleware' => ['auth','position'],
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
    get('user/year', ['uses' => 'UserController@getUserInYear', 'as' => 'user.year']);
    // get('user/ditjen/year', ['uses' => 'UserController@getDitjenInYear', 'as' => 'user.ditjen.year']);
    get('user/first/year', ['uses' => 'UserController@getFirstUserInYear', 'as' => 'user.first.year']);
    resource('user', 'UserController');

    get('position/data', [
        'uses'  => 'PositionController@data',
        'as'    => 'position.data'
    ]);
    get('position/user/not:{year}', ['uses' => 'PositionController@getSelectUser', 'as' => 'position.user.year']);
    resource('position', 'PositionController');

    Route::any('media/connector', ['uses' => 'MediaController@showConnector', 'as' => 'media.connector']);
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

    get('program/select2', ['uses' => 'ProgramController@getSelect2', 'as' => 'program.select2']);
    get('renstra/program/data', ['uses'  => 'ProgramController@data', 'as'    => 'renstra.program.data']);
    resource('renstra.program', 'ProgramController', ['except'    => ['create', 'show']]);

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
    get('kegiatan/select2', ['uses' => 'ActivityController@getSelect2', 'as' => 'kegiatan.select2']);
    get('renstra/program/kegiatan/data', [
        'uses'  => 'ActivityController@data',
        'as'    => 'renstra.program.kegiatan.data'
    ]);
    resource('renstra.program.kegiatan', 'ActivityController');

    get('sasaran/select2', ['uses' => 'TargetController@getSelect2', 'as' => 'sasaran.select2']);
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
    get('pk/select2', ['uses' => 'AgreementController@getSelect2', 'as' => 'pk.select2']);
    get('pk/{pk}/export', ['uses' => 'AgreementController@getExport', 'as' => 'pk.export']);
    get('pk/{pk}/scanned', ['uses' => 'AgreementController@getScanned', 'as' => 'pk.scanned']);
    get('pk/{id}/doc/create', ['uses' => 'AgreementController@getDocumentForm', 'as' => 'pk.doc.create']);
    post('pk/{id}/doc/create', ['uses' => 'AgreementController@postDocument', 'as' => 'pk.doc.store']);
    get('pk/program/data', 'ProgramAgreementController@data');
    get('pk/{pk}/program', ['uses' => 'ProgramAgreementController@index', 'as' => 'pk.program.index']);
    put('pk/program/{program}/budget', ['uses' => 'ProgramAgreementController@putBudget', 'as' => 'pk.program.budget.update']);
    resource('pk', 'AgreementController');

    // Dirjen
    get('pk/program/sasaran/data', ['uses' => 'Dirjen\TargetAgreementController@data', 'as' => 'pk.program.sasaran.data']);
    get('pk/{pk}/program/{program}/sasaran', ['uses' => 'Dirjen\TargetAgreementController@index', 'as' => 'pk.program.sasaran.index']);
    get('pk/program/sasaran/indikator/data', ['uses' => 'Dirjen\IndicatorAgreementController@data', 'as' => 'pk.program.sasaran.indikator.data']);
    resource('pk.program.sasaran.indikator', 'Dirjen\IndicatorAgreementController', ['only' => ['index', 'edit', 'update']]);

    // Direktorat
    get('pk/program/kegiatan/data', ['uses' => 'ActivityAgreementController@data', 'as' => 'pk.program.kegiatan.data']);
    // get('pk/{pk}/program/{program}/kegiatan', ['uses' => 'ActivityAgreementController@index', 'as' => 'pk.program.kegiatan.index']);
    resource('pk.program.kegiatan', 'ActivityAgreementController', ['only' => ['index','edit','update']]);
    get('pk/program/kegiatan/sasaran/data', ['uses' => 'TargetAgreementController@data', 'as' => 'pk.program.kegiatan.sasaran.data']);
    get('pk/{pk}/program/{program}/kegiatan/{kegiatan}/sasaran', ['uses' => 'TargetAgreementController@index', 'as' => 'pk.program.kegiatan.sasaran.index']);
    get('pk/program/kegiatan/sasaran/indikator/data', ['uses' => 'IndicatorAgreementController@data', 'as' => 'pk.program.kegiatan.sasaran.indikator.data']);
    resource('pk.program.kegiatan.sasaran.indikator', 'IndicatorAgreementController', ['only' => ['index', 'edit', 'update']]);

    /**
     * Indikator detail
     */
    get('pk/program/kegiatan/sasaran/indikator/detail/data', ['uses' => 'IndicatorDetailController@data', 'as' => 'pk.program.kegiatan.sasaran.indikator.detail.data']);
    resource('pk.program.kegiatan.sasaran.indikator.detail', 'IndicatorDetailController', ['only' => ['index', 'edit', 'update','destroy']]);

    get('capaian/media/data', ['uses' => 'PhysicAchievementController@getMediaData', 'as' => 'capaian.media.data']);
    delete('capaian/{achievementId}/media/{mediaId}/destroy', ['uses' => 'PhysicAchievementController@deleteMedia', 'as' => 'capaian.media.destroy']);
    get('goal/{goalId}/capaian/{achievementId}', ['uses' => 'PhysicAchievementController@getDocument', 'as' => 'goal.capaian.doc.create']);
    post('goal/{goalId}/capaian/{achievementId}', ['uses' => 'PhysicAchievementController@postDocument', 'as' => 'goal.capaian.doc.store']);
    get('capaian/fisik/filter', ['uses' => 'PhysicAchievementController@getFilter', 'as' => 'capaian.fisik.filter']);
    get('capaian/fisik/filter/indicator', ['uses' => 'PhysicAchievementController@getIndicator', 'as' => 'capaian.fisik.indicator']);
    get('capaian/fisik/indicator/data', ['uses' => 'PhysicAchievementController@getIndicatorData', 'as' => 'capaian.fisik.indicator.data']);
    Route::group([
        'prefix'    => 'capaian/fisik'
    ], function () {
        resource('goal.achievement', 'PhysicAchievementController', ['only' => ['index','store']]);
    });

    get('capaian/anggaran/filter', ['uses' => 'BudgetAchievementController@getFilter', 'as' => 'capaian.anggaran.filter']);
    get('capaian/anggaran/filter/kegiatan', ['uses' => 'BudgetAchievementController@getActivity', 'as' => 'capaian.anggaran.kegiatan']);
    put('capaian/anggaran/kegiatan/{budget}', ['uses' => 'BudgetAchievementController@update', 'as' => 'capaian.anggaran.kegiatan.update']);
    Route::group([
        'prefix'    => 'capaian/anggaran'
    ], function () {
        resource('goal.achievement', 'BudgetAchievementController', ['only' => ['index','store']]);
    });

    get('capaian/renstra/fisik/filter', ['uses'  => 'Period\PhysicAchievementController@getFilter', 'as'    => 'capaian.renstra.fisik.filter']);
    get('capaian/renstra/fisik/filter/indicator', ['uses'  => 'Period\PhysicAchievementController@getIndicator', 'as'    => 'capaian.renstra.fisik.indicator']);
    get('capaian/renstra/fisik/indicator/{indicator}/chart', ['uses'  => 'Period\PhysicAchievementController@getChart', 'as'    => 'capaian.renstra.fisik.indicator.chart']);
    get('capaian/renstra/fisik/target/{target}/year/{year}/chart', ['uses'  => 'Period\PhysicAchievementController@getChartOneYear', 'as'    => 'capaian.renstra.fisik.indicator.chart.year']);
    get('capaian/renstra/fisik/target/{target}/year/{year}/table', ['uses'  => 'Period\PhysicAchievementController@getTableOneYear', 'as'    => 'capaian.renstra.fisik.indicator.table.year']);
    get('capaian/renstra/fisik/target/{target}/year/{year}/quarter', ['uses'  => 'Period\PhysicAchievementController@getTableQuarterOneYear', 'as'    => 'capaian.renstra.fisik.indicator.quarter.year']);
    get('capaian/renstra/anggaran/target/{target}/year/{year}/quarter', ['uses'  => 'Period\PhysicAchievementController@getBudgetTableQuarterOneYear', 'as'    => 'capaian.renstra.anggaran.indicator.quarter.year']);

    get('capaian/renstra/anggaran/filter', ['uses'  => 'Period\BudgetAchievementController@getFilter', 'as'    => 'capaian.renstra.anggaran.filter']);
    get('capaian/renstra/anggaran/filter/activity', ['uses'  => 'Period\BudgetAchievementController@getActivity', 'as'    => 'capaian.renstra.anggaran.kegiatan']);
    get('capaian/renstra/anggaran/kegiatan/{kegiatan}/chart', ['uses'  => 'Period\BudgetAchievementController@getChart', 'as'    => 'capaian.renstra.anggaran.kegiatan.chart']);
    get('capaian/renstra/anggaran/program/{program}/year/{year}/chart', ['uses'  => 'Period\BudgetAchievementController@getChartOneYear', 'as'    => 'capaian.renstra.anggaran.kegiatan.chart.year']);
    get('capaian/renstra/anggaran/program/{program}/year/{year}/table', ['uses'  => 'Period\BudgetAchievementController@getTableOneYear', 'as'    => 'capaian.renstra.anggaran.kegiatan.table.year']);

    get('renstra/program/select2', ['uses' => 'Period\BudgetAchievementController@getSelectProgram']);
    get('renstra/activity/select2', ['uses' => 'Period\BudgetAchievementController@getSelectActivity']);
    get('renstra/target/select2', ['uses' => 'Period\BudgetAchievementController@getSelectTarget']);

    get('kegiatan/evaluasi/filter', ['uses' => 'EvaluationController@getFilter', 'as' => 'kegiatan.evaluasi.filter']);
    get('kegiatan/evaluasi', ['uses' => 'EvaluationController@getActivity', 'as' => 'kegiatan.evaluasi']);
    get('kegiatan/evaluasi/data', ['uses' => 'EvaluationController@getDataActivity', 'as' => 'kegiatan.evaluasi.data']);
    get('evaluation/data', ['uses' => 'EvaluationController@data', 'as' => 'evaluasi.data']);
    post('kegiatan/{kegiatan}/pk/{pk}/evaluasi', ['uses' => 'EvaluationController@store', 'as' =>'kegiatan.agreement.evaluasi.store']);
    resource('kegiatan.evaluasi', 'EvaluationController', ['except' => ['store']]);

    /**
     * Struktur organisasi
     */
    get('structure/parents', ['uses' => 'OrganizationStructureController@refreshParents', 'as' => 'structure.parent' ]);
    get('structure/data', ['uses' => 'OrganizationStructureController@data', 'as' => 'structure.data' ]);
    resource('structure', 'OrganizationStructureController', []);

    /**
     * SDM User
     */
    get('sdm/data', ['uses' => 'SdmController@data', 'as' => 'sdm.data' ]);
    resource('sdm', 'SdmController', ['except' => 'show']);

    /**
     * Education sdm/staff
     */
    get('sdm.education/data', ['uses' => 'EducationController@data', 'as' => 'sdm.education.data' ]);
    resource('sdm.education', 'EducationController');

    /**
     * SDM report
     */
    get('sdm/report', ['uses' => 'StaffReportController@index', 'as' => 'sdm.report.index']);
    get('sdm/report/export', ['uses' => 'StaffReportController@getExport', 'as' => 'sdm.report.export']);
    get('sdm/report/filter', ['uses' => 'StaffReportController@filter', 'as' => 'sdm.report.filter']);

    /**
     * Profile editing
     */
    get('profile', ['uses' => 'ProfileController@index', 'as' => 'profile.index']);

    // ganti nama, email, username
    put('profile', ['uses' => 'ProfileController@update', 'as' => 'profile.update']);
    put('profile/password', ['uses' => 'ProfileController@putPassword', 'as' => 'profile.password.update']);

});

Route::controller('error','Privy\ErrorController');


Route::get('/{slug}', ['uses' => 'Common\LandingController@page', 'as' => 'public.page']);
