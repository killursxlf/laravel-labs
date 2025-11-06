<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::truncate();

        $users = [
            ['name' => 'Alice', 'email' => 'alice@example.com', 'password' => Hash::make('123456')],
            ['name' => 'Bob', 'email' => 'bob@example.com', 'password' => Hash::make('123456')],
            ['name' => 'Charlie', 'email' => 'charlie@example.com', 'password' => Hash::make('123456')],
            ['name' => 'Diana', 'email' => 'diana@example.com', 'password' => Hash::make('123456')],
            ['name' => 'Eve', 'email' => 'eve@example.com', 'password' => Hash::make('123456')],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
