<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $primaryKey = 'payment_ID';
    protected $fillable = [
        'payment_proof',
        'status',
        'notes',
        'feedback',
        'amount',
        'parti_ID',
    ];

    public function participant(){
        return $this->belongsTo(Participant::class, 'parti_ID');
    }
    
}
