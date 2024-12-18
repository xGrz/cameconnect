<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if (app()->environment('local')) {
            User::factory()->create([
                'name' => 'Grzegorz Byśkiniewicz',
                'email' => config('cameconnect.username'),
                'password' => bcrypt(config('cameconnect.password')),
                'connect_username' => config('cameconnect.username'),
                'connect_password' => config('cameconnect.password'),
            ]);

        }
    }
}
