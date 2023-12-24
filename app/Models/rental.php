<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $primaryKey = "rentals_ID";

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'parti_ID');
    }

}
