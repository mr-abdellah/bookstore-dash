<?php

namespace Database\Seeders;

use App\Models\PlatformSettings;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        PlatformSettings::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'profit_percentage' => 10,
            'platform_name' => 'My Book Store',
            'logo' => 'logo.png',
            'contact_email' => 'admin@example.com',
            'contact_phone' => '+123456789',
        ]);
    }
}
