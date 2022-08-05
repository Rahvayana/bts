<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAmenities extends Model
{
    use HasFactory;

    protected $table = "room_amenities";
    public $timestamps = false;
    protected $fillable = ["room_id", "amenities_id"];

    public function amenities(){
        return $this->hasMany("App\Models\Amenities","id");
    }
}
