<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => '管理者太郎',
            'email' => 'admin000@sample.com',
            'phone_number' => '08012345678',
            'password' => Hash::make('admin000'),
            'address' => '東京都新宿区1-1-1',
            'email_verified_at' => now(),
            'is_admin' => true,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}


