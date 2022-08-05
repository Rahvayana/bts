<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = "ratings";

    protected $fillable = ["comment", "client_id", "rate", "hotel_id", "booking_id"];

    protected $hidden = ["client_id","hotel_id", "booking_id"];

    public function rating_reply(){
        return $this->hasMany("App\Models\RatingReply");
    }

    public function client(){
        return $this->belongsTo("App\Models\Client");
    }

    public function hotel(){
        return $this->belongsTo("App\Models\Hotel");
    }
}
