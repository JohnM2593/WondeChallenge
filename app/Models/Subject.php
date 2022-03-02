<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        "api_id",
        "code",
        "name",
        "created_at",
        "updated_at",
    ];
}
