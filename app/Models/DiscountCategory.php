<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCategory extends Model
{
    use HasFactory;

    protected $table = "discount_category";

    protected $fillable = ["category_name"];

    public function discount(){
        return $this->hasMany("App\Models\Discount");
    }
}
