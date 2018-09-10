<?php

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'organizations'], function () {
        Route::get('/', 'OrganizationController@index');
        Route::post('/create-document', 'OrganizationController@createDocument');
        Route::post('/image-delete', 'OrganizationController@deleteDocumentPage');
        Route::post('/update-document', 'OrganizationController@updateDocument');
        Route::post('/add-document', 'OrganizationController@addDocument');
        Route::post('/add-category', 'OrganizationController@addCategory');
        Route::post('/delete-category', 'OrganizationController@deleteCategory');
        Route::post('/volunteer-register', 'OrganizationController@createVolunteer');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/{name?}', 'UserController@personalArea');
        Route::post('/update-one-field', 'UserController@updateOneField')->name('user.update.one');
        Route::post('/information-update', 'UserController@updateAllInformation')->name('user.information.update');
        Route::post('/change-avatar', 'UserController@changeAvatar')->name('user.change.avatar');
        Route::post('/get-rules', 'UserController@getRules');
        Route::post('/file-update', 'UserController@fileUpdate');
        Route::post('/add-category', 'UserController@addCategory');
        Route::post('/search', 'UserController@search');
        Route::get('/publish/{id}', 'UserController@userPublish')->name('user.publish');
        Route::post('/register', 'UserController@register');
        Route::get('/block/{id}', 'UserController@userBlock')->name('user.block');
    });

    Route::group(['prefix' => 'statement'], function () {
        Route::get('/create', 'StatementController@create')->name('statement.create');
        Route::post('/store', 'StatementController@store')->name('statement.store');
        Route::post('/store-rules', 'StatementController@storeRules')->name('statement.store.rules');
        Route::post('/rules', 'StatementController@rules')->name('statement.rules');
        Route::post('/store-social', 'StatementController@storeSocialService');
        Route::post('/add-image', 'StatementController@addImage');
        Route::post('/update-image', 'StatementController@updateImage');
        Route::post('/store-organization', 'StatementController@storeOrganization');
        Route::post('/get-child-uuid', 'StatementController@getChildFromUuid');
        Route::post('/get-uuid', 'StatementController@getFromUuid');
        Route::post('/user-statements', 'StatementController@getUserStatements');
        Route::post('/get-statement', 'StatementController@getStatement');
        Route::post('/field-update', 'StatementController@fieldUpdate');
        Route::post('/update-status', 'StatementController@statusUpdate');
        Route::get('/social-statements', 'StatementController@socialStatements');
        Route::get('/history/{uuid}', 'StatementController@history');
        Route::post('/write-admin', 'StatementController@writeAdmin');
        Route::post('/statistics', 'StatementController@statistics');
        Route::get('/no-accepted-organization', 'StatementController@noAcceptedOrganization');
        Route::get('/no-accepted', 'StatementController@noAccepted');
        Route::get('/accepted', 'StatementController@accepted');
        Route::get('/closed', 'StatementController@closed');
        Route::post('/statement/review', 'StatementController@review');
        Route::get('/get-users', 'StatementController@getUsers');
    });

    Route::group(['prefix' => 'organization'], function () {
        Route::post('/save-field', 'OrganizationController@saveField');
        Route::post('/change-logo', 'OrganizationController@changeLogo');
        Route::post('/save-info', 'OrganizationController@saveInfo');
        Route::get('/show/{organization}', 'OrganizationController@details');

    });

    Route::group(['prefix' => 'activity'], function () {
        Route::get('/history', 'ActivityController@getHistory');
        Route::post('/statistics', 'ActivityController@getStatistics');
        Route::post('/social-service-statistics', 'ActivityController@socialServiceStatistic');
    });

    Route::group(['prefix' => 'main'], function () {
        Route::post('/area', 'MainController@areas')->name('main.areas');
        Route::post('/city', 'MainController@cities')->name('main.cities');
        Route::post('/street', 'MainController@streets')->name('main.streets');
    });

    Route::group(['prefix' => 'offer'], function () {
        Route::get('/create', 'OfferController@create')->name('offer.create');
        Route::post('/store', 'OfferController@store')->name('offer.store');
    });

    Route::group(['prefix' => 'social-service'], function () {
        Route::post('/save-field', 'SocialServiceController@saveField')->name('social_service.save.field');
        Route::post('/save-info', 'SocialServiceController@saveInfo')->name('social_service.save.info');
        Route::post('/worker-register', 'SocialServiceController@workerRegistration');
    });

    Route::post('/sub/store-organization', 'StatementController@storeSubOrganization');
    Route::get('/personal/{name?}/{uuid?}', 'UserController@personalArea');
    Route::post('/get-roles', 'RoleController@getRoles');
    Route::post('/get-categories', 'CategoryController@getCategories');

});
Route::group(['prefix' => 'statements'], function () {
    Route::get('/pagination', 'StatementController@pagination')->name('statements.pagination');
    Route::get('/search', 'StatementController@statementsSearch');
    Route::get('/categories', 'StatementController@categoriesStatements');
});
Route::get('/organizations', 'OrganizationController@getList');
Route::get('/statement/{id}', 'StatementController@showStatement');
Route::get('/donate/{id?}', 'DonateController@index')->name('donate');
Route::get('/running-statements', 'StatementController@getStatements')->name('running.statements');
Route::post('/category/statements', 'CategoryController@showStatements');
Route::post('/main/become-volunteer', 'MainController@becomeVolunteer');
Route::get('/volunteer/{uuid}', 'VolunteersController@show');