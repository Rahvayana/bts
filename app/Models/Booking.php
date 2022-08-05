<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = "bookings";
    protected $fillable = [
        "client_id",
        "room_type_id",
        "check_in",
        "check_out",
        "status",
        "adult",
        "child",
        "status_booking_id",
        "room_id",
        "hotel_id",
        "subtotal",
        "total",
        "discount",
        "discount_id",
        "booking_code",
        "room_number",
        "price_per_room",
        "night"
    ];

    protected $casts = ["status"=>"boolean"];

    protected $hidden = [ "client_id", "room_type_id","status_booking_id", "discount_id"];

    public function status_booking(){
        return $this->belongsTo("App\Models\StatusBooking");
    }

    public function hotel(){
        return $this->belongsTo("App\Models\Hotel");
    }

    public function client(){
        return $this->belongsTo("App\Models\Client")->with("company");
    }

    public function room_type(){
        return $this->belongsTo("App\Models\RoomType");
    }
}
