<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelBookings extends Model
{
    use HasFactory;
    protected $fillable = [
        'main_user_id', 'room_number', 'checkin_date', 'checkin_time', 'checkout_date', 'checkout_time', 'is_active', 'is_deleted'
    ];

    public function main_user(){
    	return $this->belongsTo(User::class,'main_user_id','id');
    }
}
