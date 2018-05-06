<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', 'GauMapAuthController@getRegister')->name('gmGetRegister');
Route::get('login', 'GauMapAuthController@getLogin')->name('gmGetLogin');
Route::get('logout', 'GauMapAuthController@postLogout')->name('gmGetLogout');
Route::get('social-login/{driver}', 'GauMapAuthController@socialLoginRedirect')->name('gmSocialLoginRedirect');
Route::get('social-callback/{driver}', 'GauMapAuthController@socialLoginCallback')->name('gmSocialLoginCallback');
Route::post('login', 'GauMapAuthController@postLogin')->name('gmPostLogin');
Route::post('lost-password', 'GauMapAuthController@postLostPassword')->name('gmPostLostPassword');
Route::post('register', 'GauMapAuthController@postRegister')->name('gmPostRegister');

Route::group([], function () {
    Route::get('/', 'HomeController@getDashboardPage')->name('gmGetDashboardPage');
});


// management admin
Route::group([], function () {
    Route::resource('resource', 'ResourcesController');
    Route::resource('user', 'UserController');
});