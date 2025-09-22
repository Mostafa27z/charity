<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Association extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'registration_number',
        'address',
        'phone',
        'email',
        'status'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function aids()
    {
        return $this->hasMany(Aid::class);
    }
}
