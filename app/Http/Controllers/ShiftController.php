<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Classes\permission;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $self = 'shifts';

        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }
        $shifts=Shift::all();
        return view('admin.schedule_and_shift.shift')->with('shifts', $shifts);
        
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
            'name' => 'required|unique:shifts|max:20',
            'start' => 'required',
            'end' => 'required',
        ]);
        // echo('<pre>');
        // var_dump($request->all());
        
        $data = $request->all();
        
        $status = Shift::create($data);

        if($status){
            return redirect()->back()->with([
                'message'=> language_data('Shift added Successfully')
            ]);
        }
        else{
            return redirect()->back()->with([
                'message'=> language_data('Failed to insert data'),
                'message_important'=>true
            ]);
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'name' => 'required|max:20|unique:shifts,name,'.$shift->id,
            'start' => 'required',
            'end' => 'required',
        ]);
        // echo('<pre>');
        // var_dump($request->all());
        
        $data = $request->all();
        
        $shift->name = $request->name;
        $shift->start = $request->start;
        $shift->end = $request->end;
        $status = $shift->save();
        if($status){
            return redirect()->back()->with([
                'message'=> language_data('Shift Updated Successfully')
            ]);
        }
        else{
            return redirect()->back()->with([
                'message'=> language_data('Failed to Update data'),
                'message_important'=>true
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        $status = $shift->delete();
        if($status){
            return redirect()->back()->with([
                'message'=> language_data('Shift Deleted Successfully')
            ]);
        }
        else{
            return redirect()->back()->with([
                'message'=> language_data('Failed to Delete Shift'),
                'message_important'=>true
            ]);
        }
    }
}
