<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotifications extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'type', 'content', 'attended_by', 'attended_at', 'is_read', 'is_deleted'];

    public function user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }

    public function attendedBy(){
    	return $this->belongsTo(User::class,'attended_by','id');
    }
}
