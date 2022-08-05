<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingReply extends Model
{
    use HasFactory;

    protected $table = "rating_reply";
    protected $fillable = [
        "rating_id", "message", "user_id"
    ];

    public function user(){
        return $this->belongsTo("App\Models\User");
    }
}
