<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscountController;

Route::post('discounts', [DiscountController::class, 'store']);
Route::put('discounts/{id}', [DiscountController::class, 'update']);
Route::get('discounts', [DiscountController::class, 'index']);
Route::post('discounts/apply', [DiscountController::class, 'apply']);
Route::patch('discounts/use', [DiscountController::class, 'use']);
