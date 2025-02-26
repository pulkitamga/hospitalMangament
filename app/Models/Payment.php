<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'bill_id', 'amount', 'status', 'mode'];

    // Patient Relationship
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Bill Relationship
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
