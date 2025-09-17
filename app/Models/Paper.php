<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    public function sections(){
        return $this->hasMany(PaperSection::class)->with('question_groups');
    }
}
