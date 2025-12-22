<?php

namespace App\Services\Stripe;

use App\Models\Payment;

class CheckoutService
{
    public function createCheckoutSession(Payment $payment, string $productName): string
    {
        $stripe = StripeClientFactory::make();
        
        $currency = $payment->currency ?: config('services.stripe.currency', 'brl');
        
        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'client_reference_id' => (string) $payment->id,
            
            'line_items' => [
                [
                    'quantity' => 1,
                    'price_data' => [
                        'currency' => $currency,
                        'unit_amount' => (int) $payment->amount_cents,
                        'product_data' => [
                            'name' => $productName,
                        ],
                    ],
                ],
            ],
            
            'success_url' => config('app.url') . '/checkout/success?payment_id=' . $payment->id,
            'cancel_url' => config('app.url') . '/checkout/cancel?payment_id=' . $payment->id,
        ]);
        
        $payment->update([
            'stripe_checkout_session_id' => $session->id,
        ]);
        
        return $session->url;
    }
}
