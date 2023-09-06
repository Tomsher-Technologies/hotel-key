<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supports extends Model
{
    use HasFactory;
    protected $fillable = ['hotel_id', 'message', 'reply', 'reply_at','is_read','is_deleted'];

    public function hotel(){
    	return $this->belongsTo(User::class,'hotel_id','id');
    }
}
