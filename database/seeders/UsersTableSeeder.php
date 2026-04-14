<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {

        // Create 10 random users using factory
        User::factory(10)->create();
        
        // Create 5 admins using factory
        User::factory(5)->admin()->create();
    }
}