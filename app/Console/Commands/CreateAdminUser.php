<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'user:create-admin';

    protected $description = 'Create a new admin user';

    public function handle()
    {
        $user = User::create([
            'first_name' => "Abdellah",
            'last_name'  => "Belkaid",
            'email'      => "admin@kotobi.com",
            'password'   => Hash::make('11111111'),
            'status'     => 'active',
            'role'       => 'admin',
        ]);

        $this->info("Admin user [{$user->id}] created successfully.");
    }
}
