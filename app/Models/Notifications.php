<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'content','booking_id'];

    public function user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }
}
