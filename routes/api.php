<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['namespace'=>'App\Http\Controllers\Api'], function (){
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('me', 'AuthController@me');
        // register
        Route::post('register','AuthController@register');

        // send email to set password
        Route::post('forgot_password', 'AuthController@forgot_password');
        Route::post('change_password', 'AuthController@change_password');
        // verify email
        Route::post('email/verify/{id}', 'AuthController@verify')->name('verify.verify'); // Make sure to keep this as your route name
        Route::post('email/resend', 'AuthController@resend')->name('verify.resend');

        // users api routes
        Route::group([
            'prefix' => 'user',
            'middleware' =>'auth:api'
        ], function (){
            // update user
            Route::post('update','UserController@update');
        });


        // Properties api routes
        Route::group([
            'prefix' => 'property',
        ], function (){
            // update user
            Route::get('create','PropertyController@create');
            Route::post('store','PropertyController@store');
            Route::post('/{id}/update','PropertyController@update');
            Route::delete('/{id}/delete','PropertyController@delete');

            Route::get('all','PropertyController@index');
            Route::get('/{id}/show','PropertyController@show');
            Route::get('special','PropertyController@allSpecial');

            Route::post('search','SearchController@mainSearch');

            Route::get('/gov/{id}/cities','PropertyController@getCities');
        });



});
