<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class RoomImages extends Model
{
    protected $table = "room_images";

    protected $fillable = ["room_id","image"];

    protected $appends = ["image_url"];

    protected $hidden = ["image", "room_id", "created_at","updated_at"];

    public function getImageUrlAttribute()
    {
        return !empty($this->image) ? URL::to('uploads/'.$this->image) : "";
    }
}
