<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaperTemplateSection extends Model
{
//    question type
    public function questionType()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }
}
