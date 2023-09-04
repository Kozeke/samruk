<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/_debugbar/assets/stylesheets', [
    'as' => 'debugbar-css',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@css'
]);

Route::get('/_debugbar/assets/javascript', [
    'as' => 'debugbar-js',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@js'
]);

Route::get('appeal',['uses' => 'Site\Cabinet\Appeal\AppealController@index']);
Route::post('/get/appeal',['uses' => 'Site\Cabinet\Appeal\AppealController@getAppeal']);
Route::post('/view/appeal',['uses' => 'Site\Cabinet\Appeal\AppealController@viewAppeal']);
Route::get('/view/appeal-history',['uses' => 'Site\Cabinet\Appeal\AppealController@getAppealHistory'])->name('appeal.history');
Route::post('/edit/appeal',['uses' => 'Site\Cabinet\Appeal\AppealController@editAppeal']);
Route::post('/print/appeal',['uses' => 'Site\Cabinet\Appeal\AppealController@downloadPdf']);
Route::post('/cabinet/users/excel', 'Site\Cabinet\CabinetController@exportExcelOfUsers')->name('cabinet.download-users-excel');

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localizationRedirect']], function () {

    Route::group(['prefix' => 'auth', 'namespace' => 'Site'], function () {
        Route::get('/', ['uses' => 'AuthController@index'])->name('auth.index');
        Route::get('/ecp', ['uses' => 'AuthController@ecp'])->name('auth.ecp');
        Route::post('login', ['uses' => 'AuthController@auth'])->name('auth.login');
        Route::post('login/ecp', ['uses' => 'AuthController@authEcp'])->name('auth.login.ecp');
        Route::get('/sms', ['uses' => 'AuthController@sms'])->name('sms.auth');
        Route::post('login/sms/generate', ['uses' => 'AuthController@generateAndSendOTP'])->name('sms.generate');
        Route::get('/sms/verification/{user_id}', ['uses' => 'AuthController@verificationSMS'])->name('sms.verification');
        Route::post('login/otp', ['uses' => 'AuthController@loginWithOTP'])->name('auth.login.otp');
        Route::get('consent/data', ['uses' => 'AuthController@checkConsentToDataCollection'])->name('consent.data');
        Route::post('consent/data', ['uses' => 'AuthController@agreeConsentToDataCollection'])->name('consent.data');
        Route::get('logout', ['uses' => 'AuthController@logout'])->name('auth.logout');
    });

    Route::group(['namespace' => 'Site\Registrations', 'prefix' => 'registrations'], function () {
        Route::get('/', 'RegistrationsController@index')->name('registrations.index');
        Route::post('/', 'RegistrationsController@register')->name('registrations.register');
        Route::get('/verify-{verify}', 'RegistrationsController@verify')->where('verify', '(.*)');

        Route::get('/restore', 'RegistrationsController@restore')->name('registrations.restore');
        Route::post('/restore-post', 'RegistrationsController@restore_post')->name('registrations.restore.post');

        Route::get('/restore/verify-{verify}', 'RegistrationsController@update')->name('registrations.restore.update')->where('verify', '(.*)');
        Route::post('/restore/verify-{verify}', 'RegistrationsController@save_new_password')->name('registrations.restore.save_pass')->where('verify', '(.*)');
    });

    Route::group(['namespace' => 'Site'], function () {
        Route::get('/', 'IndexController@index')->name('site.home');

        // Для RSS
        Route::get('rss/{id?}', 'Feed\RssController@index')->name('site.feed.rss');

        Route::group(['namespace' => 'Sections'], function () {
            Route::get('page/{alias}', 'PageController@index');

            Route::get('news/{alias}/', 'NewsController@index')->name('site.news.index');
            Route::get('news/{alias}/{id}', 'NewsController@show')->name('site.news.show')->where('id', '[0-9]+');
            Route::get('news/{alias}/rubrics', 'NewsController@rubrics')->name('site.news.rubrics');
            Route::get('news/{alias}/rubrics/{rubric}', 'NewsController@rubricsShow')->name('site.news.rubrics.show')->where('rubric', '[0-9]+');

            Route::get('gallery/{alias}', 'GalleryController@index')->name('site.gallery.index');
            Route::get('gallery/{alias}/{id}', 'GalleryController@show')->name('site.gallery.show')->where('id', '[0-9]+');

            Route::get('links/{alias}.json', 'LinksController@indexJson')->name('site.links.indexJson');
            Route::get('links/{alias}', 'LinksController@index')->name('site.links.index');
            Route::get('gb/{alias}', 'GbController@index')->name('site.gb.index');
            Route::post('gb/{alias}', 'GbController@store');

            Route::get('services/{alias}/', 'ServicesController@index')->name('site.services.index');
            Route::get('services/{alias}/{id}', 'ServicesController@show')->name('site.services.show')->where('id', '[0-9]+');
            Route::get('services/{alias}/data', 'ServicesController@data')->name('site.services.data');

            Route::get('search/{alias?}', 'SearchController@index')->name('site.search');

            Route::get('polls/{alias}', 'PollsController@index')->name('site.polls');
            Route::post('polls/{alias}', 'PollsController@store')->name('site.polls.store');

            Route::get('report/{alias}', 'ReportController@index')->name('report.index');
            Route::post('report/{alias}', 'ReportController@store')->name('report.store');

            Route::get('objects/{alias}/', 'ObjectsController@index')->name('site.objects.index');
            Route::get('objects/{alias}/{object}', 'ObjectsController@show')->name('site.objects.show')->where('object', '[0-9]+');

            Route::get('calculator/{alias}/', 'CalculatorController@index')->name('site.calculator.index');
        });



        Route::group(['namespace' => 'Cabinet'], function () {
            Route::get('cabinet/', 'CabinetController@index')->name('cabinet.index');
            Route::get('cabinet/settings', 'CabinetController@settings')->name('cabinet.settings');
            Route::post('cabinet/settings', 'CabinetController@save_pass')->name('cabinet.save_pass');
            Route::get('cabinet/{id}', 'CabinetController@show')->name('cabinet.show');
            Route::post('cabinet', 'CabinetController@saveRelevantProfileData')->name('cabinet.check-profile-relevance');

            Route::get('cabinet/{id}/check_grafic', 'CabinetController@CheckGrafic')->name('cabinet.checkgrafic');
            Route::get('cabinet/{id}/check_grafic/pdf', 'CabinetController@GraficPDF')->name('cabinet.checkgrafic.pdf');
            Route::get('cabinet/{id}/check_dolg', 'CabinetController@CheckDolg')->name('cabinet.checkdolg');
            Route::get('cabinet/{id}/check_akt', 'CabinetController@CheckAkt')->name('cabinet.checkakt');
            Route::get('cabinet/{id}/check_pv', 'CabinetController@CheckPV')->name('cabinet.checkpv');
            Route::get('cabinet/{id}/check_chdp', 'CabinetController@CheckCHDP')->name('cabinet.checkchdp');

//            Route::get('cabinet/{id}/feedback', 'CabinetController@feedback')->name('cabinet.feedback');
            Route::get('cabinet/{id}/feedback_template', 'CabinetController@feedback_template')->name('cabinet.feedback');
            Route::get('cabinet/{id}/feedback_template/view', 'CabinetController@view_template');
            Route::post('cabinet/{id}/feedback_template/print', 'CabinetController@feedback_template_print_pdf');
            Route::post('cabinet/{id}/feedback_send', 'CabinetController@feedback_send')->name('cabinet.feedback.send');
            Route::post('cabinet/{id}/feedback_send/appeal/pdf', 'Appeal\AppealController@downloadPdf')->name('cabinet.feedback.send');
        });
    });

});
