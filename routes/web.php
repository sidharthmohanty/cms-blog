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

Route::get('/', 'WelcomeController@index')->name('welcome');



Auth::routes();

    Route::middleware(['auth'])->group(function(){

    Route::get('/dashboard', 'HomeController@index')->name('dashboard');

    Route::resource('categories', 'CategoriesController');

    Route::get('blog/{post}/post', 'BlogController@show')->name('blog-post');

    Route::get('blog/{tag}/tag' ,'BlogController@tag')->name('blog-tag');

    Route::get('blog/{category}/categories', 'BlogController@category')->name('blog-category');

    Route::resource('posts', 'PostsController');

    Route::resource('tags', 'TagsController');

    Route::get('trashed', 'PostsController@trashed')->name('trashed-post.index');

    Route::get('restore/{post}', 'PostsController@restore')->name('trashed-post.restore');
    Route::get('profile', 'UsersController@profile')->name('user-profile');
    Route::put('profileupdate', 'UsersController@profileUpdate')->name('user-profile-update');
});

Route::middleware(['auth', 'VerifyIsAdmin'])->group(function(){
    Route::get('users', 'UsersController@index')->name('user-list');
    Route::post('update/{user}', 'UsersController@update')->name('user-update');
});
