<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'admin',
                'phone' => '0123456789',
            ]
        );
        User::create(
            [
                'first_name' => 'Teacher',
                'last_name' => 'Teacher',
                'email' => 'teacher@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'teacher',
                'class_id' => 1,
                'phone' => '0123456789',
            ]
        );
        User::create(
            [
                'first_name' => 'Parent',
                'last_name' => 'Parent',
                'email' => 'parent@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'parent',
                'phone' => '0123456789',
            ]
        );
    }
}
