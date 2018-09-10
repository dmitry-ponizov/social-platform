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

Route::get('/','MainController@index')->name('main');



Auth::routes();



Route::get('upload','HomeController@upload')->name('upload');

Route::post('/language-chooser','LanguageController@changeLanguage');

Route::post('/language','LanguageController@getLanguage');

require_once __DIR__."../../app/Components/components.php";