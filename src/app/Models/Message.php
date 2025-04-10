<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends BaseModel
{
    use HasFactory;

    protected $table = 'messages';
    protected $fillable = [
        'message_room_id',
        'user_id',
        'content',
        'created_by',
        'updated_by'
    ];
}
