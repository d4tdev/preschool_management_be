<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends BaseModel
{
    use HasFactory;
    protected $table = 'subjects';
    protected $fillable = [
        'id',
        'name',
        'created_by',
        'updated_by'
    ];
}
