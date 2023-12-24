<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class PP_admin extends User
{
    use HasFactory;
    
    // disable time stamps in table
    public $timestamps = false;
    
    //specifying table primary key
    protected $primaryKey = "PP_ID";
    
    protected $fillable = [
        "user_ID"
    ];
}
