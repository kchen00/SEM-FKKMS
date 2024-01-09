<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee_rate extends Model
{
    use HasFactory;
    protected $primaryKey = 'feeRate_ID';
    protected $fillable = [
        'type',
        'ammount'
    ];
}
