<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rental_fees extends Model
{
    use HasFactory;
    protected $primaryKey = 'rentFee_ID';
    protected $fillable = [
        'parti_ID',
        'month',
        'amount'
    ];
}
