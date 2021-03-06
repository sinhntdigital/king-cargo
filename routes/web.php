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

Route::middleware(['get-locale'])->group(function () {
    Route::get('/', 'HomeController@getDashboardPage')->name('gmGetDashboardPage');
    Route::resource('employee', 'EmployeesController');
    Route::resource('user', 'UserController');
});

Route::get('change-language/{locale}', function ($locale) {
    return redirect('/')->withCookie(cookie('app_locale', $locale, 1440));
})->name('changeLanguage');