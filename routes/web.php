<?php
use App\Http\Controllers\Admin\LeadsController;

Route::redirect('/', '/login');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);
Route::group(['prefix' => 'selldo', 'as' => 'selldo.'], function () {
    Route::get('login', 'Selldo\SelldoLoginController@login')->name('login');
    Route::get('form', 'Selldo\LeadsController@selldoform')->name('form.selldoform');
    Route::get('/', 'Selldo\HomeController@index')->name('home');

    Route::post('login', 'Selldo\SelldoLoginController@store');
    Route::post('login', 'Selldo\LeadsController@store')->name('leads.store');
});

Route::group(['prefix' => 'selldo', 'as' => 'selldo.', 'middleware' => ['preventBackHistory', 'selldo']], function () {
    Route::post('logout', 'Selldo\SelldoLoginController@logout')->name('logout');
});
//webhook receiver
Route::any('webhook/selldo/new-lead', 'Admin\WebhookReceiverController@storeNewLead')
    ->name('webhook.store.new.lead');
Route::any('/webhook/selldo/update-lead', 'Admin\WebhookReceiverController@updateLead')
    ->name('webhook.update.lead');
Route::any('/webhook/selldo/lead-profile-updated', 'Admin\WebhookReceiverController@updateProfile')
    ->name('webhook.update.profile');
Route::any('/webhook/selldo/lead-requirement-updated', 'Admin\WebhookReceiverController@updateRequirement')
    ->name('webhook.update.requirement');
Route::any('/webhook/selldo/stage-changed', 'Admin\WebhookReceiverController@updateStage')
    ->name('webhook.update.stage');
Route::any('/webhook/selldo/status-changed', 'Admin\WebhookReceiverController@updateStatus')
    ->name('webhook.update.status');
Route::any('/webhook/selldo/note-added', 'Admin\WebhookReceiverController@noteAdded')
    ->name('webhook.update.note');
Route::any('/webhook/selldo/lead-reassigned', 'Admin\WebhookReceiverController@leadReassigned')
    ->name('webhook.lead.reassigned');
Route::any('/webhook/selldo/hotness-updated', 'Admin\WebhookReceiverController@hotnessUpdated')
    ->name('webhook.hotness.updated');
Route::any('/webhook/selldo/lead-activity', 'Admin\WebhookReceiverController@storeLeadActivity')
    ->name('webhook.store.lead.activity');
Route::any('webhook/{secret}', 'Admin\WebhookReceiverController@processor')->name('webhook.processor');

