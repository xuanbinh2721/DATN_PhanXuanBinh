<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\SportTypeController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {

});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/district/{provinceId}', [App\Http\Controllers\HomeController::class,'getDistricts'])->name('district');
    Route::get('/ward/{districtId}',  [App\Http\Controllers\HomeController::class,'getWards'])->name('ward');   
    Route::get('/field/{id}', [App\Http\Controllers\FieldController::class,'getFieldDetailById'])->name('field.details');

    // Route::group(['prefix' => 'customer'], function () {
    //     Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    //     // Thêm các route khác cho phần người tìm thuê sân tại đây
    // });


    // Route::group(['prefix' => 'provider'], function () {
    //     Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('provider.dashboard');
    //         Route::get('/field/profile', [ProfileController::class, 'index'])->name('profile.show');
    // Route::put('/field/profile/updateInfo', [ProfileController::class, 'updateInfomation'])->name('profile.updateInfo');
    // Route::put('/field/profile/password', [PasswordController::class, 'update'])->name('password.update');
    // });
    Route::get('/field', [FieldController::class, 'index'])->name('field.index');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    Route::put('/profile/updateInfo', [ProfileController::class, 'updateInfomation'])->name('profile.updateInfo');
    Route::put('/profile/password', [PasswordController::class, 'update'])->name('password.update');
});




Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


