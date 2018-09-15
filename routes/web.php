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


Route::post('ojtmonitoring/report', 'ReportController@generateReport');
Route::post('ojtmonitoring/reportweekly', 'ReportController@printWeeklyReport');
Route::post('ojtmonitoring/printStudentWeeklyReport', 'ReportController@printStudentWeekly');
Route::get('/ojtmonitoring/signInOff/{id}', 'FingerPrintController@signInOff');

Route::post('/ojtmonitoring/sendMessage', 'ChatMessagesController@sendMessage');
Route::post('/ojtmonitoring/getMessage', 'ChatMessagesController@getMessage');
Route::get('/ojtmonitoring/getLatestMessage/{receiver_id}', 'ChatMessagesController@getLatestMessage');

Route::get('/ojtmonitoring/assessment/{company_id}/{student_id}', 'AssessmentController@index');
Route::post('/assess', 'AssessmentController@save')->name('assess');





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