Route::get('document/{id}/view', 'Admin\DocumentController@guestView')->name('document.guest.view');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {
    // Campaign
    Route::get('get-campaigns', 'CampaignController@getCampaigns')->name('get.campaigns');
    Route::get('get-subsource', 'SubSourceController@getSubSources')->name('get.subsource');
    Route::get('get-sources', 'SourceController@getSource')->name('get.sources');
    Route::get('lead-detail-html', 'LeadsController@getLeadDetailHtml')->name('lead.detail.html');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    
    Route::post('store-global-client-filters', 'HomeController@storeGlobalClientFilters')
        ->name('store.global.client.filter');

    Route::get('/', 'HomeController@index')->name('home');

    //webhook receiver
    Route::get('webhook/new-lead', 'WebhookReceiverController@getNewLeadWebhookLog')
        ->name('webhook.new.lead.log');

    Route::get('webhook/lead-activities', 'WebhookReceiverController@getLeadActivitiesWebhookLog')
        ->name('webhook.lead.activities.log');

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
    Route::get('projects/{id}/source', 'ProjectController@source')->name('projects.source');
    Route::get('projects/{id}/campaign', 'ProjectController@campaign')->name('projects.campaign');


    Route::delete('campaigns/destroy', 'CampaignController@massDestroy')->name('campaigns.massDestroy');
    Route::resource('campaigns', 'CampaignController');
    Route::resource('plcs', 'PlcController');
    Route::resource('price', 'PriceController');
    Route::resource('plotdetails', 'PlotDetailController');
    Route::post('plotdetails/parse-csv-import', 'PlotDetailController@parseCsvImport')->name('plotdetails.parseCsvImport');
    Route::post('plotdetails/process-csv-import', 'PlotDetailController@processCsvImport')->name('plot-details.processCsvImport');
    // Leads
    Route::get('share-lead/{lead_id}/doc/{doc_id}', 'LeadsController@shareDocument')->name('share.lead.doc');
    Route::get('leads/export', 'LeadsController@export')->name('leads.export');
    Route::post('send-mass-webhook', 'LeadsController@sendMassWebhook')->name('lead.send.mass.webhook');
    Route::get('lead-details-rows-html', 'LeadsController@getLeadDetailsRows')->name('lead.details.rows');
    Route::delete('leads/destroy', 'LeadsController@massDestroy')->name('leads.massDestroy');
    Route::get('leads/rows', 'LeadsController@insertRow')->name('leads.row');
    Route::resource('leads', 'LeadsController');
    Route::resource('subsource', 'SubSourceController');
    Route::get('leads/{id}/leads', 'LeadsController@leadIndex')->name('leads.lead');


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
        Route::get('subsource/{id}/webhook', 'SubSourceController@getWebhookDetails')
        ->name('subsource.webhook');
    // Route::post('update-email-and-phone-key', 'SourceController@updatePhoneAndEmailKey')->name('update.email.and.phone.key');
     Route::post('update-email-and-phone-key', 'SubSourceController@updatePhoneAndEmailKey')->name('update.email.and.phone.key');

    Route::delete('sources/destroy', 'SourceController@massDestroy')->name('sources.massDestroy');
    Route::resource('sources', 'SourceController');
    Route::resource('selldo', 'SellDoController');
    Route::resource('selldoUser', 'SelldoUserController');


    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');

    // Document
    Route::get('document-logs', 'DocumentController@getDocumentLogs')->name('get.documents.log');
    Route::get('get-filtered-documents', 'DocumentController@getFilteredDocuments')->name('documents.filtered');
    Route::delete('documents/{id}/file-remove', 'DocumentController@removeFile')->name('documents.remove.file');
    Route::post('documents/ckmedia', 'DocumentController@storeCKEditorImages')->name('documents.storeCKEditorImages');
    Route::delete('documents/destroy', 'DocumentController@massDestroy')->name('documents.massDestroy');
    Route::resource('documents', 'DocumentController');

    // Expression Of Interest
    Route::get('eoi-lead-detail', 'ExpressionOfInterestController@getLeadDetails')->name('eoi.lead.detail');
    Route::delete('eoi/destroy', 'ExpressionOfInterestController@massDestroy')->name('eoi.massDestroy');
    Route::resource('eoi', 'ExpressionOfInterestController');

    Route::get('bookings-lead-detail', 'BookingFormController@getLeadDetails')->name('bookings.lead.detail');
    Route::delete('bookings/destroy', 'BookingFormController@massDestroy')->name('bookings.massDestroy');

    Route::get('booking-new-lead-detail', 'BookingController@getLeadDetails')->name('booking.lead.detail');

    Route::match (['get', 'post'], '/booking/book', 'BookingController@book')->name('booking.book');
    Route::get('/booking/{booking}/booked', 'BookingController@booked')->name('booking.booked');

    Route::resource('bookings', 'BookingFormController');
    Route::resource('merlom-leads', 'MerlomLeadController');
    Route::resource('booking', 'BookingController');
    Route::get('/booking/{plotdetails}/plots', 'BookingController@booking')->name('booking.plots');
    Route::get('/booking/{booking}/bookedit', 'BookingController@bookedit')->name('booking.bookedit');
    Route::get('/booking/{plotdetails}/plots/store', 'BookingController@store')->name('booking.plots.store');


    Route::get('/enquiry-form', 'EnquiryController@index')->name('aztec.index');
    Route::get('/aztec', 'EnquiryController@create')->name('aztec.create');
    Route::post('/aztec/store', 'EnquiryController@store')->name('aztec.store');
    Route::get('/aztec/{enquiry}/edit', 'EnquiryController@edit')->name('aztec.edit');
    Route::put('/aztec/{enquiry}/update', 'EnquiryController@update')->name('aztec.update');
    Route::get('/aztec/{enquiry}/show', 'EnquiryController@show')->name('aztec.show');
    Route::delete('/aztec/{enquiry}/destroy', 'EnquiryController@destroy')->name('aztec.destroy');
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
