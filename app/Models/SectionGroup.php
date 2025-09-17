<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SectionGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'question_type_id',
        'instructions',
        'logic',
        'order'
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(PaperSection::class, 'section_id');
    }

    public function questionType(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(PaperQuestion::class);
    }
}