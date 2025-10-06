<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/users/login', [UserController::class,'login']);
Route::get('/users', [UserController::class,'index'])->middleware('auth:sanctum');

Route::get('/counties', [CountyController::class, 'index']);
Route::get('/cities', [CityController::class, 'index']);