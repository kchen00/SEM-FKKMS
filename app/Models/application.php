<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class application extends Model
{
    use HasFactory;
    protected $primaryKey = 'application_ID';
    protected $fillable = [
        'SSM',
        'status',
        'description',
        'parti_ID',
        // 'startdate',
        // 'enddate'
    ];
}
