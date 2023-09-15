<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

//webhook receiver

Route::any('webhook/call-activity', 'CallActivityController@store')->name('webhook.ca.store');
Route::any('webhook/followup-conducted', 'FollowupConductedController@store')->name('webhook.fc.store');
Route::any('webhook/followup-scheduled', 'FollowupScheduledController@store')->name('webhook.fs.store');
Route::any('webhook/new-lead', 'NewLeadController@store')->name('webhook.nl.store');
Route::any('webhook/note-activity', 'NoteActivityController@store')->name('webhook.na.store');
Route::any('webhook/site-visit-conducted', 'SiteVisitConductedController@store')->name('webhook.svc.store');
Route::any('webhook/site-visit-scheduled', 'SiteVisitScheduledController@store')->name('webhook.svs.store');

Route::any('webhook/{secret}', 'Admin\WebhookReceiverController@processor')->name('webhook.processor');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

    Route::post('store-global-client-filters', 'HomeController@storeGlobalClientFilters')
        ->name('store.global.client.filter');
        
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('incoming-webhook/list', 'WebhookReceiverController@incomingWebhookList')->name('webhook.incoming.list');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::get('users/{id}/edit-password', 'UsersController@editPassword')
        ->name('users.edit.password');
    Route::put('users/{id}/update-password', 'UsersController@updatePassword')
        ->name('users.update.password');
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Project
    Route::get('project-additional-fields', 'ProjectController@getAdditionalFieldsDropdown')->name('projects.additional.fields');
    Route::get('project-campaigns', 'ProjectController@getCampaignsDropdown')->name('projects.campaigns');
    Route::get('project-campaign-sources', 'ProjectController@getSourceDropdown')->name('projects.campaign.sources');
    Route::get('get-api-constant-row', 'ProjectController@getApiConstantRow')
        ->name('get.api.constant.row.html');
    Route::post('test-webhook', 'ProjectController@postTestWebhook')
        ->name('projects.test.webhook');
    Route::get('get-request-body-row', 'ProjectController@getRequestBodyRow')
        ->name('get.req.body.row.html');
    Route::get('project-webhook-html', 'ProjectController@getWebhookHtml')
        ->name('projects.webhook.html');
    Route::post('store-project-outgoing-webhook', 'ProjectController@saveOutgoingWebhookInfo')
        ->name('project.outgoing.webhook.store');
    Route::get('project/{id}/webhook', 'ProjectController@getWebhookDetails')
        ->name('projects.webhook');
    Route::delete('projects/destroy', 'ProjectController@massDestroy')->name('projects.massDestroy');
    Route::post('projects/media', 'ProjectController@storeMedia')->name('projects.storeMedia');
    Route::post('projects/ckmedia', 'ProjectController@storeCKEditorImages')->name('projects.storeCKEditorImages');
    Route::post('projects/parse-csv-import', 'ProjectController@parseCsvImport')->name('projects.parseCsvImport');
    Route::post('projects/process-csv-import', 'ProjectController@processCsvImport')->name('projects.processCsvImport');
    Route::resource('projects', 'ProjectController');

    // Campaign
    Route::get('get-campaigns', 'CampaignController@getCampaigns')->name('get.campaigns');
    Route::delete('campaigns/destroy', 'CampaignController@massDestroy')->name('campaigns.massDestroy');
    Route::resource('campaigns', 'CampaignController');

    // Leads
    Route::get('leads/export', 'LeadsController@export')->name('leads.export');
    Route::post('send-mass-webhook', 'LeadsController@sendMassWebhook')->name('lead.send.mass.webhook');
    Route::get('lead-details-rows-html', 'LeadsController@getLeadDetailsRows')->name('lead.details.rows');
    Route::get('lead-detail-html', 'LeadsController@getLeadDetailHtml')->name('lead.detail.html');
    Route::delete('leads/destroy', 'LeadsController@massDestroy')->name('leads.massDestroy');
    Route::resource('leads', 'LeadsController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Client
    Route::delete('clients/destroy', 'ClientController@massDestroy')->name('clients.massDestroy');
    Route::post('clients/media', 'ClientController@storeMedia')->name('clients.storeMedia');
    Route::post('clients/ckmedia', 'ClientController@storeCKEditorImages')->name('clients.storeCKEditorImages');
    Route::resource('clients', 'ClientController');

    // Agency
    Route::delete('agencies/destroy', 'AgencyController@massDestroy')->name('agencies.massDestroy');
    Route::resource('agencies', 'AgencyController');

    // Source
    Route::get('source/{id}/webhook', 'SourceController@getWebhookDetails')
        ->name('sources.webhook');
    Route::post('update-email-and-phone-key', 'SourceController@updatePhoneAndEmailKey')->name('update.email.and.phone.key');
    Route::get('get-sources', 'SourceController@getSource')->name('get.sources');
    Route::delete('sources/destroy', 'SourceController@massDestroy')->name('sources.massDestroy');
    Route::resource('sources', 'SourceController');
    
    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
