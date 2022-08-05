<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Room extends Model
{
    use HasFactory;
    

    protected $table = "rooms";

    protected $fillable = [
        "title",
        "rooms_type_id",
        "description",
        "quantity",
        "max_child",
        "num_of_adult",
        "hotel_id",
        "featured_image",
        "price_sunday",
        "price_monday",
        "price_tuesday",
        "price_wednesday",
        "price_thursday",
        "price_friday",
        "price_saturday"
    ];

    protected $hidden = [
        "created_at","updated_at","rooms_type_id", "featured_image","hotel_id"
    ];

    protected $appends = ["featured_image_url"];


    

    public function getFeaturedImageUrlAttribute()
    {
        return !empty($this->featured_image) ? URL::to('uploads/'.$this->featured_image) : "";
    }

    public function room_amenities(){
       return $this->hasMany("App\Models\RoomAmenities","amenities_id");
    }

    public function room_type(){
        return $this->belongsTo("App\Models\RoomType","rooms_type_id","id");
    }

    public function room_images(){
        return $this->hasMany("App\Models\RoomImages");
    }
}
