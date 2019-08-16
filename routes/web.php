<?php


Route::get('/', 'HomeController@index')->name('home');
//Route::get('/store', 'HomeController@store')->name('store');
Route::post('/store', 'HomeController@store')->name('store');
