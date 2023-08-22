<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Avl', 'middleware' => 'skcn.admin'], function () {

    Route::group(['namespace' => 'Ajax', 'prefix' => 'ajax'], function () {
      Route::post('good', 'DefaultController@good');
      Route::post('change-area/{area}', 'DefaultController@changeArea');
      Route::post('change-switch', 'DefaultController@changeSwitch');
      Route::post('menu', 'DefaultController@menu');
      Route::post('change-order', 'DefaultController@changeOrder');
      Route::post('/fixedNews/{id}', 'DefaultController@fixedNews');
      Route::post('/mainPhoto/{id}', 'DefaultController@mainPhoto');
      Route::post('/mainPhotoGallery/{id}', 'DefaultController@mainPhotoGallery');

      Route::post('/change-news-date/{id}', 'NewsController@changeNewsDate');
      Route::post('/add-area-sections/{id}', 'NewsController@addSelectStructures');

      Route::post('/saveVideoLink', 'DefaultController@saveVideoLink');
      Route::post('/saveObjectVideoLink', 'DefaultController@saveObjectVideoLink');
      Route::post('/addGalleryVideo', 'DefaultController@addGalleryVideo');
      Route::post('/updateVideoLink/{id}', 'DefaultController@updateVideoLink');
      Route::post('/deleteVideo/{id}', 'DefaultController@deleteVideo');
      Route::post('/change-file-lang/{id}', 'DefaultController@changeFileLang');

      Route::post('check', 'CheckController@index');
      Route::post('profile', 'UploadController@profile'); // For profile

      Route::post('news-images', 'ImageController@newsImages');
			Route::post('object-images', 'ImageController@objectImages');
      Route::post('news-images/{id}', 'ImageController@imageUpdate');    // этот метод как для новостей, так и для объектов

			Route::post('page-images', 'ImageController@pageImages');
			Route::post('page-images/{id}', 'ImageController@pageUpdate');
			Route::post('page-images-panel/{id}', 'ImageController@changePanel');

      Route::post('/deleteMedia/{id}', 'DefaultController@deleteMedia');
      Route::post('/deleteMediaGallery/{id}', 'DefaultController@deleteMediaGallery');
      Route::get('{id}/media-sortable', 'SortableController@mediaSortable');
			Route::get('{id}/objects-media-sortable', 'SortableController@objectsMediaSortable');
      Route::get('{id}/gallery-sortable', 'SortableController@gallerySortable');
      Route::post('links_photo', 'ImageController@links_photo');
      Route::post('/deletePhotoLinks/{id}', 'DefaultController@deletePhotoLinks');

      Route::post('news-files', 'FilesController@newsFiles');
      Route::post('saveFileName/{id}', 'FilesController@saveFileName');
			Route::post('object-files', 'FilesController@objectFiles');
      // Route::post('saveFileName/{id}', 'FilesController@saveFileName');

      Route::post('rubrics-files', 'FilesController@rubricsFiles');
      Route::post('rubrics-images', 'ImageController@rubricImages');

      // Gallery
      Route::post('gallery-images', 'ImageController@galleryImages');
      Route::post('gallery-images/{id}', 'ImageController@imageUpdate');
    });

    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        Route::get('login',  ['as' => 'login', 'uses' => 'AuthController@login']);
        Route::post('login', ['uses' => 'AuthController@auth']);
        Route::get('logout', ['uses' => 'AuthController@logout']);
    });

    Route::group(['middleware' => ['admin']], function() {
        Route::get('/', 'HomeController@index')->name('home');
        Route::match(['get','post'], 'importer', 'Settings\Sections\NewsController@importer')->name('importer');

        Route::get('/phpinfo', function () { dd(phpinfo()); });

        Route::group(['namespace' => 'SiteSettings', 'prefix' => 'site-settings'], function() {
          Route::resource('settings', 'SettingsController');
          Route::get('/rubrics/lists', 'RubricsController@lists')->name('admin.site.settings.rubrics.lists');
          Route::resource('{id}/rubrics', 'RubricsController', ['as' => 'admin.site.settings']);
        });

        Route::group(['namespace' => 'Settings', 'prefix' => 'settings'], function() {
          Route::resource('langs', 'LangsController');
          Route::post('langs/refresh', 'LangsController@refresh');
          Route::resource('roles', 'RolesController', ['as' => 'admin.settings']);
          Route::resource('users', 'UsersController');
          Route::post('templates/get-files', 'TemplatesController@getTemplatesFiles')->name('templates.files');
          Route::post('templates/get-templates', 'TemplatesController@getTemplates');
          Route::resource('templates', 'TemplatesController', ['as' => 'admin.settings']);
          Route::resource('sections', 'SectionsController', ['as' => 'admin.settings']);
          Route::resource('profile', 'ProfileController');

          Route::group(['namespace' => 'Configurations'], function() {
            Route::get('sections/configuration/{id}', 'SectionsController@index')->name('admin.settings.sections.configuration');
            Route::post('sections/configuration/{id}', 'SectionsController@save')->name('admin.settings.sections.configuration.save');

            Route::resource('areas', 'AreasController', ['as' => 'admin.settings.configurations']);
          });

          Route::group(['namespace' => 'Sections'], function() {
            Route::resource('sections/{id}/page', 'PagesController');
            Route::get('sections/{id}/news/move/{nws}', 'NewsController@move')->name('admin.settings.sections.news.move');
            Route::post('sections/{id}/news/move/{nws}', 'NewsController@moveSave')->name('admin.settings.sections.news.move.save');
            Route::resource('sections/{id}/news', 'NewsController');
            Route::resource('sections/{id}/gallery', 'GalleriesController', ['as' => 'admin.settings.sections']);
            Route::resource('sections/{id}/services', 'ServicesController', ['as' => 'admin.settings.sections']);
            Route::resource('sections/{id}/gb', 'GbController', ['as' => 'admin.settings.sections']);
            Route::resource('sections/{id}/link', 'LinkController');
            Route::resource('sections/{id}/links', 'LinksController');
            Route::resource('sections/{id}/report', 'ReportController', ['as' => 'admin.settings.sections']);
            Route::resource('sections/{id}/objects', 'ObjectsController', ['as' => 'admin.settings.sections']);
						Route::resource('sections/{id}/calculator', 'CalculatorController');
						Route::get('sections/{id}/calculator/{complex_id}/apartment', 'CalculatorController@apartment_index')->name('calculator.apartment_index');
						Route::get('sections/{id}/calculator/{complex_id}/apartment/create', 'CalculatorController@apartment_create')->name('calculator.apartment_create');
						Route::post('sections/{id}/calculator/{complex_id}/apartment', 'CalculatorController@apartment_store')->name('calculator.apartment_store');
						Route::get('sections/{id}/calculator/{complex_id}/apartment/{apartment_id}/edit', 'CalculatorController@apartment_edit')->name('calculator.apartment_edit');
						Route::put('sections/{id}/calculator/{complex_id}/apartment/{apartment_id}', 'CalculatorController@apartment_update')->name('calculator.apartment_update');
						Route::delete('sections/{id}/calculator/{complex_id}/apartment/{apartment_id}', 'CalculatorController@apartment_destroy')->name('calculator.apartment_destroy');

						Route::get('sections/{id}/polls/get-records/{parent?}', 'PollsController@getRecords')->name('admin.settings.sections.polls.getRecords');
						Route::resource('sections/{id}/polls', 'PollsController', ['as' => 'admin.settings.sections']);
          });
        });

    });

    Route::group(['namespace' => 'Excell', 'prefix' => 'excell'], function () {

    });
});

Route::group(['prefix' => 'image', 'namespace' => 'Image'], function () {
  Route::get('resize/{w}/{h}/{path}', 'ImageController@resize')->where('path', '(.*)');
});

Route::group(['prefix' => 'file', 'namespace' => 'Image'], function () {
  Route::get('save/{id}', 'ImageController@save');
});
