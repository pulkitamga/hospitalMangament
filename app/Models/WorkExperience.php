<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $table = 'work_experience';
    protected $fillable = ['user_id', 'institution', 'field', 'start_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
