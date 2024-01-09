<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class complaint extends Model
{
    use HasFactory;
    protected $table = "complaints";
    protected $fillable = ['description','complaint_title','parti_ID'] ;
    protected $primaryKey = 'complaint_ID';
        public function user()
    {
        return $this->belongsTo(User::class, 'parti_ID');
    }
}
