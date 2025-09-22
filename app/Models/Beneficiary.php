<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beneficiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'national_id',
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'phone',
        'address',
        'family_size',
        'income',
        'notes',
        'association_id', // ✅ added
    ];

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function aids()
    {
        return $this->hasMany(Aid::class);
    }

    public function relatives()
    {
        return $this->hasMany(BeneficiaryRelative::class);
    }
}
