<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            "name"=> "admin",
            "email"=> "admin@gmail.com",
            "password"=> 'rahasia'
        ]);
    }
}