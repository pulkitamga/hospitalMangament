<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bed extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'room_id',
        'patient_id',
        'status',
        'alloted_time',
        'discharge_time',
    ];

    // ✅ Relationship with Room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    // ✅ Relationship with Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
