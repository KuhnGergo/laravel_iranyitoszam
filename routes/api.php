<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/users/login', [UserController::class,'login']);
Route::get('/users', [UserController::class,'index'])->middleware('auth:sanctum');

Route::get('/counties', [CountyController::class, 'index']);
Route::post('/counties', [CountyController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/counties/{id}', [CountyController::class, 'update'])->middleware('auth:sanctum');

Route::get('/cities', [CityController::class, 'index']);
Route::post('/cities', [CityController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/cities/{id}', [CityController::class, 'update'])->middleware('auth:sanctum');