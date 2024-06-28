<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table("users")->insert([
            [
                "name" => "root",
                "email" => "root123@gmail.com",
                "password" => Hash::make("admin123123")
            ],
            [
                "name" => "dummy1",
                "email" => "dummy1@gmail.com",
                "password" => Hash::make("admin123123")
            ],
            [
                "name" => "dummy2",
                "email" => "dumm22@gmail.com",
                "password" => Hash::make("admin123123")
            ],
            [
                "name" => "dummy3",
                "email" => "dummy3@gmail.com",
                "password" => Hash::make("admin123123")
            ],
        ]);
    }
}
