<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Situation extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'day',
        'recipe',
        'eat_status',
        'note',
        'review',
        'created_by',
        'updated_by'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
