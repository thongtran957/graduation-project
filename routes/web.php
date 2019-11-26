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

Route::get('/annotation', 'AnnotationController@index')->name('annotation.index');
Route::post('/annotation', 'AnnotationController@uploadFile')->name('annotation.uploadfile');
Route::post('/annotation-data', 'AnnotationController@writeFile')->name('annotation.writeFile');

Route::post('/test', 'AnnotationController@')->name('test');
