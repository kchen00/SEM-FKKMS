<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sale_report extends Model
{
    use HasFactory;
    //specifying table primary key
    protected $primaryKey = "report_ID";

    protected $fillable = [
        "parti_ID",
        "sales",
        "comment"
    ];
}
