<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAdditionalUsers extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id', 'user_id'
    ];

    public function hotel_booking(){
    	return $this->belongsTo(HotelBookings::class,'booking_id','id');
    }

    public function user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }

}
