<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Tech_team extends user
{
    use HasFactory;

    // disable time stamps in table
    public $timestamps = false;

    //specifying table primary key
    protected $primaryKey = "ven_ID";

    protected $fillable = [
        "user_ID"
    ];
}
