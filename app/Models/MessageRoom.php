<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageRoom extends BaseModel
{
    use HasFactory;

    protected $table = 'message_rooms';

    protected $fillable = [
        'name',
    ];
}
