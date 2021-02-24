<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Schedule;
use App\Employee;

class EmployeeSchedule extends Model
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
    
    protected $fillable = ['schedule_id','employee_id'];

    /* schedule*/
    public function schedule()
    {
        return $this->hasOne(Schedule::class, 'id', 'schedule_id');
    }

    /* Employee */
    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }
}
