<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaperSection extends Model
{
    public function question_groups(){
        return $this->hasMany(SectionGroup::class,'section_id')->with('questions');
    }
}
