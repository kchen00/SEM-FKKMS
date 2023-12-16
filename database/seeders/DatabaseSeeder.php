<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'phone_num' => '0123456789',
            'email' => 'admin@argon.com',
            'role' => 'admin',
            'password' => bcrypt('secret')
        ]);
        DB::table('users')->insert([
            'username' => 'student',
            'phone_num' => '0123456781',
            'email' => 'student@argon.com',
            'role' => 'student',
            'password' => bcrypt('1234')
        ]);
        DB::table('users')->insert([
            'username' => 'vendor',
            'phone_num' => '0123456782',
            'email' => 'vendor@argon.com',
            'role' => 'vendor',
            'password' => bcrypt('1234')
        ]);
 
        DB::table('participants')->insert([
            'user_ID' => '2',
        ]);
        DB::table('participants')->insert([
            'user_ID' => '3',
        ]);
        DB::table('participants')->insert([
            'user_ID' => '3',
        ]);
    }
}
