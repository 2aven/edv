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

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');

Route::resource('skills','SkillsController');
Route::resource('skillsconf','SkillConfController');
Route::resource('coffret','CoffretController');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
