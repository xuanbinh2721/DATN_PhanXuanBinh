<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\SportTypeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookingController;
use App\Models\BookingDetail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/district/{provinceId}', [App\Http\Controllers\HomeController::class,'getDistricts']);
Route::get('/ward/{districtId}',  [App\Http\Controllers\HomeController::class,'getWards']);   
Route::get('/searchresults', [App\Http\Controllers\HomeController::class,'search'])->name('searchresults');
Route::get('/field/{id}', [App\Http\Controllers\HomeController::class,'getFieldDetailById'])->name('field.details');




Auth::routes(['verify' => true]);


Route::middleware(['auth', 'verified', 'checkUserStatus'])->group(function () {
    //profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    Route::put('/profile/updateInfo', [ProfileController::class, 'updateInfomation'])->name('profile.updateInfo');
    Route::put('/profile/password', [PasswordController::class, 'update'])->name('password.update');
    //booking
    Route::get('/field/{id}/time-frames', [BookingController::class, 'getTimeFrames'])->name('field.time-frames');
    Route::get('/field/{id}/get-price', [BookingController::class, 'getPrice'])->name('field.get-price');
    Route::put('/field/{id}/booking', [BookingController::class, 'store'])->name('field.booking');
    Route::get('/booking-details/{id}', [BookingController::class, 'getBookingDetailById'])->name('booking.detail');
    Route::get('/booking-details/{id}/cancel', [BookingController::class, 'cancelBooking'])->name('booking.cancel');



    // Route cho người cho thuê
    Route::group(['middleware' => 'checkUserType:1'], function () {
        Route::get('/field', [FieldController::class, 'index'])->name('field.index');

        Route::get('/field/schedules/schedule/{id}', [FieldController::class, 'getTime'])->name('field.schedule');
        Route::put('/field/schedules/schedule/addTimeFrame/{id}', [FieldController::class, 'addTimeFrame'])->name('schedule.addTime');
        Route::post('/field/schedules/schedule/updateTimeFrame/{id}', [FieldController::class, 'updateTimeFrame'])->name('schedule.upTime');
        Route::get('/field/schedules/schedule/changelock/{id}',[FieldController::class, 'changeLock'])->name('schedule.changelock');

        Route::get('/field/{id}/edit',[FieldController::class, 'edit'])->name('field.editfield');
        Route::put('/field/{id}',[FieldController::class, 'update'])->name('field.update');
        Route::post('/field/changestatus/{id}',[FieldController::class, 'changeStatus'])->name('field.changestatus');




    });

    // Route cho người thuê
    Route::group(['middleware' => 'checkUserType:0'], function () {
        Route::get('/registefield', [App\Http\Controllers\HomeController::class,'registerField'])->name('registerfield');
        Route::put('/registefield/addfield', [App\Http\Controllers\HomeController::class,'addField'])->name('registerfield.add');
    });

    // // Route cho admin
    // Route::group(['middleware' => 'checkUserType:2'], function () {
    //     Route::get('/admin-dashboard', 'AdminController@index')->name('admin.index');

    // });


});




Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


