<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\SportTypeController;
use App\Http\Controllers\SearchController;

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

    // Route cho người cho thuê
    Route::group(['middleware' => 'checkUserType:1'], function () {
        Route::get('/field', [FieldController::class, 'index'])->name('field.index');
        Route::get('/field/{id}/edit',[FieldController::class, 'edit'])->name('field.editfield');
        Route::put('/field/{id}',[FieldController::class, 'update'])->name('field.update');
        Route::post('/field/changoff/{id}',[FieldController::class, 'changeOff'])->name('field.changeoff');
        Route::post('/field/changeon/{id}',[FieldController::class, 'changeOn'])->name('field.changeon');

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

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    Route::put('/profile/updateInfo', [ProfileController::class, 'updateInfomation'])->name('profile.updateInfo');
    Route::put('/profile/password', [PasswordController::class, 'update'])->name('password.update');
});




Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


