<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingFacilities extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id', 'facility_id'
    ];

    public function hotel_booking(){
    	return $this->belongsTo(HotelBookings::class,'booking_id','id');
    }

    public function facilities(){
    	return $this->belongsTo(HotelFacilities::class,'facility_id','id');
    }
}
