<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Participant;

class Student extends Participant
{
    use HasFactory;
    // disable time stamps in table
    public $timestamps = false;

    //specifying table primary key
    protected $primaryKey = "std_ID";

    protected $fillable = [
        "std_ID",
        "parti_ID"
    ];
}
