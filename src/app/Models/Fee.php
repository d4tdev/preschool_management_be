<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends BaseModel
{
    use HasFactory;

    protected $table = 'fees';

    protected $fillable = [
        'id',
        'student_id',
        'amount',
        'description',
        'fee_date',
        'status',
        'created_by',
        'updated_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
