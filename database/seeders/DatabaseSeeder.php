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
        // seeding users table
        $roles = ['admin', 'pp_admin', 'tech_team','bursary'];

        for ($i = 1; $i <= count($roles); $i++) {
            $role = $roles[$i - 1];
            DB::table('users')->insert([
                'user_ID' => $i, // Assuming user_ID is an integer
                'username' => $role . "_user",
                'password' => bcrypt("password"),
                'email' => $role . "@example.com",
                'phone_num' => '123456789' . $i,
                'role' => $role, // Adjust index to match the roles array
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            switch ($role) {
                case 'admin':
                    DB::table('admins')->insert(['user_ID' => $i]);
                    break;
                case 'pp_admin':
                    DB::table('pp_admins')->insert(['user_ID' => $i]);
                    break;
                case 'tech_team':
                    DB::table('tech_teams')->insert(['user_ID' => $i]);
                    break;
                case 'bursary':
                    DB::table('bursaries')->insert(['user_ID' => $i]);
                    break;
            }
        }

        //seeding kiosk table
        $kiosksData = [
            [
                'description' => 'left-wing no 1',
                'rented' => true,
            ],
            [
                'description' => 'right-wing no 1',
                'rented' => false,
            ],
            [
                'description' => 'left-wing no 2',
                'rented' => false,
            ],
            [
                'description' => 'right-wing no 2',
                'rented' => false,
            ],
            [
                'description' => 'left-wing no 3',
                'rented' => false,
            ],
        ];

        DB::table('kiosks')->insert($kiosksData);

        DB::table('fee_rates')->insert([
            'amount' => 100,
            'type' => 'student',
        ]);
        DB::table('fee_rates')->insert([
            'amount' => 120,
            'type' => 'vendor',
        ]);

    }
}
