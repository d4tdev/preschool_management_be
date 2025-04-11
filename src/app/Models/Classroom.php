<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends BaseModel
{
    use HasFactory;

    protected $table = 'classes';
    protected $fillable = [
        'id',
        'name',
        'teacher_id',
        'created_by',
        'updated_by'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
}
