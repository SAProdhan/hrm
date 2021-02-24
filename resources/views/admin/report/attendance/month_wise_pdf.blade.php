<!DOCTYPE html>
<html lang="en">
<title>{{app_config('AppName')}} - {{language_data('Attendance')}}</title>
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
{!! Html::style("assets/libs/bootstrap/css/bootstrap.min.css") !!}
<head>
    <style>
        table tr td{
            border:solid 1px black;
            font-size: 12px;
            padding-left:5px;
        }
        table tr th{
            font-weight:bold;
            border:solid 1px black;
            font-size: 12px;
            padding-left:5px;
        }
        *{
            color:black;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">            
            <div class="col-xs-9 text-center"><H3>Monthly Attendance Report</H3></div>
            <div class="col-xs-3 "><strong>Month: {{date('F Y',strtotime($month))}}</strong></div>
        </div>
                <!-- <pre>
                    @php
                        print_r($employee);
                    @endphp
                </pre> -->
        <h4>Employee Information:</h4>
        <div class="row">
            <div class="col-xs-3">Name</div>
            <div class="col-xs-9">: {{$employee->fname}} {{$employee->lname}}</div>
        </div>

        <div class="row">
           <div class="col-xs-3">ID</div>
            <div class="col-xs-9">: {{$employee->employee_code}}</div> 
        </div>

        <div class="row">
            <div class="col-xs-3">Designation</div>
            <div class="col-xs-9">: {{$employee->designation_name->designation}}</div>
        </div>
        
        <div class="row">
            <div class="col-xs-3">Department</div>
            <div class="col-xs-9">: {{$employee->department_name->department}}</div>
        </div>
        <br>
        <div class="row">
            <table class="col-xs-12">
                <thead>
                    <tr>
                        <th style="width: 15%;">{{language_data('Date')}}</th>
                        <th style="width: 15%;">{{language_data('Clock In')}}</th>
                        <th style="width: 15%;">{{language_data('Clock Out')}}</th>
                        <th style="width: 15%;">{{language_data('Late')}}</th>
                        <th style="width: 13%;">{{language_data('Early Leaving')}}</th>
                        <th style="width: 13%;">{{language_data('Overtime')}}</th>
                        <th style="width: 13%;">{{language_data('Total Work')}}</th>
                        <th style="width: 13%;">{{language_data('Status')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $present = 0;
                        $absent = 0;
                        $late = 0;
                        $leave = 0;
                        $holiday = 0;
                    @endphp
                    @foreach($attendance as $i=>$d)
                    @php
                        $total += 1;
                        if($d->late > 0) $late += 1;
                        if($d->status == 'Present') $present++;
                        else if($d->status == 'Absent') $absent++;
                        else if($d->status == 'Leave') $leave++;
                        else if($d->status == 'Holiday') $holiday++;
                    @endphp
                    <tr>
                        <td>{{get_date_format($d->date)}}</td>
                        <td>{{$d->clock_in}}</td>
                        <td>{{$d->clock_out}}</td>
                        <td>{{floor($d->late/60)}}:{{floor($d->late%60)}}H</td>
                        <td>{{floor($d->early_leaving/60)}}:{{floor($d->early_leaving%60)}}H</td>
                        <td>{{floor($d->overtime/60)}}:{{floor($d->overtime%60)}}H</td>
                        <td>{{floor($d->total/60)}}:{{floor($d->total%60)}} H</td>
                        @if($d->status=='Absent')
                        <td><p>{{language_data('A')}}</p></td>
                        @elseif($d->status=='Holiday')
                        <td><p>{{language_data('H')}}</p></td>
                        @elseif($d->status=='Leave')
                        <td><p>{{language_data('L')}}</p></td>
                        @else
                        <td><p>{{language_data('P')}}</p></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <br>

        <h4>Report summary:</h4>
        <div class="row">
            <div class="col-xs-4">Total: {{$total}} days</div>
            <div class="col-xs-4">Present: {{$present}} days</div>
            <div class="col-xs-4">Absent: {{$absent}} days</div>
        </div>
        <div class="row">
            <div class="col-xs-4">Late: {{$late}} days</div>
            <div class="col-xs-4">Leave: {{$leave}} days</div>
            <div class="col-xs-4">Holidays: {{$holiday}} days</div>
        </div>
    </div>
</body>
</html>                       