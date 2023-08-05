<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomAuthController;
use App\Http\Controllers\Admin\HomeController;

Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::get('/', [CustomAuthController::class, 'index'])->name('login');
    Route::get('login', [CustomAuthController::class, 'index'])->name('login');
    Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');  
    Route::get('logout', [CustomAuthController::class, 'signOut'])->name('logout');
    
    Route::group(['middleware' => ['auth','admin']], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
       
       
    });

});