<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Agus Halim',
            'email' => 'agus.halim@afresto.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'Osis',
            'email' => 'osis@argon.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'role' => 'osis',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'Teacher',
            'email' => 'teacher@argon.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'role' => 'teacher',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'principal',
            'email' => 'principal@argon.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'role' => 'principal',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
