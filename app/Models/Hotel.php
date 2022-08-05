<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Hotel extends Model
{
    use HasFactory;

    protected $table = "hotel";
    protected $fillable = [
        "name",
        "address",
        "city",
        "contact",
        "email",
        "status_id","manager_id", "num_of_rooms", "logo","rate","status_id"
    ];

    protected $appends = ["logo_url"];
    protected $hidden = ["logo", "updated_at", "manager_id"];


    public function getLogoUrlAttribute()
    {
        return !empty($this->logo) ? URL::to('uploads/'.$this->logo) : "";
    }

    public function hotel_images(){
        return $this->hasMany("App\Models\HotelImages")->select("id", "image", "hotel_id");
    }

    public function manager(){
        return $this->belongsTo("App\Models\User","manager_id","id");
    }

    public function status(){
        return $this->belongsTo("App\Models\Status","status_id", "id");
    }

    public function contract(){
        return $this->hasOne("App\Models\HotelContract");
    }

    public function rooms()
    {
        return $this->hasMany("App\Models\Room","hotel_id","id");
    }

    

}
