<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\IdCardController;

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
    // return redirect(route('index'));
    return redirect(route('student-time-log'));
})->name('home');

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home1');
Route::post('/getDate', 'HomeController@getDateRange')->name('getStudentDateRange');
// Route::get('/tnc', 'RegisterController@tnc')->name('tnc');
Route::get('/tnc', [RegisterController::class, 'tnc'])->name('tnc');
Route::get('/index', [SiteController::class, 'index'])->name('index');
// Route::get('/faq', [SiteController::class, 'faq'])->name('faq');
Route::get('/id-card', [IdCardController::class, 'id_card'])->name('id_card');
Route::post('/idcard_form', [IdCardController::class, 'idcard_form'])->name('idcard_form');
Route::get('/preview-card/{id?}', [IdCardController::class, 'preview_card'])->name('preview_card');
Route::get('/print-card/{id}', [IdCardController::class, 'print_card'])->name('print_card');
Route::post('/print_canvas', [IdCardController::class, 'print_canvas'])->name('print_canvas');
Route::post('/send-card', [IdCardController::class, 'send_card'])->name('send_card');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/plans', 'PlanController@index')->name('plans.index');
    Route::get('/plan/{plan}', 'PlanController@show')->name('plans.show');
    Route::post('/subscription', 'SubscriptionController@create')->name('subscription.create');
    Route::post('/subscription/cancel', 'SubscriptionController@cancel')->name('subscription.cancel');
    Route::post('/freeCodePlan', 'SubscriptionController@freeCodePlan')->name('freeCodePlan');

    Route::get('/subscription/price/show', 'SubscriptionController@addPriceShow')->name('subscription.price.show');
    Route::post('subscription/price/change', 'SubscriptionController@addPrice')->name('subscription.price.change');

    Route::get('/links', 'LinkController@index')->name('links.index');
    Route::post('/links/addupdate', 'LinkController@addupdate')->name('link.addupdate');
    Route::get('/links/detail', 'LinkController@detail')->name('link.detail');
    Route::get('/links/get', 'LinkController@get')->name('links.list');
    Route::post('/links/delete', 'LinkController@delete')->name('link.delete');
    Route::post('/get/link', 'LinkController@getlink')->name('get.link');

    Route::get('/help', 'SiteController@help')->name('help');

    Route::post('/file/delete', 'LogFileController@delete')->name('file.delete');
    Route::get('/file/list', 'LogFileController@index')->name('file.index');
    Route::get('/file/get', 'LogFileController@get')->name('file.list');
    Route::post('/file/delete', 'LogFileController@delete')->name('file.delete');
    Route::post('/file/update', 'LogFileController@update')->name('file.update');
    // 

    // Route::get('/profileDetail', 'HomeController@profileDetail')->name('profileDetail');
    // Route::post('/updateProfile', 'HomeController@updateProfile')->name('updateProfile');
    // Route::post('/getDealerOfBrand', 'DealerBrandController@getDealerOfBrand')->name('getDealerOfBrand');
    Route::group(['prefix' => 'user'], function () {
        Route::get('/profile', 'HomeController@profile')->name('profile');
        Route::post('/updateProfile', 'HomeController@updateProfile')->name('updateProfile');
        Route::get('/password', 'HomeController@password')->name('profile.password');
        Route::get('/referral', 'HomeController@getReferral')->name('referral.list');
        Route::post('/password/update', 'HomeController@passwordUpdate')->name('profile.passwordUpdate');
        Route::get('/users', 'UserController@index')->name('users');
        Route::get('/users/get', 'UserController@get')->name('users.list');
        Route::post('/users/delete', 'UserController@delete')->name('users.delete');
        Route::post('/user/login', 'UserController@login')->name('user.login');
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

    Route::group(['prefix' => 'promocode'], function () {
        Route::get('/', 'PromoCodeController@index')->name('promocode');
        Route::get('/detail', 'PromoCodeController@detail')->name('promocode.detail');
        Route::get('/create', 'PromoCodeController@create')->name('promocode.create');
        Route::get('/index', 'PromoCodeController@index')->name('promocode');
        Route::get('/get', 'PromoCodeController@get')->name('promocode.list');
        Route::post('/addupdate', 'PromoCodeController@addupdate')->name('promocode.addupdate');
        Route::post('/delete', 'PromoCodeController@delete')->name('promocode.delete');
        Route::get('/generate', 'PromoCodeController@generate')->name('promocode.generate');
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
        Route::post('/pdfData', 'StudentTimeLogController@pdfData')->name('pdfData');
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

    Route::group(['prefix' => 'idcard'], function () {
        Route::get('/', 'IdCardController@index')->name('idcard')->middleware('admin.user');
        Route::get('/index', 'IdCardController@index')->name('idcard')->middleware('admin.user');
        Route::get('/get', 'IdCardController@get')->name('idcard.list');
    });
});