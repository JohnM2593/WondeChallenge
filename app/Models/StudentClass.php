<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $fillable = [
        "student_id",
        "class_id"
    ];
}
