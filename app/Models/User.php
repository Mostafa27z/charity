<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'association_id',
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status'
    ];

    protected $hidden = ['password'];

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function aids()
    {
        return $this->hasMany(Aid::class, 'created_by');
    }
}
