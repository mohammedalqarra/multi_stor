<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Mohammed AlQarra',
            'email' => 'mohammed@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '970567686852',
        ]);

        DB::table('users')->insert([
            'name' => 'System AlQarra',
            'email' => 'system@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '970567686850',
        ]);
    }
}
