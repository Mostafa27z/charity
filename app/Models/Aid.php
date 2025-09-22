<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Aid extends Model
{
    use HasFactory;

    protected $fillable = [
        'beneficiary_id',
        'association_id',
        'aid_type',
        'amount',
        'description',
        'aid_date',
        'created_by'
    ];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
