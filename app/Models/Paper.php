<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    public function sections(){
        return $this->hasMany(PaperSection::class)->with('question_groups');
    }

    public function class(){
        return $this->belongsTo(StudentClass::class,'class_id');
    }
    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id');
    }
}
