<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        User::create([
            'name' => 'tasker',
            'username' => 'tasker',
            'role' => 'tasker',
            'password' => bcrypt('tasker123'),
        ]);

        User::create([
            'name' => 'worker',
            'username' => 'worker',
            'role' => 'worker',
            'password' => bcrypt('worker123'),
        ]);
    }
}
