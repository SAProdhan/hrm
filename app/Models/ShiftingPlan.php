<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftingPlan extends Model
{
    /**
     * primaryKey 
     * 
     * @var integer
     * @access protected
     */
    protected $primaryKey = null;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;
    
    protected $fillable = ['schedule_id','shift_id', 'sequence', 'days', 'total'];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id', 'schedule_id');
    }

    public function shift()
    {
        return $this->hasOne(Shift::class, 'id', 'shift_id');
    }
}
