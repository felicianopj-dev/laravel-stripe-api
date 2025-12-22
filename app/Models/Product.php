<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'amount_cents',
        'currency',
        'is_active',
    ];
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
