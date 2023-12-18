<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Vendor extends User
{
    use HasFactory;

    // disable time stamps in table
    public $timestamps = false;
    
    protected $fillable = [
        'IC_number',
        'parti_ID'
    ];

    //specifying table primary key
    protected $primaryKey = "ven_ID";
}
