<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'profile_id', 'gender', 'date_of_birth', 'phone_number', 
        'profile_image', 'language'
    ];

    public function user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }
}
