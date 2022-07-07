<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = "school";
    protected $fillable = ["school_id", "student_id"];

    public function students()
    {
        echo Student::class;
        return $this->hasMany(Student::class);
    }
}
