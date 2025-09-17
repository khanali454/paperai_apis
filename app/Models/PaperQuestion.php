<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PaperQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_group_id',
        'parent_question_id',
        'question_text',
        'paragraph_text',
        'correct_answer',
        'marks',
        'order',
        'sub_order'
    ];

    protected $casts = [
        'marks' => 'integer',
        'order' => 'integer',
        'sub_order' => 'integer'
    ];

    public function sectionGroup(): BelongsTo
    {
        return $this->belongsTo(SectionGroup::class);
    }

    public function parentQuestion(): BelongsTo
    {
        return $this->belongsTo(PaperQuestion::class, 'parent_question_id');
    }

    public function subQuestions(): HasMany
    {
        return $this->hasMany(PaperQuestion::class, 'parent_question_id')->orderBy('sub_order');
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class, 'paper_question_id');
    }
}