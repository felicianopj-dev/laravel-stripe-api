<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        
        $secret = config('services.stripe.webhook_secret');
        
        if (!$secret) {
            return response('Webhook secret not configured', 500);
        }
        
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        }
        
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            
            $paymentId = $session->client_reference_id ?? null;
            
            if ($paymentId) {
                $payment = Payment::query()->find($paymentId);
                
                if ($payment) {
                    if ($payment->status !== 'paid') {
                        $payment->update([
                            'status' => 'paid',
                            'stripe_customer_id' => $session->customer ?? null,
                            'stripe_payment_intent_id' => $session->payment_intent ?? null,
                        ]);
                    }
                }
            }
        }
        
        return response()->json(['received' => true]);
    }
}
