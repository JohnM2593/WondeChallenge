<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = [
        "api_id",
        "mis_id",
        "name",
        "code",
        "description",
        "subject",
        "alternative",
    ];
}
