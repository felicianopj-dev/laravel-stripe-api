<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Product;
use App\Services\Stripe\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function create(Request $request, CheckoutService $checkoutService)
    {
        $data = $request->validate([
            'product_code' => ['required', 'string', 'max:64'],
        ]);
        
        $product = Product::query()
            ->where('code', $data['product_code'])
            ->where('is_active', true)
            ->first();
        
        if (!$product) {
            throw ValidationException::withMessages([
                'product_code' => 'Invalid or inactive product.',
            ]);
        }
        
        $payment = Payment::create([
            'product_id' => $product->id,
            'status' => 'pending',
            'amount_cents' => $product->amount_cents,
            'currency' => $product->currency,
            'metadata' => [
                'product_code' => $product->code,
                'product_name' => $product->name,
            ],
        ]);
        
        $checkoutUrl = $checkoutService->createCheckoutSession(
            $payment,
            $product->name
        );
        
        if (!$request->expectsJson()) {
            return redirect()->away($checkoutUrl);
        }
        
        return response()->json([
            'payment_id' => $payment->id,
            'checkout_url' => $checkoutUrl,
        ]);
    }
}
