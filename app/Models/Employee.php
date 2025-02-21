<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'salary', 'address',
        'qualification', 'position', 'status', 'image'
    ];

    /**
     * An employee may be a doctor
     */
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }
}
