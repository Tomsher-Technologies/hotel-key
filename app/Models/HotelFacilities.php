<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelFacilities extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_id', 'facility_name', 'is_active', 'is_deleted'
    ];

    public function hotel(){
    	return $this->belongsTo(User::class,'hotel_id','id');
    }

    public function hotel_bookings()
    {
        return $this->hasMany(BookingFacilities::class,'facility_id','id');
    } 
}
