<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $fillable = [
        'name',
        'description',
        'organized_by',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id');
    }
}
