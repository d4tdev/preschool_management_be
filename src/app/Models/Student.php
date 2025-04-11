<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends BaseModel
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'birthday',
        'gender',
        'parent_id',
        'class_id',
        'created_by',
        'updated_by'
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(Classroom::class, 'class_id', 'id');
    }
}
