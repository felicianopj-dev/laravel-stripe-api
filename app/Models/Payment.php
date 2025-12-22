<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'product_id',
        'status',
        'amount_cents',
        'currency',
        'stripe_checkout_session_id',
        'stripe_payment_intent_id',
        'stripe_customer_id',
        'metadata',
    ];
    
    protected $casts = [
        'metadata' => 'array',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
