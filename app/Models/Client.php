<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = "clients";

    protected $hidden = ["created_at", "updated_at","company_id","status_id"];

    protected $fillable = [
        "name","company_id","email","contact","status_id"
    ];

    public function company(){
        return $this->belongsTo("App\Models\Company");
    }

    public function status(){
        return $this->belongsTo("App\Models\Status");
    }
}
