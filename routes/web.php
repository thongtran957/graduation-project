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



Route::get('/test', 'ProcessController@test');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'DashboardController@index')->name('dashboard.index');
Route::post('/search', 'DashboardController@search')->name('dashboard.search');

Route::get('/annotation', 'AnnotationController@index')->name('annotation.index');
Route::post('/annotation', 'AnnotationController@uploadFile')->name('annotation.uploadfile');
Route::get('/annotation2/{file_name}', 'AnnotationController@uploadFile2')->name('annotation.uploadfile2');
Route::post('/annotation-data', 'AnnotationController@writeFile')->name('annotation.writeFile');

Route::get('/train', 'TrainController@index')->name('train.index');
Route::get('/train/{file_name}', 'TrainController@train')->name('train.uploadfile');
Route::get('/train/delete/{id}', 'TrainController@delete')->name('train.delete');

Route::get('/extraction', 'ExtractionController@index')->name('extraction.index');
Route::post('/extraction', 'ExtractionController@uploadFile')->name('extraction.uploadfile');
Route::post('/extraction-savedb', 'ExtractionController@saveDB')->name('extraction.savedb');
