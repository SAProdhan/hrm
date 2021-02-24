<?php

namespace App;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table='sys_leave';

    /* employee_id  Function Start Here */
    public function employee()
    {
        return $this->hasOne('App\Employee','id','employee_id');
    }

    /* leave_type  Function Start Here */
    public function leave_type()
    {
        return $this->hasOne('App\LeaveType','id','ltype_id');
    }


}
