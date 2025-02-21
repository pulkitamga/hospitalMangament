<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'gender',
        'birthday',
        'address',
        'region',
        'phone',
        'nationality',
        'bloodgroup',
        'status',
        'department_id',
        'doctor',
        'disease',
        'admit_date',
        'discharge_date',
    ];

    // Relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
