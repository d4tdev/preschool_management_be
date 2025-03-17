<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealRecord extends BaseModel
{
    use HasFactory;

    protected $table = 'meal_records';

    protected $fillable = [
        'student_id',
        'meal_id',
        'status',
        'created_by',
        'updated_by'
    ];
}
