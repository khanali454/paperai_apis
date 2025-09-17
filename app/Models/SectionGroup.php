<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionGroup extends Model
{
    public function questions(){
        return $this->hasMany(PaperQuestion::class,'section_group_id')->with('sub_questions');
    }
}
