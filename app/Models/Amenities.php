<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    protected $table = "amenities";
    protected $fillable = [
        "amenities_name", "price", "category"
    ];
}
