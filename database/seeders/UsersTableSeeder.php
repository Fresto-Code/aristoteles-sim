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
            'name' => 'agus halim',
            'email' => 'agus.halim@afresto.com',
            'username' => 'agus',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'role' => 'admin',
            'avatar' => 'user-avatar/1.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'osis',
            'email' => 'osis@afresto.com',
            'username' => 'osis',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'role' => 'osis',
            'avatar' => 'user-avatar/2.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'teacher',
            'email' => 'teacher@afresto.com',
            'username' => 'teacher',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'role' => 'teacher',
            'avatar' => 'user-avatar/3.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'principal',
            'email' => 'principal@afresto.com',
            'username' => 'principal',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'role' => 'principal',
            'avatar' => 'user-avatar/4.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'student',
            'email' => 'student@afresto.com',
            'username' => 'student',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'role' => 'student',
            'avatar' => 'user-avatar/5.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
