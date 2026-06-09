<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CustomerController;

Route::get('/', [PageController::class, 'index']);
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login',[LoginController::class,'check']);
Route::get('/customerHomePage',[HomePageController::class,'index']);
Route::get('/superadminHomePage',[HomePageController::class,'index']);
Route::get('/staffHomePage',[HomePageController::class,'index']);
Route::get('/technicianHomePage',[HomePageController::class,'index']);
Route::get('/mainPage',[PageController::class,'index']);
Route::get('/logout',[LogoutController::class,'logout']);
Route::get('/shop',[CustomerController::class,'shop']);
Route::get('/service',[CustomerController::class,'bookService'])->name('customer.book.service');
Route::post('/service',[CustomerController::class, 'storeService']); 