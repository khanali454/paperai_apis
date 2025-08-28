<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaperTemplate extends Model
{
    // sections of the paper template
    public function sections()
    {
        return $this->hasMany(PaperTemplateSection::class, 'template_id', 'id')->with('questionType')->orderBy('order');
    }

    // created_by user
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
