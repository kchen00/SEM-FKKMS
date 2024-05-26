<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale_report extends Model
{
    use HasFactory;
    //specifying table primary key
    protected $primaryKey = "report_ID";

    //specify the table for sale report
    protected $table = "sale_reports";

    protected $fillable = [
        "parti_ID",
        "sales",
        "cost",
        "comment",
        "comment_time"
    ];
}
