<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        "api_id",
        "class_id",
        "room",
        "period",
        "period_instance_id",
        "employee",
        "start_at",
    ];
}
