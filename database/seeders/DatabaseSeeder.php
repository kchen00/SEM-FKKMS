<?php

namespace Database\Seeders;

use Carbon\Carbon;
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

        DB::table('kiosks')->insert([
            'description' => 'left-wing no 1',
            'rented' => true,
        ]);
        DB::table('kiosks')->insert([
            'description' => 'right-wing no 1',
            'rented' => false,
        ]);
        DB::table('kiosks')->insert([
            'description' => 'left-wing no 2',
            'rented' => false,
        ]);
        DB::table('kiosks')->insert([
            'description' => 'right-wing no 2',
            'rented' => false,
        ]);
        DB::table('kiosks')->insert([
            'description' => 'left-wing no 3',
            'rented' => false,
        ]);
        DB::table('fee_rates')->insert([
            'amount' => 100,
            'type' => 'student',
        ]);
        DB::table('fee_rates')->insert([
            'amount' => 120,
            'type' => 'vendor',
        ]);
        DB::table('rentals')->insert([
            'description' => 'sell karipap',
            'status' => 'on going',
            'parti_ID' => '1',
            'kiosk_ID' => '1',
            'startdate' => Carbon::now(),
            'enddate' => Carbon::now()->addDays(5)
        ]);
    }
}
