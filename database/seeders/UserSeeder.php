<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name' => 'Owen Wattimena',
            'username' => 'wentox',
            'email' => 'wentoxwtt@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'developer'
        ];
        User::create($user);
    }
}