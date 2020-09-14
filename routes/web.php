<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

// 登录
Route::get('login', 'SessionController@create')->name('login');
Route::post('login', 'SessionController@store')->name('login');
// 退出
Route::delete('logout', 'SessionController@destroy')->name('logout');

// 关注者和粉丝
Route::get('/users/{user}/followings', 'UserController@followings')->name('users.followings');
Route::get('/users/{user}/followers', 'UserController@followers')->name('users.followers');

// 用户
Route::resource('users', 'UserController');

// 邮箱验证
Route::get('signup/confirm/{token}', 'UserController@confirmEmail')->name('confirm_email');

// 重置密码
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// 微博
Route::resource('microblogs', 'MicroblogController')->only(['store', 'destroy']);