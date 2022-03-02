<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        "api_id",
        "upi",
        "mis_id",
        "initials",
        "surname",
        "forename",
        "middle_names",
        "legal_surname",
        "legal_forename",
        "gender",
        "created_at",
        "updated_at",
    ];
}
