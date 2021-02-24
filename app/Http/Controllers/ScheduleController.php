<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Shift;
use App\Models\ShiftingPlan;

use Illuminate\Http\Request;

class ScheduleController extends Controller
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
        $shifts= Shift::all();
        $schedules = Schedule::all();
        return view('admin.schedule_and_shift.schedule')->with('shifts', $shifts)->with('schedules', $schedules);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|unique:schedules|max:20',
            'start' => 'required',
            'end' => 'required',
            'shift' => 'required',
            'sequence' => 'required',
            'days' => 'required',
        ]);
        
        $data = $request->all();

        $schedule = Schedule::create(array(
            'name'=> $request->name,
            'start'=>$request->start,
            'end'=> $request->end,
        ));
        $temp = Array();
        $total = 0;
        if($schedule){
            for($i=0;$i<count($request->shift);$i++){
                array_push($temp, Array(
                    'schedule_id'=>$schedule->id,
                    'shift_id'=>$request->shift[$i],
                    'sequence'=>$request->sequence[$i],
                    'days'=>$request->days[$i],
                ));
            }
            uasort($temp, function($a, $b) {
                return strcmp($a['sequence'], $b['sequence']);
            });
            $total = 0;
            for($i=0;$i<count($temp);$i++){
                $total += $temp[$i]['days'];
                $temp[$i]['total'] = $total;
            }
            $shiftPlan = ShiftingPlan::insert($temp);

            if($shiftPlan){
                return redirect()->back()->with([
                    'message'=> language_data('Schedule added Successfully')
                ]);
            }
            else{
                return redirect()->back()->with([
                    'message'=> language_data('Failed to insert data'),
                    'message_important'=>true
                ]);
            }
        }
        return redirect()->back()->with([
            'message'=> language_data('Failed to insert data'),
            'message_important'=>true
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        echo("<pre>");
        foreach($schedule->shiftingplan as $plan){
            var_dump($plan);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'name' => 'required|max:20|unique:schedules,name,'.$schedule->id,
            'start' => 'required',
            'end' => 'required',
            'shift' => 'required',
            'sequence' => 'required',
            'days' => 'required',
        ]);

        $schedule->name=$request->name;
        $schedule->start=$request->start;
        $schedule->end=$request->end;
        $status=$schedule->save();
        $temp = Array();
        if($status){
            $status = ShiftingPlan::where('schedule_id', $schedule->id)->delete();
            for($i=0;$i<count($request->shift);$i++){
                array_push($temp, Array(
                    'schedule_id'=>$schedule->id,
                    'shift_id'=>$request->shift[$i],
                    'sequence'=>$request->sequence[$i],
                    'days'=>$request->days[$i],
                ));
            }
            uasort($temp, function($a, $b) {
                return strcmp($a['sequence'], $b['sequence']);
            });
            $total = 0;
            for($i=0;$i<count($temp);$i++){
                $total += $temp[$i]['days'];
                $temp[$i]['total'] = $total;
            }
            $shiftPlan = ShiftingPlan::insert($temp);

            if($shiftPlan){
                return redirect()->back()->with([
                    'message'=> language_data('Schedule Updated Successfully')
                ]);
            }
            else{
                return redirect()->back()->with([
                    'message'=> language_data('Failed to update Schedule'),
                    'message_important'=>true
                ]);
            }
        }
        return redirect()->back()->with([
            'message'=> language_data('Error! Failed to update Schedule'),
            'message_important'=>true
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $status = $schedule->delete();
        if($status){
            return redirect()->back()->with([
                'message'=> language_data('Schedule Deleted Successfully')
            ]);
        }
        else{
            return redirect()->back()->with([
                'message'=> language_data('Failed to Delete Schedule'),
                'message_important'=>true
            ]);
        }
    }
}
