<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class HotelImages extends Model
{
    use HasFactory;

    protected $table = "hotel_images";

    protected $fillable = [
        "hotel_id", "image"
    ];

    protected $appends = ["image_url"];

    protected $hidden = ["image", "hotel_id", "created_at","updated_at"];

    public function getImageUrlAttribute()
    {
        return !empty($this->image) ? substr($this->image,0,4) == "http" ? $this->image : URL::to('uploads/'.$this->image) : "";
    }
}
