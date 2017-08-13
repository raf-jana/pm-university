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

Route::get('/', 'HomeController');

// Authentication Routes...
Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Admin dashboard
Route::middleware('auth')->prefix('admin')->namespace('Admin')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('placements', 'PlacementsController', ['names' => [
        'index' => 'placements',
        'create' => 'placements.create',
        'store' => 'placements.store',
        'edit' => 'placements.edit',
        'update' => 'placements.update',
        'destroy' => 'placements.delete'
    ]]);
    Route::resource('hok', 'HallsOfKnowledgeController', ['names' => [
        'index' => 'hok',
        'create' => 'hok.create',
        'store' => 'hok.store',
        'edit' => 'hok.edit',
        'update' => 'hok.update',
        'destroy' => 'hok.delete',
    ]]);
    Route::resource('posts', 'PostsController', ['names' => [
        'index' => 'posts',
        'create' => 'posts.create',
        'store' => 'posts.store',
        'edit' => 'posts.edit',
        'update' => 'posts.update',
        'destroy' => 'posts.delete'
    ]]);
    Route::get('/posts/{id}/articles', 'PostArticlesController@index')->name('posts.articles');
    Route::get('/posts/{id}/articles/new', 'PostArticlesController@create')->name('posts.articles.edit');
    Route::delete('/articles/{id}', 'PostArticlesController@destroy');
});


// Home page
Route::get('/posts/{id}/articles', 'PostArticlesController');
// Details page
Route::get('/{post}', 'PostsController');
