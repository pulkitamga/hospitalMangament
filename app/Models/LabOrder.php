<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'patient_id',
        'status',
    ];

    /**
     * Visit Relationship
     */
    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    /**
     * Patient Relationship
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
