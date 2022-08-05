<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = "company";

    protected $fillable = [
        "company_name", "mail_domain", "contact", "num_of_employees", "logo", "discount_id", "status_id", "manager_name"
    ];

    protected $hidden = ["created_at","updated_at","status_id","discount_id"];

    public function status(){
        return $this->belongsTo("App\Models\Status");
    }

    public function discount(){
        return $this->belongsTo("App\Models\Discount");
    }

}
