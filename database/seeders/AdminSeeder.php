<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'logo' => 'default.jpg',
            'name' => 'Admin LajuPesan',
            'username' => 'lajupesan',
            'email' => 'lajupesan@gmail.com',
            'password' => bcrypt('LajuPesan2026.'),
            'role' => 'admin'
        ]);
    }
}
