<?php

use App\Http\Controllers\Authentication;
use App\Http\Middleware\isAuthenticated;
use Illuminate\Support\Facades\Route;

Route::post('/register', [Authentication::class , 'Register']);
Route::post('/login', [Authentication::class , 'Login'])->middleware([isAuthenticated::class]);
Route::post('/logout', [Authentication::class , 'Logout']);
