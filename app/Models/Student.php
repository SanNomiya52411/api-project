<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $table = "students";
    protected $fillable = ["name","course","school_id"];

    public function subject(){
        return $this->belongsToMany(Subject::class);
    }

}
