<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Billing\CheckoutController;
use App\Http\Controllers\Webhooks\StripeWebhookController;

Route::get('/', function () {
    return redirect('checkout');
});

Route::get('/checkout', function () {
    return view('checkout.form');
})->name('checkout.form');

Route::post('/checkout', [CheckoutController::class, 'create'])
    ->name('checkout.create');

Route::get('/checkout/success', function () {
    return view('checkout.success');
})->name('checkout.success');

Route::get('/checkout/cancel', function () {
    return view('checkout.cancel');
})->name('checkout.cancel');

Route::prefix('api')->group(function () {
    Route::post('/webhooks/stripe', [StripeWebhookController::class, 'handle']);
    Route::post('/billing/checkout', [CheckoutController::class, 'create']);
});
