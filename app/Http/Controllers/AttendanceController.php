<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Classes\permission;
use App\Department;
use App\Designation;
use App\Employee;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Log;
use PDF;
use Rats\Zkteco\Lib\ZKTeco;
// use WkPdf;
// use DateTime;

use App\Http\Requests;
use Illuminate\Support\Facades\Request as Input;

date_default_timezone_set(app_config('Timezone'));

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /* report  Function Start Here */
    public function report()
    {

        $self='attendance-report';

        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $date_from = '';
        $date_to = '';
        $emp_id = '';
        $dep_id = '';
        $des_id = '';

        $attendance = Attendance::all();
        $employee = Employee::where('status', 'active')->where('user_name','!=','admin')->get();
        $department = Department::all();
        return view('admin.attendance', compact('attendance', 'employee', 'department', 'date_from','date_to', 'emp_id', 'dep_id', 'des_id'));
    }

    /* getAllPdfReport  Function Start Here */
    public function getAllPdfReport()
    {

        $self='attendance-report';

        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $attendance = Attendance::all();

        return view('admin.all-pdf-attendance-report', compact('attendance'));
        // $pdf=PDF::loadView('admin.all-pdf-attendance-report', compact('attendance'));
        
        
        // return $pdf->download('attendance.pdf');
    }


    /* postSetOvertime  Function Start Here */
    public function postSetOvertime(Request $request)
    {
        $attend_id=$request->attend_id;
        $overTimeValue=$request->overTimeValue;

        if($attend_id!='' AND $overTimeValue!=''){
            Attendance::where('id', $attend_id)->update(['overtime' => $overTimeValue]);
            return 'success';
        }else{
            return 'failed';
        }
    }


    /* update  Function Start Here */
    public function update()
    {

        $self='update-attendance';

        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $employee = Employee::where('status', 'active')->where('user_name','!=','admin')->get();
        $devices = Device::all();
        return view('admin.update-attendance', compact('employee','devices'));
    }

    /* postUpdateAttendance  Function Start Here */
    public function postUpdateAttendance(Request $request)
    {

        $v = \Validator::make($request->all(), [
            'employee' => 'required', 'date_from' => 'required', 'date_to' => 'required', 'clock_in' => 'required', 'clock_out' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('attendance/update')->withErrors($v->errors());
        }

        $emp_ids = Input::get('employee');
        $employees = Employee::whereIn('id', $emp_ids)->get();

        // echo('<pre>');
        // print_r($emp_ids);
        // echo('<br>');
        // print_r($employees);

        for($i=strtotime($request->date_from);$i<=strtotime($request->date_to);$i+=86400){
            foreach($employees as $emp_info){
                $restintime = app_config('RestInTime');
                $restouttime = app_config('RestOutTime');
                $office_in_time = app_config('OfficeInTime');
                $office_out_time = app_config('OfficeOutTime');
                $clock_in = 0;
                $clock_out = 0;
                $late = 0;
                $early_leave = 0;
                $overtime=0;
                $total=0;
                $designation = $emp_info->designation;
                $department = $emp_info->department;
                $employee = $emp_info->id;
                $status='';
                $date = date('Y-m-d',$i);

                $office_in_time = $date.' '.$office_in_time;
                $office_out_time = $date.' '.$office_out_time;

                $shift = false;
                /**Check if employee has schedule */
                if($emp_info->schedule){
                    if(strtotime($emp_info->schedule->end)>=$i && strtotime($emp_info->schedule->start)<=$i){
                        $shiftingplan = $emp_info->schedule->shiftingplan;
                        $start = strtotime($emp_info->schedule->start)/86400;
                        $total_days = max(array_column($shiftingplan->toarray(), 'total'));
                        $days = 1;
                        $pdate = strtotime($date)/86400;
                        if($pdate > $start){
                            $days = ($pdate+1) - $start;
                        }
                        if($days > $total_days){
                            $days = $days%$total_days;
                        }
                        // check if schedule has shift
                        foreach($shiftingplan as $plan){
                            if($plan->total >= $days ){
                                $shift = $plan->shift;
                                break;
                            }
                        }
                    }
                    if($shift){
                        if($shift->id == 0)
                        {
                            $status='Holiday';
                        }
                        else{
                            $office_in_time = $date.' '.$shift->start;
                            $office_out_time= $date.' '.$shift->end;
                        }
                    }
                }else if(in_array(date('w',strtotime($date)), unserialize(app_config('WeeklyHoliday')))){
                    $status='Holiday';
                }else if($emp_info->leaves($date)){
                    $status='Leave';
                }
                if($status == ''){

                    $clock_in = Input::get('clock_in');
                    $clock_out = Input::get('clock_out');

                    $clock_in = $date.' '.$clock_in;
                    $clock_out = $date.' '.$clock_out;

                    $min_office_in_time = strtotime('-30 minutes',strtotime($office_in_time));
                    $max_office_out_time = strtotime('+30 minutes',strtotime($office_out_time));
                    if($max_office_out_time<$min_office_in_time){
                        $max_office_out_time = strtotime('+24 hours', $max_office_out_time);
                        $office_out_time = strtotime('+24 hours', strtotime($office_out_time));
                        $office_out_time = date('Y-m-d H:i', $office_out_time);
                    }

                    $entry_time=strtotime($clock_in);
                    $out_time=strtotime($clock_out);
                    
                    $max_office_in_time = strtotime('+'.$restintime.' minutes',strtotime($office_in_time));
                    $min_office_out_time = strtotime('-'.$restouttime.' minutes',strtotime($office_out_time));
                    
                    /* Late time */
                    if ($entry_time > $max_office_in_time) {
                        $late = $entry_time-strtotime($office_in_time);
                    }
                    else{
                        $entry_time = strtotime($office_in_time);
                    }
                    
                    /* Early leave time */
                    if ($min_office_out_time > $out_time) {
                        $early_leave = strtotime($office_out_time) - $out_time;
                    }
                    
                    /* Working hours */
                    $office_hour = strtotime($office_out_time) - strtotime($office_in_time);
                    
                    /* Total working time */
                    $total = $out_time-$entry_time;

                    if($total<0){
                        $total = 0;
                    }
                    $overtime = $total-$office_hour;

                    if($overtime<0){
                        $overtime = 0;
                    }
            
                    $attendance = Attendance::where('emp_id', $employee)->where('date', $date)->first();
                    
                    $status='Present';
                    // $clock_in = 0;
                    // $clock_out = 0;
                    $late = round($late/60, 2);
                    $early_leave = round($early_leave/60, 2);
                    $overtime = round($overtime/60, 2);
                    $total = round($total/60, 2);
                    $clock_in = date('h:i A', strtotime($clock_in));
                    $clock_out =date('h:i A', strtotime($clock_out));

                        // echo('<pre>');
                        // echo($office_hour.'<br>');
                        // echo($office_in_time.'<br>');
                        // echo($office_out_time.'<br>');
                        // echo($emp_info->fname.'<br>');
                        // print_r($att);
                }
                
                $attendance = Attendance::where('emp_id', $employee)->where('date', $date)->first();
                if ($attendance) {
                    $attendance->clock_in = $clock_in;
                    $attendance->clock_out = $clock_out;
                    $attendance->late = $late;
                    $attendance->early_leaving = $early_leave;
                    $attendance->overtime= $overtime;
                    $attendance->total= $total;
                    $attendance->status = $status;
                    $attendance->save();
        
                } else {
                    $att = new Attendance();
                    $att->emp_id = $employee;
                    $att->designation = $designation;
                    $att->department = $department;
                    $att->date = $date;
                    $att->clock_in = $clock_in;                     
                    $att->clock_out = $clock_out;
                    $att->late = $late;
                    $att->early_leaving = $early_leave;
                    $att->overtime= $overtime;
                    $att->total = $total;
                    $att->status = $status;
                    $att->save();
                }
            }
        }

        return redirect('attendance/report')->with([
            'message' => language_data('Attendance Updated Successfully')
        ]);

    }


    /* postUpdateAttendanceDevice  Function Start Here */
    public function postUpdateAttendanceDevice(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'date_from' => 'required', 'device' => 'required', 'date_to' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('attendance/update')->withErrors($v->errors());
        }

        $device = Device::find($request->device);
        $zk = new ZKTeco($device->ip);
        $employee = Employee::where('status', 'active')->get('id')->toArray();
        $status = $zk->connect();   
        if(!$status){
            return redirect()->back()->with([
                'message'=> language_data('Failed to Connect! Check device connection and try again'),
                'message_important'=>true
            ]);
        }
        $logs=$zk->getAttendance();
        $data = Array();
        $last_id = Log::where('device_id', $device->id)->orderBy('id','desc')->first()->id;
        foreach($logs as $log){
            if($log['uid']>$last_id)
            array_push($data, array(
                'id'=>$log['uid'],
                'device_id'=>1,
                'uid'=>$log['id'],
                'timestamp'=>$log['timestamp']
            ));
        }

        $status = Log::insert($data);
        if(!$status){
            return redirect()->back()->with([
                'message'=> language_data('Failed to update log! Check device connection and try again'),
                'message_important'=>true
            ]);
        }

        $employees = Employee::where('status', 'active')->get();
        for($i=strtotime($request->date_from);$i<=strtotime($request->date_to);$i+=86400){
            foreach($employees as $emp_info){
                $restintime = app_config('RestInTime');
                $restouttime = app_config('RestOutTime');
                $office_in_time = app_config('OfficeInTime');
                $office_out_time = app_config('OfficeOutTime');
                $clock_in = 0;
                $clock_out = 0;
                $late = 0;
                $early_leave = 0;
                $overtime=0;
                $total=0;
                $designation = $emp_info->designation;
                $department = $emp_info->department;
                $employee = $emp_info->id;
                $status='Absent';
                $date = date('Y-m-d',$i);

                $office_in_time = $date.' '.$office_in_time;
                $office_out_time = $date.' '.$office_out_time;

                if($emp_info->uid($request->device)){
                    $uid = $emp_info->uid($request->device)->uid;
                    $shift = false;
                    /**Check if employee has schedule */
                    if($emp_info->schedule){
                        if(strtotime($emp_info->schedule->end)>=$i && strtotime($emp_info->schedule->start)<=$i){
                            $shiftingplan = $emp_info->schedule->shiftingplan;
                            $start = strtotime($emp_info->schedule->start)/86400;
                            $total_days = max(array_column($shiftingplan->toarray(), 'total'));
                            $days = 1;
                            $pdate = strtotime($date)/86400;
                            if($pdate > $start){
                                $days = ($pdate+1) - $start;
                            }
                            if($days > $total_days){
                                $days = $days%$total_days;
                            }
                            // check if schedule has shift
                            foreach($shiftingplan as $plan){
                                if($plan->total >= $days ){
                                    $shift = $plan->shift;
                                    break;
                                }
                            }
                        }
                        if($shift){
                            if($shift->id == 0)
                            {
                                $status='Holiday';
                            }
                            else{
                                $office_in_time = $date.' '.$shift->start;
                                $office_out_time= $date.' '.$shift->end;
                            }
                        }
                    }else if(in_array(date('w',strtotime($date)), unserialize(app_config('WeeklyHoliday')))){
                        $status='Holiday';
                    }

                    $min_office_in_time = strtotime('-30 minutes',strtotime($office_in_time));
                    $max_office_out_time = strtotime('+30 minutes',strtotime($office_out_time));
                    if($max_office_out_time<$min_office_in_time){
                        $max_office_out_time = strtotime('+24 hours', $max_office_out_time);
                        $office_out_time = strtotime('+24 hours', strtotime($office_out_time));
                        $office_out_time = date('Y-m-d H:i', $office_out_time);
                    }
                    $att = \DB::select("SELECT MIN(timestamp) AS clock_in, MAX(timestamp) AS clock_out FROM logs WHERE uid ='".$uid."' AND  timestamp >= '".date('Y-m-d H:i:s',$min_office_in_time)."' AND  timestamp <= '".date('Y-m-d H:i:s',$max_office_out_time)."'");

                    if($att[0]->clock_in){

                        $clock_in = date('Y-m-d H:i',strtotime($att[0]->clock_in));
                        $clock_out = date('Y-m-d H:i',strtotime($att[0]->clock_out));

                        $entry_time=strtotime($clock_in);
                        $out_time=strtotime($clock_out);

                        $max_office_in_time = strtotime('+'.$restintime.' minutes',strtotime($office_in_time));
                        $min_office_out_time = strtotime('-'.$restouttime.' minutes',strtotime($office_out_time));

                        /* Late time */
                        if ($entry_time > $max_office_in_time) {
                            $late = $entry_time-strtotime($office_in_time);
                        }
                        else{
                            $entry_time = strtotime($office_in_time);
                        }

                        /* Early leave time */
                        if ($min_office_out_time > $out_time) {
                            $early_leave = strtotime($office_out_time) - $out_time;
                        }

                        /* Working hours */
                        $office_hour = strtotime($office_out_time) - strtotime($office_in_time);

                        /* Total working time */
                        $total = $out_time-$entry_time;
                        if($total<0){
                            $total = 0;
                        }
                        $overtime = $total-$office_hour;

                        if($overtime<0){
                            $overtime = 0;
                        }

                        $attendance = Attendance::where('emp_id', $employee)->where('date', $date)->first();

                        $status='Present';
                        // $clock_in = 0;
                        // $clock_out = 0;
                        $late = round($late/60, 2);
                        $early_leave = round($early_leave/60, 2);
                        $overtime = round($overtime/60, 2);
                        $total = round($total/60, 2);
                        $clock_in = date('h:i A', strtotime($clock_in));
                        $clock_out =date('h:i A', strtotime($clock_out));
                        // echo('<pre>');
                        // echo($office_hour.'<br>');
                        // echo($office_in_time.'<br>');
                        // echo($office_out_time.'<br>');
                        // echo($emp_info->fname.'<br>');
                        // print_r($emp_info->leaves($date));
                        // print_r($att);
                    }
                }
                if($emp_info->leaves($date)){
                    $status='Leave';
                }

                $attendance = Attendance::where('emp_id', $employee)->where('date', $date)->first();
                if ($attendance){
                    $attendance->clock_in = $clock_in;
                    $attendance->clock_out = $clock_out;
                    $attendance->late = $late;
                    $attendance->early_leaving = $early_leave;
                    $attendance->overtime= $overtime;
                    $attendance->total= $total;
                    $attendance->status = $status;
                    $attendance->save();
        
                } else {
                    $att = new Attendance();
                    $att->emp_id = $employee;
                    $att->designation = $designation;
                    $att->department = $department;
                    $att->date = $date;
                    $att->clock_in = $clock_in;                     
                    $att->clock_out = $clock_out;
                    $att->late = $late;
                    $att->early_leaving = $early_leave;
                    $att->overtime= $overtime;
                    $att->total = $total;
                    $att->status = $status;
                    $att->save();
                }
            }
        }
        
        return redirect('attendance/report')->with([
            'message' => language_data('Attendance Updated Successfully')
        ]);
    }


    /* getDesignation  Function Start Here */
    public function getDesignation(Request $request)
    {

        $dep_id = $request->dep_id;
        if ($dep_id) {
            echo '<option value="0">Select Designation</option>';
            $designation = Designation::where('did', $dep_id)->get();
            foreach ($designation as $d) {
                echo '<option value="' . $d->id . '">' . $d->designation . '</option>';
            }
        }
    }

    /* postCustomSearch  Function Start Here */
    public function postCustomSearch(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'date_from' => 'required','date_to' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('attendance/report')->withErrors($v->errors());
        }

        $date_from = Input::get('date_from');
        $date_to = Input::get('date_to');
        $date_from=date('Y-m-d',strtotime($date_from));
        $date_to=date('Y-m-d',strtotime($date_to));


        $emp_id = Input::get('employee');
        $dep_id = Input::get('department');
        $des_id = Input::get('designation');

        $designation = Designation::where('did',$dep_id)->get();


        $attendance_query = Attendance::whereBetween('date', [$date_from,$date_to]);

        if ($emp_id) {
            $attendance_query->Where('emp_id', $emp_id);
        }

        if ($dep_id) {
            $attendance_query->Where('department', $dep_id);
        }

        if ($des_id) {
            $attendance_query->Where('designation', $des_id);
        }

        $attendance = $attendance_query->get();


        $employee = Employee::where('status', 'active')->get();
        $department = Department::all();
        return view('admin.attendance', compact('attendance', 'employee', 'department', 'date_to','date_from', 'emp_id', 'dep_id', 'des_id','designation'));

    }
    /* getPdfReport  Function Start Here */
    public function getPdfReport($date,$emp_id=0,$dep_id=0,$des_id=0)
    {

        $date=explode('_',$date);

        if (is_array($date)){
            $date_from=$date['0'];
            $date_to=$date['1'];
        }else{
            return redirect('attendance/report')->with([
                'message' => 'Invalid Date',
                'message_important' => true
            ]);
        }

        $date_from=date('Y-m-d',strtotime($date_from));
        $date_to=date('Y-m-d',strtotime($date_to));
        $attendance_query = Attendance::whereBetween('date', [$date_from,$date_to]);

        if ($emp_id) {
            $attendance_query->Where('emp_id', $emp_id);
        }

        if ($dep_id) {
            $attendance_query->Where('department', $dep_id);
        }

        if ($des_id) {
            $attendance_query->Where('designation', $des_id);
        }

        $attendance = $attendance_query->get();

        $pdf=PDF::loadView('admin.all-pdf-attendance-report', compact('attendance'));

        return $pdf->download('attendance.pdf');
    }

    /* editAttendance  Function Start Here */
    public function editAttendance($id)
    {
        $self='attendance-report';

        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $attendance = Attendance::find($id);
        if ($attendance) {
            return view('admin.edit-attendance', compact('attendance'));
        } else {
            return redirect('attendance/report')->with([
                'message' => language_data('Attendance Info Not Found'),
                'message_important' => true
            ]);
        }
    }

    /* postEditAttendance  Function Start Here */
    public function postEditAttendance(Request $request)
    {
        $cmd = Input::get('cmd');
        $v = \Validator::make($request->all(), [
            'clock_in' => 'required', 'clock_out' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('attendance/edit/' . $cmd)->withErrors($v->errors());
        }

        $clock_in = Input::get('clock_in');
        $clock_out = Input::get('clock_out');

        $entry_time=strtotime($clock_in);
        $out_time=strtotime($clock_out);

        $get_attendance_data=$out_time-$entry_time;

        $check_clock=($get_attendance_data > 0 ) ? 1 : ( ( $get_attendance_data < 0 ) ? -1 : 0);

        if ($check_clock==-1){
            return redirect('attendance/edit/' . $cmd)->with([
                'message'=>language_data('Insert your time perfectly'),
                'message_important'=>true
            ]);
        }


        $office_in_time = app_config('OfficeInTime');
        $office_out_time = app_config('OfficeOutTime');

        $check_out_entry=strtotime($office_in_time);
        $check_out_data=$out_time-$check_out_entry;


        $check_clock=($check_out_data > 0 ) ? 1 : ( ( $check_out_data < 0 ) ? -1 : 0);

        if ($check_clock==-1){
            return redirect('attendance/edit/' . $cmd)->with([
                'message'=>language_data('Office time: In Time').$office_in_time.' '.language_data('and Out Time').' '.$office_out_time,
                'message_important'=>true
            ]);
        }

        $late_1 = strtotime($office_in_time);
        $late_2 = strtotime($clock_in);
        $late = ($late_2 - $late_1);

        if ($late < 0) {
            $late = 0;
        }
        $late = $late / 60;


        $early_leave_1 = strtotime($clock_out);
        $early_leave_2 = strtotime($office_out_time);
        $early_leave = ($early_leave_2 - $early_leave_1);

        if ($early_leave < 0) {
            $early_leave = 0;
        }
        $early_leave = $early_leave / 60;

        $office_hour = (strtotime($office_out_time) - strtotime($office_in_time)) / 60;
        $total = $office_hour - $late - $early_leave;


        $attendance = Attendance::find($cmd);

        if ($attendance) {
            $attendance->clock_in = $clock_in;
            $attendance->clock_out = $clock_out;
            $attendance->late = $late;
            $attendance->early_leaving = $early_leave;
            $attendance->total = $total;
            $attendance->status = 'Present';
            $attendance->save();

            return redirect('attendance/report')->with([
                'message' => language_data('Attendance Update Successfully')
            ]);

        } else {
            return redirect('attendance/report')->with([
                'message' => language_data('Attendance Info Not Found'),
                'message_important' => true
            ]);
        }


    }

    /* deleteAttendance  Function Start Here */
    public function deleteAttendance($id)
    {
        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('attendance/report')->with([
                'message'=>language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }

        $self='attendance-report';

        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $attendance=Attendance::find($id);
        if($attendance){
            $attendance->delete();
            return redirect()->back()->with([
                'message' => language_data('Attendance Deleted Successfully')
            ]);
        }else{
            return redirect()->back()->with([
                'message' => language_data('Attendance Info Not Found'),
                'message_important' => true
            ]);
        }
    }


}
