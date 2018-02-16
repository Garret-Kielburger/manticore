<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * Home/Landing page
 */

Route::get('/', [
    'uses' => '\Manticore\Http\Controllers\HomeController@index',
    'as' => 'home',
]);

/**
 * Authentication
 */

// Sign Up

Route::get('/signup', [
    'uses' => '\Manticore\Http\Controllers\AuthController@getSignup',
    'as' => 'auth.signup',
    'middleware' => ['guest'],
]);

Route::post('/signup', [
    'uses' => '\Manticore\Http\Controllers\AuthController@postSignup',
    'middleware' => ['guest'],
]);

// Sign In

Route::get('/login', [
    'uses' => '\Manticore\Http\Controllers\AuthController@getSignin',
    'as' => 'auth.signin',
    'middleware' => ['guest'],
]);

Route::post('/login', [
    'uses' => '\Manticore\Http\Controllers\AuthController@postSignin',
    'middleware' => ['guest'],
]);


// Sign Out

Route::get('/logout', [
    'uses' => '\Manticore\Http\Controllers\AuthController@getSignout',
    'as' => 'auth.signout',
]);


/**
 *
 * Dashboard - Backend Portal
 *
 */

Route::get('/dashboard/{username}', [
    'uses' => '\Manticore\Http\Controllers\DashboardController@getDashboard',
    'as' => 'dashboard.index',
    'middleware' => ['auth'],
]);

/*Route::get('/dashboard/', [
    'uses' => '\Manticore\Http\Controllers\DashboardController@getDashboard',
    'as' => 'dashboard',
]);*/

// Create New App

Route::get('/dashboard/{username}/new-app', [
    'uses' => '\Manticore\Http\Controllers\DashboardController@getCreateApp',
    'as' => 'dashboard.create_app',
    'middleware' => ['auth'],
]);

Route::post('/dashboard/{username}/new-app', [
    'uses' => '\Manticore\Http\Controllers\DashboardController@postCreateApp',
    'as' => 'dashboard.create_app',
    'middleware' => ['auth'],
]);

// Edit App

Route::get('/dashboard/{username}/{app_name}', [
    'uses' => '\Manticore\Http\Controllers\DashboardController@getEditApp',
    'as' => 'dashboard.edit_app',
    'middleware' => ['auth'],
]);

Route::post('/dashboard/{username}/{app_name}', [
    'uses' => '\Manticore\Http\Controllers\DashboardController@postEditApp',
    'as' => 'dashboard.edit_app',
    'middleware' => ['auth'],
]);


// Edit Screen


Route::get('/dashboard/{username}/{app_name}/{screen_name}/{screen_uuid}', [
    'uses' => '\Manticore\Http\Controllers\DashboardController@getEditScreen',
    'as' => 'dashboard.edit_screen',
    'middleware' => ['auth'],
]);


Route::post('/dashboard/{username}/{app_name}/{screen_name}/{screen_uuid}', [
    'uses' => '\Manticore\Http\Controllers\DashboardController@postEditScreen',
    'as' => 'dashboard.edit_screen',
    'middleware' => ['auth'],
]);

// Delete element from screen
Route::delete('/dashboard/{username}/{app_name}/{screen_name}/{screen_uuid}', [
    'uses' => '\Manticore\Http\Controllers\DashboardController@destroyElement',
    'as' => 'dashboard.edit_screen',
    'middleware' => ['auth'],
]);


// Edit Button Sub Screen

Route::get('/dashboard/{username}/{app_name}/{screen_name}/{screen_uuid}/{subscreen_uuid}', [
    'uses' => '\Manticore\Http\Controllers\DashboardController@getEditSubScreen',
    'as' => 'dashboard.edit_sub_screen',
    'middleware' => ['auth'],
]);


Route::post('/dashboard/{username}/{app_name}/{screen_name}/{screen_uuid}/{subscreen_uuid}', [
    'uses' => '\Manticore\Http\Controllers\DashboardController@postEditSubScreen',
    'as' => 'dashboard.edit_sub_screen',
    'middleware' => ['auth'],
]);

