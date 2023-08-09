<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomAuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', [CustomAuthController::class, 'index'])->name('login');
Route::namespace('Admin')->prefix('admin')->group(function () {
    
    Route::get('login', [CustomAuthController::class, 'index'])->name('login');
    Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');  
    Route::get('logout', [CustomAuthController::class, 'signOut'])->name('logout');
    
    Route::group(['middleware' => ['auth','admin']], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
       
        Route::get('/all-guests', [HomeController::class, 'getAllGuests'])->name('all-guests');
        Route::get('/add-guest', [HomeController::class, 'getAllGuests'])->name('add-guest');
        Route::post('/store-guest', [HomeController::class, 'getAllGuests'])->name('store-guest');
        Route::get('/edit-guest', [HomeController::class, 'getAllGuests'])->name('edit-guest');

        Route::get('/all-hotels', [HotelController::class, 'getAllHotels'])->name('all-hotels');
        Route::get('/add-hotel', [HotelController::class, 'createHotel'])->name('add-hotel');
        Route::post('/store-hotel', [HotelController::class, 'storeHotel'])->name('store-hotel');
        Route::get('/edit-hotel/{id}', [HotelController::class, 'editHotel'])->name('edit-hotel');
        Route::post('/hotel/update/{id}', [HotelController::class, 'updateHotel'])->name('hotel.update');
        Route::post('/hotel/delete/', [HotelController::class, 'deleteHotel'])->name('hotel.delete');

        Route::get('/all-users', [UserController::class, 'getAllUsers'])->name('all-users');
        Route::get('/add-user', [UserController::class, 'createUser'])->name('add-user');
        Route::post('/store-user', [UserController::class, 'storeUser'])->name('store-user');
        Route::get('/edit-user/{id}', [UserController::class, 'editUser'])->name('edit-user');
        Route::post('/user/update/{id}', [UserController::class, 'updateUser'])->name('user.update');
        Route::post('/user/delete/', [UserController::class, 'deleteUser'])->name('user.delete');
    });

});