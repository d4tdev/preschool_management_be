<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends BaseModel
{
    use HasFactory;
    protected $table = 'meals';
    protected $fillable = [
        'id',
        'name',
        'created_by',
        'updated_by'
    ];
}
