<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelBookings extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_id','main_user_id', 'room_number', 'checkin_date', 'checkin_time', 'checkout_date', 'checkout_time', 'is_active', 'is_deleted'
    ];

    public function hotel(){
    	return $this->belongsTo(User::class,'hotel_id','id');
    }
    
    public function main_user(){
    	return $this->belongsTo(User::class,'main_user_id','id');
    }

    public function accessBy(){
    	return $this->belongsTo(User::class,'access_by','id');
    }

    public function additional_users_without_main_user()
    {
        return $this->hasMany(BookingAdditionalUsers::class,'booking_id','id')->with(['user'])->where('is_main_user',0);
    } 

    public function all_additional_users()
    {
        return $this->hasMany(BookingAdditionalUsers::class,'booking_id','id')->with(['user']);
    } 

    public function booking_facilities()
    {
        return $this->hasMany(BookingFacilities::class,'booking_id','id')->with(['facilities']);
    } 
}
