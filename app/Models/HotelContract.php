<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class HotelContract extends Model
{
    use HasFactory;

    protected $table = "hotel_contract";

    protected $fillable = ["name","hotel_id","signature_name"];

    protected $hidden = ["created_at","updated_at", "hotel_id","id"];

    protected $appends = ["url"];

    public function getUrlAttribute()
    {
        return !empty($this->name) ? substr($this->name,0,4) == "http" ? $this->name : URL::to('pdf/contract/'.$this->name) : "";
    }

    public function hotel(){
        return $this->belongsTo("App\Models\Hotel")->with("manager");
    }
}
