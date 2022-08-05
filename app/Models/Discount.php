<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = "discount";

    protected $hidden = ["created_at","updated_at"];

    protected $fillable = ["discount_name", "percent","discount_category_id"];

    public function category(){
        return $this->belongsTo("App\Models\DiscountCategory", "discount_category_id", "id");
    }
}
