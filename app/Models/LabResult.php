<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResult extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'test_id', 'result', 'status'];

    public function order()
    {
        return $this->belongsTo(LabOrder::class, 'order_id');
    }

    public function test()
    {
        return $this->belongsTo(LabTest::class, 'test_id');
    }
}

