<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Employeetodevice;
use App\Models\Log;
use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;
use App\Employee;
use Illuminate\Support\Facades\DB;
use DateTime;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    public function index()
    {
        // $device = Device::find(1);
        // $zk = new ZKTeco($device->ip);
        // $employee = Employee::all('id')->toArray();
        // $zk->connect(); 
        // echo('<pre>'); 
        // print_r($zk->getUser());
        // echo('</pre><br><pre>'); 
        // print_r(array_reverse($zk->getAttendance()));
        $employees=Employee::all();

        echo('<pre>');
        foreach($employees as $employee){
            if($employee->leaves('2021-01-03')){
                echo($employee->leaves('2021-01-03'));
            }
        }        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $date = strtotime('17-02-2021');
        $total = 0;
        $emp_device = Employee::all();
        echo('<pre>');
        foreach($emp_device as $emp_info){
            if($emp_info->schedule){
                if(strtotime($emp_info->schedule->end)>=$date && strtotime($emp_info->schedule->start)<=$date)
                {
                    $shiftingplan = $emp_info->schedule->shiftingplan;
                    $start = strtotime($emp_info->schedule->start)/86400;
                    $total = max(array_column($shiftingplan->toarray(), 'total'));
                    $days = 1;
                    $date = $date/86400;
                    if($date > $start){
                        $days = ($date+1) - $start;
                    }
                    if($days > $total){
                        $days = $days%$total;
                    }

                    foreach($shiftingplan as $plan){
                        if($plan->total >= $days ){
                            print_r($plan->shift);
                            break;
                        }
                    }
                    echo('<br>');
                    print_r($days);
                    echo('<br>');
                    print_r($total);
                }
                // $shiftingplan = ;
                // $total = max(array_column($shiftingplan->toarray(), 'total'));
                // var_dump($total);
                
            }
            
        }
        
        // $device = Device::find(1);
        // $zk = new ZKTeco($device->ip);
        // $employee = Employee::all('id')->toArray();
        // $zk->connect();   
        // $logs=$zk->getAttendance();
        // $data = Array();
        // $last_id = Log::where('device_id', $device->id)->orderBy('id','desc')->first()->id;
        // foreach($logs as $log){
        //     if($log['uid']>$last_id)
        //     array_push($data, array(
        //         'id'=>$log['uid'],
        //         'device_id'=>1,
        //         'uid'=>$log['id'],
        //         'timestamp'=>$log['timestamp']
        //     ));
        // }
        // $status = Log::insert($data);
        // if($status){
        //     return redirect('attendance/update')->with([
        //         'message' => language_data('Attendance Updated Successfully')
        //     ]);
        // }
        // else{
        //     return redirect('attendance/update')->with([
        //         'message' => language_data('Faild')
        //     ]);
        // }
        // echo '<pre>';
        // print_r($logs);
        // $att = \DB::select("SELECT * FROM logs WHERE uid ='".$id."' AND DATE_FORMAT(created_at,'%Y')='" . $year . "' AND DATE_FORMAT(created_at,'%m')='" . $month . "'");
        // $att = \DB::select("SELECT MIN(timestamp) AS clock_in, MAX(timestamp) AS clock_out FROM logs WHERE uid ='1' AND  timestamp LIKE '2017-08-23%'");
        // $att->map(function ($item){
        //     $item->clock_in = new DateTime(substr($item->clock_in, 11));
        //     $item->clock_out = new DateTime(substr($item->clock_out, 11));
        //     return $item;
        // });
        // if($att[0]->clock_in){
        //     $time = date('h:i A',strtotime($att[0]->clock_in));
        //     echo '<pre>';
        //     print_r($time);
        // }
        // else print_r($att);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:devices|max:100',
            'ip' => 'required',
            'port' => 'required',
        ]);
        
        $data = $request->all();
        $device = Device::create($data);
        if($device){
            return redirect('settings/general')->with([
                'message'=> language_data('Device Added Successfully')
            ]);
        }
        else{
            return redirect('settings/general')->with([
                'message'=> language_data('Failed to insert data'),
                'message_important'=>true
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:devices,name,'.$device->id,
            'ip' => 'required',
            'port' => 'required',
        ]);

        $data = $request->all();
        $device->fill($data);
        $status=$device->save();
        if($status){
            if($device){
                return redirect('settings/general')->with([
                    'message'=> language_data('Device Updated Successfully')
                ]);
            }
            else{
                return redirect('settings/general')->with([
                    'message'=> language_data('Failed to update data'),
                    'message_important'=>true
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        //
    }
}
