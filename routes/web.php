<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('search', 'SearchController@posts')->name('search.posts');
Route::get('posts', 'PostController@index')->name('posts.index');

Route::prefix('posts')->middleware('auth')->group(function(){
    Route::get('create', 'PostController@create')->name('posts.create');

    Route::post('store', 'PostController@store');

    Route::get('{post:slug}', 'PostController@show')->withoutMiddleware('auth')->name('posts.show');

    Route::get('{post:slug}/edit', 'PostController@edit');

    // ada put dan ada patch
    // put -> keseluruhan
    // patch -> partial
    Route::patch('{post:slug}/edit', 'PostController@update');

    Route::delete('{post:slug}/delete', 'PostController@destroy');
});

Route::get('categories/{category:slug}', 'CategoryController@show')->name('categories.show');
Route::get('tags/{tag:slug}', 'TagController@show')->name('tags.show');

Route::view('contact', 'contact');
Route::view('about', 'about');
Route::view('login', 'login');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
