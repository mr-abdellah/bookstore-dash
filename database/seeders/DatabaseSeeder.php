<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('platform_settings')->insert([
            'profit_percentage' => 10.00,
            'platform_name' => 'My Book Store',
            'logo' => null,
            'contact_email' => 'admin@example.com',
            'contact_phone' => '+123456789',
        ]);
    }
}
