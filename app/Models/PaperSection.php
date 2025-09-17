<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaperSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'paper_id',
        'title',
        'instructions',
        'order'
    ];

    public function paper(): BelongsTo
    {
        return $this->belongsTo(Paper::class);
    }

    public function sectionGroups(): HasMany
    {
        return $this->hasMany(SectionGroup::class,'section_id');
    }
}