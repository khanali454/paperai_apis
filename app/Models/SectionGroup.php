<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionGroup extends Model
{
    public function questions(){
        return $this->hasMany(PaperQuestion::class)->with('sub_questions');
    }
}
