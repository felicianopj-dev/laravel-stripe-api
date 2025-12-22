<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'code' => 'premium_30d',
                'name' => 'Premium Access (30 days)',
                'amount_cents' => 2990,
                'is_active' => true,
            ],
            [
                'code' => 'premium_90d',
                'name' => 'Premium Access (90 days)',
                'amount_cents' => 7990,
                'is_active' => true,
            ],
            [
                'code' => 'donation_10',
                'name' => 'Donation ($ 10)',
                'amount_cents' => 1000,
                'is_active' => true,
            ],
        ];
        
        foreach ($products as $product) {
            Product::updateOrCreate(
                ['code' => $product['code']],
                $product
            );
        }
    }
}
