<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'auth'], function ($router) {
    Route::get('/countries', [ApiController::class, 'getCountries'])->name('countries');
    Route::get('/state/{country_id?}', [ApiController::class, 'getCountryStates'])->name('state');
    Route::post('/forgot-password', [ApiController::class, 'forgotPassword'])->name('forgot-password');
});

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('/login', [ApiAuthController::class, 'login'])->name('log-in');
    Route::post('/register', [ApiAuthController::class, 'register'])->name('register');
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [ApiAuthController::class, 'refresh'])->name('refresh');
    Route::get('/user-profile', [ApiAuthController::class, 'userProfile'])->name('user-profile'); 
    Route::post('/update-userdata', [ApiAuthController::class, 'updateUserData'])->name('update-userdata');
    Route::post('/update-user-image', [ApiAuthController::class, 'updateProfileImage'])->name('update-user-image');
    Route::post('/update-password', [ApiAuthController::class, 'changePassword'])->name('update-password');

    Route::get('/all-hotels', [ApiAuthController::class, 'getAllHotels'])->name('all-hotels'); 
    Route::get('/user-reservations', [ApiAuthController::class, 'getUserReservationHistory'])->name('user-reservations'); 
    Route::get('/booking-details', [ApiAuthController::class, 'getBookingDetails'])->name('booking-details'); 
    Route::get('/notifications', [ApiAuthController::class, 'notifications'])->name('notifications');
    Route::get('/notification-count', [ApiAuthController::class, 'unreadNotifications'])->name('notification-count');
    Route::get('/history', [ApiAuthController::class, 'getHistory'])->name('history');

    Route::post('/sos', [ApiAuthController::class, 'saveSos'])->name('sos');
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
