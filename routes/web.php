<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;


Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

//route resource for products
Route::resource('/products', \App\Http\Controllers\ProductController::class);
// routes/web.php

Route::get('/products/{id}/share', [ProductController::class, 'shareToWhatsApp'])->name('products.share');


Route::get('/', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::view('/login', 'auth.login')->name('login');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);