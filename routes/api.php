<?php
use Illuminate\Http\Request;

Route::group(['namespace' => 'Api\V1\Admin\Auth', 'prefix' => 'v1'], function () {
    Route::post('/login', 'LoginController@login');
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/leads', 'LeadsController@index');
    Route::get('/leads/{id}', 'LeadsController@show');
    Route::get('/logout', 'LoginController@logout');

});
