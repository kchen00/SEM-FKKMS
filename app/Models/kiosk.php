<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kiosk extends Model
{
    use HasFactory;
    protected $primaryKey = 'kiosk_ID';
    protected $fillable = [
        'description',
        'rented',
    ];
}
