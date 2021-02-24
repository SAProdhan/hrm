<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employeetodevice;
use App\Leave;

class Employee extends Model
{
    protected $table = 'sys_employee';

    /* designation  Function Start Here */
    public function designation_name()
    {
        return $this->hasOne('App\Designation','id','designation');
    }

    /* department  Function Start Here */
    public function department_name()
    {
        return $this->hasOne('App\Department','id','department');
    }

    /* Schedule Function Start Here */
    public function schedule()
    {
        return $this->hasOne('App\Models\Schedule', 'id', 'schedule_id');
    }

    /* device uid*/
    public function uid($device_id)
    {
        return $this->hasMany(Employeetodevice::class)->where('device_id',$device_id)->first('uid');
    }

    public function leaves($date)
    {
        return $this->hasMany(Leave::class)->where('leave_from','<=', $date)->where('leave_to','>=', $date)->first();
    }

}
