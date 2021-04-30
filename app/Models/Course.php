<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // public $primaryKey = 'course_id';

    use HasFactory;

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function professors() {
        return $this->belongsToMany(Professor::class);
    }

    public function students() {
        return $this->belongsToMany(Student::class);
    }

    public $timestamps = false;
}
