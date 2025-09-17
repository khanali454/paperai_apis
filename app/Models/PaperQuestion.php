<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaperQuestion extends Model
{
    public function sub_questions(){
        return $this->hasMany(PaperQuestion::class, 'parent_id');
    }
}
