<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthReport extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'doctor_id', 'description', 'gender'];

    // Patient Relation
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Doctor Relation
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
