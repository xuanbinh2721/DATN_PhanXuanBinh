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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/district/{provinceId}', [HomeController::class,'getDistricts']);
Route::get('/ward/{districtId}',  [HomeController::class,'getWards']);   
Route::get('/searchresults', [HomeController::class,'search'])->name('searchresults');
Route::get('/field/{id}', [HomeController::class,'getFieldDetailById'])->name('field.details');


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

    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking-details/{id}', [BookingController::class, 'getBookingDetailById'])->name('booking.detail');
    Route::get('/booking-details/{id}/cancel', [BookingController::class, 'cancelBooking'])->name('booking.cancel');
    //feedback
    Route::put('/field/add-feedback/{id}', [UserController::class,'addFeedback'])->name('field.addfeedback');
    Route::put('/field/upd-feedback/{id}', [UserController::class,'updateFeedback'])->name('field.updatefeedback');
    Route::get('/field/del-feedback/{id}', [UserController::class,'deleteFeedback'])->name('field.deletefeedback');
    //comment
    Route::put('/field/{id}/comment', [UserController::class,'addComment'])->name('field.addcomment');
    Route::put('/field/upd-comment/{id}', [UserController::class,'updateComment'])->name('field.updatecomment');
    Route::get('/field/del-comment/{id}', [UserController::class,'deleteComment'])->name('field.deletecomment');

    // Route cho người cho thuê
    Route::group(['middleware' => 'checkUserType:1'], function () {
        Route::get('/field', [FieldController::class, 'index'])->name('field.index');

        Route::get('/field/{id}/edit',[FieldController::class, 'edit'])->name('field.editfield');
        Route::put('/field/{id}',[FieldController::class, 'update'])->name('field.update');
        Route::post('/field/changestatus/{id}',[FieldController::class, 'changeStatus'])->name('field.changestatus');

        Route::get('/field/schedules/schedule/{id}', [FieldController::class, 'getTime'])->name('field.schedule');
        Route::put('/field/schedules/schedule/addTimeFrame/{id}', [FieldController::class, 'addTimeFrame'])->name('schedule.addTime');
        Route::post('/field/schedules/schedule/updateTimeFrame/{id}', [FieldController::class, 'updateTimeFrame'])->name('schedule.upTime');
        Route::get('/field/schedules/schedule/changelock/{id}',[FieldController::class, 'changeLock'])->name('schedule.changelock');

        Route::get('/field/booking/{id}', [FieldController::class, 'getBooking'])->name('getbooking.index');
        Route::get('/field/booking/accept/{id}',[FieldController::class, 'acceptBooking'])->name('getbooking.accept');
        Route::get('/field/booking/refuse/{id}',[FieldController::class, 'refuseBooking'])->name('getbooking.refuse');

    });

    // Route cho người thuê
    Route::group(['middleware' => 'checkUserType:0'], function () {
        Route::get('/registefield', [UserController::class,'registerField'])->name('registerfield');
        Route::put('/registefield/addfield', [UserController::class,'addField'])->name('registerfield.add');
    });

    // Route cho admin
    Route::group(['middleware' => 'checkUserType:2'], function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::put('/admin/adduser', [AdminController::class, 'addUser'])->name('admin.adduser');
        Route::post('/admin/updateuser/{id}', [AdminController::class, 'updateUser'])->name('admin.updateuser');
        Route::get('/admin/chagelockuser/{id}', [AdminController::class, 'changeLockUser'])->name('admin.changelockuser');

        Route::get('/admin/sporttype', [AdminController::class, 'getSportType'])->name('sporttype.get');
        Route::put('/admin/addtype', [AdminController::class, 'addSportType'])->name('sporttype.addtype');
        Route::post('/admin/updatetype/{id}', [AdminController::class, 'updateSportType'])->name('sporttype.updatetype');
        Route::get('/admin/chagelocktype/{id}', [AdminController::class, 'changeLockSportType'])->name('sporttype.changelocktype');
    });


});




Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


