<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Schedule;
use App\Models\EmployeeSchedule;
use App\Department;
use App\Employee;

class ShiftingPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    public function index(){
        $self = 'schedules';

        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }
        $Schedules= Schedule::all();
        $employee = Employee::where('status', 'active')->where('user_name','!=','admin')->get();
        $department = Department::all();
        $employeeSchedule=EmployeeSchedule::all();
        return view('admin.schedule_and_shift.shift-plan')
        ->with('department', $department)
        ->with('schedules', $Schedules)
        ->with('employee', $employee);
    }

    public function store(Request $request){
        $self = 'schedules';

        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }


        $validated = $request->validate([
            'employee' => 'required',
            'schedule' => 'required'
        ]);
        $employee = $request->employee;
        $schedule = $request->schedule;
        $data = Array();
        foreach($employee as $d){
            array_push($data, Array(
                'schedule_id'=>$schedule,
                'employee_id'=>$d
            ));
        }
        $status = Employee::whereIn('id', $employee)->update(['schedule_id' => $schedule]);
        // $status = EmployeeSchedule::insert($data);
        if($status){
            return redirect()->back()->with([
                'message'=> language_data('Employee schedule set successfully')
            ]);
        }
        return redirect()->back()->with([
                'message'=> language_data('Faild to set Schedule'),
                'message_important'=>true
            ]);
    }

    public function update(Request $request, $id){
        $self = 'schedules';

        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }


        $validated = $request->validate([
            'schedule' => 'required'
        ]);

        $employee = Employee::find($id);
        if($employee){
            $employee->schedule_id = $request->schedule;
            $status = $employee->save();
            if($status){
                return redirect()->back()->with([
                    'message'=> language_data('Employee schedule updated successfully')
                ]);
            }
            return redirect()->back()->with([
                'message'=> language_data('Faild to update Employee Schedule'),
                'message_important'=>true
            ]);

        }        
        return redirect()->back()->with([
                'message'=> language_data('Employee not found!'),
                'message_important'=>true
            ]);
        
    }

    /* remove schedule from employee */
    public function destroy($id){
        $self = 'schedules';

        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }


        $employee = Employee::find($id);
        if($employee){
            $employee->schedule_id = null;
            $status = $employee->save();
            if($status){
                return redirect()->back()->with([
                    'message'=> language_data('Employee schedule remove successfully')
                ]);
            }
            return redirect()->back()->with([
                'message'=> language_data('Faild to remove Employee Schedule'),
                'message_important'=>true
            ]);

        }        
        return redirect()->back()->with([
                'message'=> language_data('Employee not found!'),
                'message_important'=>true
            ]);
    }
}
