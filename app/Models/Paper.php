<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'class_id',
        'subject_id',
        'created_by',
        'uploaded_paper_file',
        'data_source',
        'duration',
        'total_marks'
    ];

    protected $casts = [
        'duration' => 'integer',
        'total_marks' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function studentClass(): BelongsTo
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PaperSection::class);
    }
}