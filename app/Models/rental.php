<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;
    protected $primaryKey = "rentals_ID";
    protected $fillable = [
        'description',
        'status',
        'parti_ID',
        'kiosk_ID',
        'startdate',
        'enddate',
    ];

    public function kiosk()
    {
        return $this->belongsTo(Kiosk::class, 'kiosk_ID', 'kiosk_ID'); // Assuming 'Kiosk' is the model name for the kiosk table
    }

    

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'parti_ID');
    }

}
