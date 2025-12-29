<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
            ]
        );
        
        // Create a token for local/dev usage (re-run safe).
        // You can delete old tokens if you want deterministic behavior.
        $user->tokens()->where('name', 'demo-token')->delete();
        
        $token = $user->createToken('demo-token', ['billing:write']);
        
        // Print token to console for quick copy/paste in local env.
        $this->command?->info('Demo token (Bearer): ' . $token->plainTextToken);
    }
}
