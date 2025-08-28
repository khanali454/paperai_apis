<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    //
    public function files()
    {
        return $this->hasMany(StudyMaterialFile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
