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
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    /* dashboard */
    Route::get('/', 'HomeController@index')->name('dashboard');
    Route::get('dashboard', 'HomeController@index')->name('dashboard');
    Route::get('get-dashboard-data', 'HomeController@getDashboardData')->name('get-dashboard-data');
   
    /* Mail Resource */
    Route::resource('inbox', 'MailController');
    Route::get('sent-items', 'MailController@sentItems')->name('inbox.sentItems');
    Route::post('sent-items', 'MailController@sentItems')->name('inbox.sentItems');
    Route::get('reply/{mail_id}', 'MailController@reply')->name('inbox.reply');
    Route::post('mail/read', 'MailController@read')->name('inbox.read');
    

});
