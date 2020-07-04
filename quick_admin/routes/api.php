<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Candidates
    Route::post('candidates/media', 'CandidatesApiController@storeMedia')->name('candidates.storeMedia');
    Route::apiResource('candidates', 'CandidatesApiController');
});
