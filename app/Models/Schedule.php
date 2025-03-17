<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends BaseModel
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'subject_id',
        'class_id',
        'created_by',
        'updated_by'
    ];
}
