<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class BaseModel extends Model
{
    const PREFIX_CODE = null;

    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (isset(auth()->user()->id)) {
                $model->created_by = auth()->user()->id;
            }
        });

        static::updating(function ($model) {
            if (isset(auth()->user()->id)) {
                $model->updated_by = auth()->user()->id;
            }
        });
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function scopeAvailable($query)
    {
        $tableName = static::getTableName();

        return $query->whereNull("{$tableName}.deleted_at");
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
