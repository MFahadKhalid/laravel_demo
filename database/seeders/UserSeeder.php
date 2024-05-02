<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user2 = new User;
        $user2->name = 'admin';
        $user2->email = 'admin@gmail.com';
        $user2->password = Hash::make('password');
        $user2->role_id = '1';
        $user2->save();
    }
}
