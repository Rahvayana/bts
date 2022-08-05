<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Contracts extends Model
{
    protected $table = "contracts";

    protected $fillable = [
        "header_text", "header_image", "footer_text", "content"
    ];

    protected $appends = ["header_image_url"];

    protected $hidden = ["header_image", "created_at","updated_at"];

    public function getHeaderImageUrlAttribute()
    {
        return !empty($this->header_image) ? substr($this->header_image,0,4) == "http" ? $this->header_image : URL::to('uploads/'.$this->header_image) : "";
    }
}
