<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'start', 'end'];

    public function schedule()
    {
        return $this->belongsTo(ShiftingPlan::class);
    }

}
