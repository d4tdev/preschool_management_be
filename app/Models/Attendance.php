<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends BaseModel
{
    use HasFactory;
    protected $table = 'attendances';
    protected $fillable = [
        'id',
        'student_id',
        'status',
        'date',
        'arrived_at',
        'left_at',
        'created_by',
        'updated_by'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
