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
        $humanResource = User::create([
            'name' => 'HRD',
            'email' => 'hrd@gmail.com',
            'password' => Hash::make('1234'),
        ])->assignRole('HRD');

        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
        ])->assignRole('Admin');
    }
}
