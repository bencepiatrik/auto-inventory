<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PartController;

Route::get('/', fn() => redirect()->route('cars.index'));
Route::resource('cars', CarController::class);
Route::resource('parts', PartController::class)->except('show');
