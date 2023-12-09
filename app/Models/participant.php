<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Participant extends User
{
    use HasFactory;

    // disable time stamps in table
    public $timestamps = false;

    //specifying table primary key
    protected $primaryKey = "parti_ID";

    protected $fillable = [
        "user_ID"
    ];
}
