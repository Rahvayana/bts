<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory;

    protected $table = "users";
    protected $fillable = [
        "username",
        "name",
        "email",
        "encrypted_password",
        "phone",
        "address",
        "city",
        "country",
        "postcode",
    ];

    protected $hidden = [
        "encrypted_password","created_at","updated_at"
    ];

    public function setPasswordAttribute($value) {
        $this->attributes['encrypted_password'] = Hash::make($value);
    }
}
