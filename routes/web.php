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
Route::get('signup', 'UsersController@create')->name('signup');
Route::resource('users','UsersController');

Route::get('login','SessionsController@create')->name('login');
Route::post('login','SessionsController@store')->name('login');
Route::delete('logout','SessionsController@destroy')->name('logout');

Route::get('signup/activated/{token}','UsersController@activated')->name('activated_email');//激活邮箱

//显示重置密码视图
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//邮箱发送重设链接
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//显示密码更新视图
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//执行密码更新操作
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

//微博资源路由
Route::resource('statuses','StatusesController')->only('store','destroy');

//关注列表&粉丝列表
Route::get('users/{user}/followings','UsersController@followings')->name('users.followings');
Route::get('users/{user}/followers','UsersController@followers')->name('users.followers');
//关注与取消关注按钮
Route::post('users/followers/{user}','FollowersController@store')->name('followers.store');
Route::delete('users/followers/{user}','FollowersController@destroy')->name('followers.destroy');
