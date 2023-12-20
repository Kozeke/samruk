<?php

/*
|--------------------------------------------------------------------------
| AJAX Routes
|--------------------------------------------------------------------------
*/


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localizationRedirect']], function() {
    //печать пдф обращении
    Route::post('print-pdf', 'Site\Cabinet\CabinetController@downloadPdfAppeal');

    Route::post('send-appeal-template', 'Site\Cabinet\CabinetController@sendAppealTemplate');
    Route::post('sign-document', 'Site\Cabinet\CabinetController@signDocument');
    Route::post('save-consent', 'Site\Cabinet\CabinetController@saveConsentToDataCollectionAsCms');


    Route::group(['namespace' => 'Site\Ajax', 'prefix' => 'ajax'], function () {

        Route::post('reception/{id?}', 'ReceptionController@reception')->name('site.ajax.reception');

        Route::post('profile-photo', 'ProfileController@profilePhoto')->name('site.ajax.profilePhoto');

      /* Пути для калькулятора */
        Route::post('get-purchase', 'CalculatorController@getPurchase')->name('site.ajax.getPurchase');
        Route::post('get-apartments', 'CalculatorController@getApartments')->name('site.ajax.getApartments');
        Route::post('get-apartments-cost', 'CalculatorController@getApartmentsCost')->name('site.ajax.getApartmentsCost');
        Route::post('calculate', 'CalculatorController@calculate')->name('site.ajax.calculate');

    });



});
