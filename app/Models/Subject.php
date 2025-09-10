<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    protected $fillable = [
        'name',
        'description',
        'class_id',
    ];

    public function subject_class()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

}
