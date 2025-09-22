<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BeneficiaryRelative extends Model
{
    use HasFactory;

    protected $fillable = [
        'beneficiary_id',
        'name',
        'national_id',
        'gender',
        'birth_date',
        'phone',
        'relation_type',
        'notes'
    ];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }
}
