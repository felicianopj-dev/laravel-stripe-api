<?php

namespace App\Services\Stripe;

use Stripe\StripeClient;

class StripeClientFactory
{
    public static function make(): StripeClient
    {
        $secret = config('services.stripe.secret');
        
        if (!$secret) {
            throw new \RuntimeException('Stripe secret not configured.');
        }
        
        return new StripeClient($secret);
    }
}
