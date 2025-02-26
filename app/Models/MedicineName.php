<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineName extends Model
{
    use HasFactory;

    protected $table = 'medicine_names';
    protected $fillable = ['name', 'total']; // Fillable attributes
}
