<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rental extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'status',
        'parti_ID',
        'kiosk_ID',
        'startdate',
        'enddate',
    ];
}
