<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Device;
use App\Employee;

class Employeetodevice extends Model
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
    
    protected $fillable = ['employee_id','device_id', 'uid'];

    /* device*/
    public function device()
    {
        return $this->hasOne(Device::class, 'id', 'device_id');
    }

    /* Employee */
    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

}
