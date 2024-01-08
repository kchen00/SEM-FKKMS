<?php

namespace App\Console\Commands;

use App\Models\Fee_rate;
use App\Models\Participant;
use App\Models\Rental;
use App\Models\rental_fees;
use App\Models\User;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class countMonthlyFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:count-monthly-fee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate rental fee';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rentals = Rental::where('status', 'on going')->get();
        $originalDate = date('Y-m'); // Assuming you have the date in the 'Y-m' format

        // Create a DateTime object from the original date
        $date = DateTime::createFromFormat('Y-m', $originalDate);

        // Format the date to 'M Y' format (e.g., Jan 2023)
        $formattedDate = $date->format('M Y');

        echo $formattedDate; // Output: Jan 2023

        foreach ($rentals as $rental) {
            $participant = Participant::where('parti_ID', $rental->parti_ID)->first();
            $user = User::where('user_ID', $participant->user_ID)->first();
            if ($user) {
                $fee = Fee_rate::where('type', $user->role)->value('amount');

                if ($fee !== null) {
                    rental_fees::create([
                        'parti_ID' => $rental->parti_ID,
                        'amount' => $fee,
                        'month' => $formattedDate,
                    ]);
                } else {
                    $this->writeToConsole("Warning: Fee rate not found for user role: $user->role\n");
                }
            } else {
                $this->writeToConsole("Error: User not found for rental with participant ID: $rental->parti_ID\n");
            }
        }
        // Additional error handling or try-catch block if required
    }

    private function writeToConsole($message)
    {
        if (defined('STDOUT')) {
            fwrite(STDOUT, $message);
        } else {
            echo $message;
        }
    }
}
