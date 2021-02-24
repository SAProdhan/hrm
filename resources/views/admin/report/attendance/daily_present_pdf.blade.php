<!DOCTYPE html>
<html lang="en">
<title>{{app_config('AppName')}} - {{language_data('Attendance Report')}}</title>

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
            <div class="col-xs-12 text-center"><H1>Attendance Report</H1></div>
        </div>

        <h4>DAILY PRESENT DATE OF {{get_date_format($date)}} ({{date('D', strtotime($date))}})</h4>
            
        <div class="row">
            <table class="col-xs-12">
                <thead>
                    <tr>
                        <th style="width: 5%;">{{language_data('#SL')}}</th>
                        <th style="width: 10%;">{{language_data('Employee Id')}}</th>
                        <th style="width: 25%;">{{language_data('Name')}}</th>
                        <th style="width: 15%;">{{language_data('Designation')}}</th>
                        <th style="width: 15%;">{{language_data('In Time')}}</th>
                        <th style="width: 10%;">{{language_data('Late')}}</th>
                        <th style="width: 20%;">{{language_data('Remarks')}}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($attendance as $i=>$d)
                    @if($d->status=='Present')
                    <tr>
                        <td data-label="#SL">{{$i}}</td>
                        <td data-label="Code">{{$d->employee_info->employee_code}}</td>
                        <td data-label="Name">{{$d->employee_info->fname}} {{$d->employee_info->lname}}</td>
                        <td data-label="Designation">{{$d->department_name->department}}</td>
                        <td data-label="Intime">{{$d->clock_in}}</td>
                        <td data-label="Late">{{date('H:i:s', $d->late*60)}}</td>
                        <td data-label="Remarks"></td>                                        
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
        <br>
    </div>
</body>
</html>                       