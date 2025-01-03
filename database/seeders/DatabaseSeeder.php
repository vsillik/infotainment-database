<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = new User();

        $user->name = 'admin';
        $user->email = 'admin@example.com';
        $user->password = Hash::make('SecureAdminPassword');
        $user->is_approved = true;

        $user->save();
    }
}
