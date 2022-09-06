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

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    
    // Route::get('/profileDetail', 'HomeController@profileDetail')->name('profileDetail');
    // Route::post('/updateProfile', 'HomeController@updateProfile')->name('updateProfile');
    // Route::post('/getDealerOfBrand', 'DealerBrandController@getDealerOfBrand')->name('getDealerOfBrand');
    Route::group(['prefix' => 'user'], function () {
        Route::get('/profile', 'HomeController@profile')->name('profile');
        Route::post('/updateProfile', 'HomeController@updateProfile')->name('updateProfile');
        Route::get('/password', 'HomeController@password')->name('profile.password');
        Route::get('/referral', 'HomeController@getReferral')->name('referral.list');
        Route::post('/password/update', 'HomeController@passwordUpdate')->name('profile.passwordUpdate');
    });

    Route::group(['prefix' => 'subject'], function () {
        Route::get('/', 'SubjectController@index')->name('subject');
        Route::get('/detail', 'SubjectController@detail')->name('subject.detail');
        Route::get('/create', 'SubjectController@create')->name('subject.create');
        Route::get('/index', 'SubjectController@index')->name('subject');
        Route::get('/get', 'SubjectController@get')->name('subject.list');
        Route::post('/addupdate', 'SubjectController@addupdate')->name('subject.addupdate');
        Route::post('/delete', 'SubjectController@delete')->name('subject.delete');
    });

    Route::group(['prefix' => 'student'], function () {
        Route::get('/', 'StudentController@index')->name('student');
        Route::get('/detail', 'StudentController@detail')->name('student.detail');
        Route::get('/create', 'StudentController@create')->name('student.create');
        Route::get('/index', 'StudentController@index')->name('student');
        Route::get('/get', 'StudentController@get')->name('student.list');
        Route::post('/addupdate', 'StudentController@addupdate')->name('student.addupdate');
        Route::post('/delete', 'StudentController@delete')->name('student.delete');
    });

    Route::group(['prefix' => 'student-time-log'], function () {
        Route::get('/', 'StudentTimeLogController@index')->name('student-time-log');
        Route::get('/monthly_view', 'StudentTimeLogController@MonthlyView')->name('student-time-log.monthly_view');
        Route::get('/detail', 'StudentTimeLogController@detail')->name('student-time-log.detail');
        Route::get('/create', 'StudentTimeLogController@create')->name('student-time-log.create');
        Route::get('/index', 'StudentTimeLogController@index')->name('student-time-log');
        Route::get('/get', 'StudentTimeLogController@get')->name('student-time-log.list');
        Route::post('/addupdate', 'StudentTimeLogController@addupdate')->name('student-time-log.addupdate');
        Route::post('/delete', 'StudentTimeLogController@delete')->name('student-time-log.delete');
        Route::get('/timelog/search', 'StudentTimeLogController@logSearch')->name('student-time-log.search');
    });

    Route::group(['prefix' => 'holiday'], function () {
        Route::get('/', 'HolidayController@index')->name('holiday');
        Route::get('/detail', 'HolidayController@detail')->name('holiday.detail');
        Route::get('/create', 'HolidayController@create')->name('holiday.create');
        Route::get('/index', 'HolidayController@index')->name('holiday');
        Route::get('/get', 'HolidayController@get')->name('holiday.list');
        Route::post('/addupdate', 'HolidayController@addupdate')->name('holiday.addupdate');
        Route::post('/update', 'HolidayController@update')->name('holiday.update');
        Route::post('/delete', 'HolidayController@delete')->name('holiday.delete');
    });
});