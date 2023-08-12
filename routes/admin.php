<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomAuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\UserController;

    Route::get('/', [CustomAuthController::class, 'index'])->name('login');
    Route::get('login', [CustomAuthController::class, 'index'])->name('login');
    Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');  
    Route::get('logout', [CustomAuthController::class, 'signOut'])->name('logout');
    
    Route::group(['middleware' => ['auth','admin']], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard-counts', [HomeController::class, 'dashboardCounts'])->name('dashboard-counts');
       
        Route::namespace('Admin')->prefix('hotel')->group(function () {
            Route::get('/all-bookings', [HomeController::class, 'getAllBookings'])->name('all-bookings');
            Route::get('/add-booking', [HomeController::class, 'createBooking'])->name('add-booking');
            Route::post('/store-booking', [HomeController::class, 'storeBooking'])->name('store-booking');
            Route::get('/edit-booking/{id}', [HomeController::class, 'editBooking'])->name('edit-booking');
            Route::post('/booking/update/{id}', [HomeController::class, 'updateBooking'])->name('update-booking');
            Route::post('/booking/delete/', [HomeController::class, 'deleteBooking'])->name('booking.delete');

            Route::get('/facilities', [HomeController::class, 'getAllFacilities'])->name('facilities');
            Route::post('/add-facility', [HomeController::class, 'storeFacility'])->name('add-facility');
            Route::post('/facility/delete/', [HomeController::class, 'deleteFacility'])->name('facility.delete');

            Route::get('/profile', [HomeController::class, 'getProfile'])->name('profile');
            Route::get('/update-profile', [HomeController::class, 'updateProfile'])->name('update-profile');
            Route::post('/save-profile', [HomeController::class, 'saveProfile'])->name('save-profile');

            Route::get('/change-password', [HomeController::class, 'getProfile'])->name('change-password');
        });

        Route::namespace('Admin')->prefix('admin')->group(function () {
            Route::get('/all-hotels', [HotelController::class, 'getAllHotels'])->name('all-hotels');
            Route::get('/add-hotel', [HotelController::class, 'createHotel'])->name('add-hotel');
            Route::post('/store-hotel', [HotelController::class, 'storeHotel'])->name('store-hotel');
            Route::get('/edit-hotel/{id}', [HotelController::class, 'editHotel'])->name('edit-hotel');
            Route::post('/hotel/update/{id}', [HotelController::class, 'updateHotel'])->name('hotel.update');
            Route::post('/hotel/delete/', [HotelController::class, 'deleteHotel'])->name('hotel.delete');
           
            Route::get('/bookings', [HotelController::class, 'getAllBookings'])->name('bookings');

            Route::get('/all-users', [UserController::class, 'getAllUsers'])->name('all-users');
            Route::get('/add-user', [UserController::class, 'createUser'])->name('add-user');
            Route::post('/store-user', [UserController::class, 'storeUser'])->name('store-user');
            Route::get('/edit-user/{id}', [UserController::class, 'editUser'])->name('edit-user');
            Route::post('/user/update/{id}', [UserController::class, 'updateUser'])->name('user.update');
            Route::post('/user/delete/', [UserController::class, 'deleteUser'])->name('user.delete');
        });
    });