// Delete element from screen
Route::delete('/dashboard/{username}/{app_name}/{screen_name}/{screen_uuid}/{subscreen_uuid}', [
    'uses' => '\Manticore\Http\Controllers\DashboardController@destroyElement',
    'as' => 'dashboard.edit_sub_screen',
    'middleware' => ['auth'],
]);




/**
 *      Json for App Sync
 *
 *      API routes
 *
 */


Route::group(['prefix' => 'api'], function() {


    Route::post('/{app_uuid}/gain_permission', function() {
        return Response::json(Authorizer::issueAccessToken());
    });

// unencrypted
    Route::get('/{app_uuid}/mobile', [
        'uses' => '\Manticore\Http\Controllers\SyncController@sync',
    ]);

    Route::get('/{app_uuid}/{screen_uuid}/test', [

        'uses' => '\Manticore\Http\Controllers\DashboardController@test'

    ]);

// with oauth2 encryption of whatever type
    Route::get('/{app_uuid}/mobile_oauth', [
        'uses' => '\Manticore\Http\Controllers\SyncController@oauth_sync',
        'middleware' => ['oauth'],
    ]);

// checking Chimera/Nemean email is found in member table
    Route::get('/{app_uuid}/email_check',[
        'uses' => '\Manticore\Http\Controllers\SyncController@member_check',
        'middleware' => ['oauth'],

    ]);

// provide Chimera/Nemean with member table
    Route::get('/{app_uuid}/members', [
        'uses' => '\Manticore\Http\Controllers\SyncController@member_table',
        'middleware' => ['oauth'],
    ]);

});

// Return Access token for app permission to d/l from api




// automatically create oauth_client when creating new App
/*
 * Oauth client table:
 *     name = app_uuid
 *     id = arbitrary
 *     secret = arbitrary
 */

/**
 *
 *  Instructions for operating API
 *
 *
 *    http://greenrrepublic.com/api/a941a114-c0e2-4304-a6c5-3ed9b45fa9a8/mobile_oauth
 *
 *
 *
 *
 *      * http://manticore.dev/cb139c2e-b2d7-4ed9-ac0d-2c6b019aca1b/mobile_oauth
 *
 *      1) POST to http://manticore.dev/cb139c2e-b2d7-4ed9-ac0d-2c6b019aca1b/gain_permission
 *
 *          WITH x-www-from-urlencoded -> client_id, client_secret and grant_type=>client_credentials
 *              ==> copy-paste from Postman works fine
 *
 *      2) Receive access_token from site
 *
 *      3) GET data from site using access token in url request, ie:
 *
 * http://manticore.dev/cb139c2e-b2d7-4ed9-ac0d-2c6b019aca1b/mobile_oauth?access_token=ykaczTTCNUGTzaNTr0w1zyxsUfmt3auQWPba6AED
 *
 *
 *
 */


/**
 *      Push Notification registration etc
 */

//  protect registration endpoints - Oauth2? possible/necessary to protect a post request?

// use /push/* for registration to get around csrverify error
//todo: add oauth2 to this route

Route::post('/push/{app_uuid}/register_firebase', [
    'uses' => '\Manticore\Http\Controllers\PushController@postRegister',
]);

/**
 * User Profile
 *
 */

Route::get('/profile/{username}', [
    'uses' => '\Manticore\Http\Controllers\ProfileController@getProfile',
    'as' => 'profile.index',
    'middleware' => ['auth'],
]);

// Could replace with a middleware group in future, within broader scope of requirements

Route::get('/profile/{username}/edit', [
    'uses' => '\Manticore\Http\Controllers\ProfileController@getEdit',
    'as' => 'profile.edit',
    'middleware' => ['auth'],
]);

Route::post('/profile/{username}/edit', [
    'uses' => '\Manticore\Http\Controllers\ProfileController@postEdit',
    'middleware' => ['auth'],
]);



/**
 *  Search
 */

Route::get('/search', [
    'uses' => '\Manticore\Http\Controllers\SearchController@getResults',
    'as' => 'search.results',
    'middleware' => ['auth'],
]);
