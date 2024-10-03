<?php

// use App\Http\Controllers\Frontend\HomeController;

use App\Http\Controllers\Frontend\StripeController;
use Illuminate\Support\Facades\Route;

Route::get('stripe-view', [StripeController::class, 'stripeView']);
Route::post('payment/initiate', [StripeController::class, 'initiatePayment']);
Route::post('payment/complete', [StripeController::class, 'completePayment']);
Route::post('payment/failure', [StripeController::class, 'failPayment']);

// Route::get('/', [HomeController::class, 'index'])->name('frontend.home');

