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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('/claims','ClaimController');
});
Route::get('/claim-report/{id}','ClaimController@generatePdf')->name('claim-report');
Route::get('/generate-qrcode/{id}','ClaimController@generateQrcode')->name('generate-qrcode');