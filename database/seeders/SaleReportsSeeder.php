<?php

namespace Database\Seeders;

use App\Models\Sale_report;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::create(2023, 1, 1)->startOfMonth(); // Start date: January 1st, 2023
        $endDate = Carbon::create(2025, 12, 1)->startOfMonth(); // End date: December 1st, 2025

        $dateRange = clone $startDate;

        while ($dateRange->lessThanOrEqualTo($endDate)) {
            Sale_report::create([
                'parti_ID' => 1,
                'sales' => round(mt_rand(0, 1000), 2),
                'comment' => 'Full texts comment',
                'comment_at' => now(),
                'created_at' => $dateRange,
                'updated_at' => now(),
            ]);

            $dateRange->addMonthNoOverflow(); // Move to the next month
        }
    }
}
