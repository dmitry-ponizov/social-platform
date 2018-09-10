<?php

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index')->name('users');
        Route::get('/create', 'UserController@create')->name('user.create');
        Route::post('/store', 'UserController@store')->name('user.store');
        Route::get('/edit/{id}', 'UserController@edit')->name('user.edit');
        Route::get('/delete/{id}', 'UserController@destroy')->name('user.delete');
        Route::post('/update/{id}', 'UserController@update')->name('user.update');
        Route::get('/edit-roles/{id}', 'UserController@editRoles')->name('user.edit.roles');
        Route::post('/roles-update/{id}', 'UserController@updateRoles')->name('user.roles.update');
        Route::get('/edit-permissions/{id}', 'UserController@editPermissions')->name('user.edit.permissions');
        Route::post('/permissions-update/{id}', 'UserController@updatePermissions')->name('user.permissions.update');
        Route::get('/detail/{id}', 'UserController@show')->name('user.show.details');
        Route::post('/rules/accept/{id}', 'UserController@acceptRules')->name('user.rules.accept');
        Route::get('/volunteers', 'UserController@getVolunteers')->name('volunteers');
        Route::get('/volunteer-edit/{id}', 'UserController@volunteerEdit')->name('volunteer.edit');
    });

    Route::group(['prefix' => 'organizations'], function () {
        Route::get('/', 'OrganizationController@index')->name('organizations');
        Route::get('/create', 'OrganizationController@create')->name('organizations.create');
        Route::get('/edit/{id}', 'OrganizationController@edit')->name('organizations.edit');
        Route::get('/show/{id}', 'OrganizationController@show')->name('organizations.show');
        Route::post('/update/{id}', 'OrganizationController@update')->name('organizations.update');
        Route::post('/store', 'OrganizationController@store')->name('organizations.store');
        Route::get('/block/{id}', 'OrganizationController@block')->name('organizations.block');
        Route::get('/statement-create/{id}', 'OrganizationController@createStatement')->name('organization.statement.create');
        Route::post('/statement/store', 'OrganizationController@statementStorestatementStore')->name('organizations.statement.store');
        Route::get('/statements/{id}', 'OrganizationController@getOrganizationStatements')->name('organizations.statements');

        Route::get('/events', 'OrganizationEventController@all')->name('organization.all.events');
        Route::post('/events/image/update', 'OrganizationEventController@updateImage')->name('organization.events.update.image');
        Route::patch('/events/update', 'OrganizationEventController@updateBody');
        Route::post('/events/image/create', 'OrganizationEventController@addImage')->name('organization.events.create.image');

        Route::group(['prefix' => '{organization}/events'], function () {
            Route::get('/create', 'OrganizationEventController@create')->name('organization.event.create');
            Route::get('/', 'OrganizationEventController@index')->name('organizations.events');
            Route::delete('/{id}/delete', 'OrganizationEventController@destroy')->name('organization.event.delete');
            Route::get('/{id}/edit', 'OrganizationEventController@edit')->name('organization.event.edit');
            Route::post('/', 'OrganizationEventController@store')->name('organization.event.store');
        });

    });

    Route::group(['prefix' => 'role'], function () {
        Route::get('/', 'RoleController@index')->name('roles');
        Route::get('/edit/{id}', 'RoleController@edit')->name('role.edit');
        Route::get('/delete/{id}', 'RoleController@destroy')->name('role.delete');
        Route::get('/create', 'RoleController@create')->name('role.create');
        Route::post('/store', 'RoleController@store')->name('role.store');
        Route::post('/update/{id}', 'RoleController@update')->name('role.update');
        Route::get('/edit-users/{id}', 'RoleController@editUsers')->name('role.edit.users');
        Route::post('/users-update/{id}', 'RoleController@updateUsers')->name('role.users.update');
        Route::post('/permissions-update/{id}', 'RoleController@updatePermissions')->name('role.permissions.update');
        Route::get('/edit-permissions/{id}', 'RoleController@editPermissions')->name('role.edit.permissions');
    });

    Route::group(['prefix' => 'permission'], function () {
        Route::get('/', 'PermissionController@index')->name('permissions');
        Route::get('/edit/{id}', 'PermissionController@edit')->name('permission.edit');
        Route::get('/delete/{id}', 'PermissionController@destroy')->name('permission.delete');
        Route::get('/create', 'PermissionController@create')->name('permission.create');
        Route::post('/update/{id}', 'PermissionController@update')->name('permission.update');
        Route::post('/store', 'PermissionController@store')->name('permission.store');
        Route::get('/edit-users/{id}', 'PermissionController@editUsers')->name('permission.edit.users');
        Route::post('/users-update/{id}', 'PermissionController@updateUsers')->name('permission.users.update');
        Route::post('/roles-update/{id}', 'PermissionController@updateRoles')->name('permission.roles.update');
        Route::get('/edit-roles/{id}', 'PermissionController@editRoles')->name('permission.edit.roles');
    });

    Route::group(['prefix' => 'statement'], function () {
        Route::get('/', 'StatementController@index')->name('statements');
        Route::get('/edit/{id}', 'StatementController@edit')->name('statement.edit');
        Route::get('/show/{id}/{notification?}', 'StatementController@show')->name('statement.show');
        Route::get('/delete/{id}', 'StatementController@destroy')->name('statement.delete');
        Route::post('/update/{id}', 'StatementController@update')->name('statement.update');
        Route::get('/publish/{id}', 'StatementController@publish')->name('statement.publish');
        Route::get('/no-publish/{id}', 'StatementController@noPublish')->name('statement.no.publish');
        Route::post('/accept/{id}', 'StatementController@accept')->name('statement.accept');
        Route::post('/close/{id}', 'StatementController@close')->name('statement.close');
        Route::get('/rules/{id}', 'StatementController@showRules')->name('statement.rules.show');
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'CategoryController@index')->name('categories');
        Route::get('/edit/{id}', 'CategoryController@edit')->name('category.edit');
        Route::get('/create', 'CategoryController@create')->name('category.create');
        Route::get('/view-statements/{id}', 'CategoryController@viewStatements')->name('category.view.statements');
        Route::get('/delete/{id}', 'CategoryController@destroy')->name('category.delete');
        Route::get('/create', 'CategoryController@create')->name('category.create');
        Route::post('/store', 'CategoryController@store')->name('category.store');
        Route::post('/update/{id}', 'CategoryController@update')->name('category.update');
        Route::get('/edit-rules/{id}', 'CategoryController@editRules')->name('category.edit.rules');
        Route::post('/rules-update/{id}', 'CategoryController@updateRules')->name('category.rules.update');
        Route::post('/publish', 'CategoryController@publish')->name('category.publish');

    });

    Route::group(['prefix' => 'subcategories'], function () {
	    Route::get('/{slug}/create', 'SubCategoryController@create')->name('subcategories.create');
	    Route::get('/{slug}', 'SubCategoryController@index')->name('subcategories');
	    Route::post('/store/{slug}', 'SubCategoryController@store')->name('subcategories.store');
	    Route::get('/edit/{slug}', 'SubCategoryController@edit')->name('subcategory.edit');
	    Route::patch('/update/{slug}', 'SubCategoryController@update')->name('subcategory.update');
    });

    Route::group(['prefix' => 'slider'], function () {
        Route::get('/', 'SliderController@index')->name('sliders');
        Route::get('/create', 'SliderController@create')->name('slider.create');
        Route::get('/edit/{id}', 'SliderController@edit')->name('slider.edit');
        Route::get('/delete/{id}', 'SliderController@destroy')->name('slider.delete');
        Route::post('/store', 'SliderController@store')->name('slider.store');
        Route::post('/update/{id}', 'SliderController@update')->name('slider.update');
    });

    Route::group(['prefix' => 'offer'], function () {
        Route::get('/', 'OfferController@index')->name('offers');
        Route::get('/edit/{id}', 'OfferController@edit')->name('offer.edit');
        Route::get('/show/{id}', 'OfferController@show')->name('offer.show');
        Route::get('/delete/{id}', 'OfferController@destroy')->name('offer.delete');
        Route::post('/update/{id}', 'OfferController@update')->name('offer.update');
        Route::get('/publish/{id}', 'OfferController@publish')->name('offer.publish');
        Route::get('/no-publish/{id}', 'OfferController@noPublish')->name('offer.no.publish');
        Route::post('/accept/{id}', 'OfferController@accept')->name('offer.accept');
        Route::post('/close/{id}', 'OfferController@close')->name('offer.close');
    });

    Route::group(['prefix' => 'rule'], function () {
        Route::get('/', 'RuleController@index')->name('rules');
        Route::get('/create', 'RuleController@create')->name('rule.create');
        Route::get('/create', 'RuleController@create')->name('rule.create');
        Route::post('/store', 'RuleController@store')->name('rule.store');
        Route::get('/edit-categories/{id}', 'RuleController@editCategories')->name('rule.edit.categories');
        Route::get('/edit/{id}', 'RuleController@edit')->name('rule.edit');
        Route::get('/delete/{id}', 'RuleController@destroy')->name('rule.delete');
        Route::post('/categories/{id}', 'RuleController@updateCategories')->name('rule.categories.update');
        Route::post('/update/{id}', 'RuleController@update')->name('rule.update');
        Route::get('/group-edit/{id}', 'RuleController@groupEdit')->name('rule.group.edit');
    });

    Route::group(['prefix' => 'group'], function () {
        Route::get('/', 'GroupController@index')->name('groups');
        Route::get('/create', 'GroupController@create')->name('group.create');
        Route::post('/store', 'GroupController@store')->name('group.store');
        Route::get('/edit/{id}', 'GroupController@edit')->name('group.edit');
        Route::get('/delete/{id}', 'GroupController@destroy')->name('group.delete');
        Route::post('/update/{id}', 'GroupController@update')->name('group.update');
        Route::get('/edit-rules/{id}', 'GroupController@editRules')->name('group.edit.rules');
        Route::get('/show-subgroups/{id}', 'GroupController@showSubgroups')->name('subgroups');
        Route::post('/rules-groups-update/{id}', 'GroupController@rulesGroupsUpdate')->name('rules.groups.update');
        Route::post('/update/{id}', 'GroupController@update')->name('group.update');
        Route::get('/delete/{id}', 'GroupController@destroy')->name('group.delete');
        Route::get('/edit-subgroups/{id}', 'GroupController@editSubgroups')->name('group.edit.subgroup');
        Route::post('/subgroup-update/{id}', 'GroupController@subgroupUpdate')->name('subgroup.update');
        Route::get('/create-subgroup/{id}', 'GroupController@createSubgroup')->name('create.subgroup');
        Route::post('/store-subgroup', 'GroupController@storeSubgroup')->name('subgroup.store');
    });

    Route::group(['prefix' => 'social-service'], function () {
        Route::get('/', 'SocialServiceController@index')->name('social_services');
        Route::get('/create', 'SocialServiceController@create')->name('social_service.create');
        Route::post('/store', 'SocialServiceController@store')->name('social_service.store');
        Route::get('/show/{id}', 'SocialServiceController@show')->name('show.social_service');
        Route::get('/create-co-work/{id}', 'SocialServiceController@createCoWork')->name('create.co_work');
        Route::post('/store-co-work/{id}', 'SocialServiceController@storeCoWork')->name('social_service.store.co_work');
        Route::get('/edit/{id}', 'SocialServiceController@edit')->name('edit.social_service');
        Route::post('/update/{id}', 'SocialServiceController@update')->name('social_service.update');
        Route::get('/statement-create/{id}', 'SocialServiceController@createStatement')->name('social_service.statement.create');
    });

    Route::group(['prefix' => 'volunteers'], function () {
        Route::get('/create/{id}', 'VolunteersController@create')->name('volunteer.create');
        Route::post('/store/{id}', 'VolunteersController@store')->name('volunteer.store');
        Route::post('/update', 'VolunteersController@update')->name('volunteer.update');
        Route::post('/count-update', 'VolunteersController@countUpdate')->name('volunteer.count.update');
        Route::post('/become_volunteer', 'VolunteersController@becomeVoluteer')->name('become_volunteer.update');
    });

    Route::group(['prefix' => 'footer'], function () {
        Route::post('/update-company', 'FooterController@updateCompany')->name('footer.update.company');
        Route::post('/update-news', 'FooterController@updateNews')->name('footer.update.news');
        Route::post('/update-links', 'FooterController@updateLinks')->name('footer.update.userful_links');
        Route::post('/update-contacts', 'FooterController@updateContacts')->name('footer.update.contacts');
        Route::post('/update-bottom', 'FooterController@updateBottom')->name('footer.update.bottom');

    });

    Route::group(['prefix' => 'partners'], function () {
        Route::get('/', 'PartnerController@index')->name('partners');
        Route::get('/create', 'PartnerController@create')->name('partners.create');
        Route::post('/', 'PartnerController@store')->name('partners.store');
        Route::get('/show/{slug}', 'PartnerController@show')->name('partners.show');
        Route::get('/publish/{slug}', 'PartnerController@publish')->name('partners.publish');
        Route::get('/edit/{slug}', 'PartnerController@edit')->name('partners.edit');
        Route::patch('/update/{slug}', 'PartnerController@update')->name('partners.update');
        Route::post('/update/settings/', 'PartnerController@updateSettings')->name('partners.settings.update');
        Route::post('/update/slides/', 'PartnerController@updateCountSlidesSettings')->name('partners.count.slides.update');
        Route::delete('/delete/{slug}', 'PartnerController@delete')->name('partners.delete');

    });


    Route::get('/dashboard', 'AdminController@index')->name('admin.main');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('/substatement/show/{id}', 'StatementController@showSubstatement')->name('show.substatement');
    Route::post('/donate/update', 'DonateController@update')->name('quick_donate.update');
    Route::get('/global', 'SettingsController@index')->name('global');
    Route::get('/pages', 'SettingsController@index')->name('pages');
    Route::get('/page/elements/{slug}', 'SettingsController@elements')->name('page.elements');
    Route::get('/element/content/{slug}', 'SettingsController@getContent')->name('element.content');
    Route::get('/state/show/{element}/{mod}', 'SettingsController@stateShow')->name('state.show');
    Route::get('/state/hide/{element}/{mod}', 'SettingsController@stateHide')->name('state.hide');
    Route::get('/edit/element/{element}/{mod}', 'SettingsController@edit')->name('edit.element');
    Route::post('/update/banner-left', 'BannerController@updateLeft')->name('banner.update.left');
    Route::post('/update/banner-right', 'BannerController@updateRight')->name('banner.update.right');
    Route::post('/welcome/update', 'WelcomeBlockController@update')->name('welcome.update');
    Route::post('/actions/update/{mod}', 'ActionsBlockController@update')->name('actions.update');
    Route::post('/service/update', 'ServiceController@update')->name('service.update');
    Route::post('/statistics/update/{mod}', 'StatisticsController@update')->name('statistics.update');
    Route::post('/finance/update', 'FinanceController@update')->name('finance.update');
    Route::post('/finance/statement-update', 'FinanceController@updateStatement')->name('finance.statement.update');
    Route::post('/header/update', 'HeaderController@update')->name('header.update');

    Route::post('/mark-as-read', 'NotificationController@markIsRead');

});
