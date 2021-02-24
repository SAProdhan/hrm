<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ShiftingPlan;
use App\Employee;

class Schedule extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'start', 'end'];

    public function shiftingplan()
    {
        return $this->hasMany(ShiftingPlan::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
