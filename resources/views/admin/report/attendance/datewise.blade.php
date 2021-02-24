<!DOCTYPE html>
<html lang="en">
<title>{{app_config('AppName')}} - {{language_data('Attendance')}}</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<head>
    <style>
        table tr td{
            border:solid 1px black;
            font-size: 10px;
        }
        table tr th{
            font-weight:bold;
            border:solid 1px black;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 17%;">{{language_data('Employee Name')}}</th>
                        <th style="width: 12%;">{{language_data('Date')}}</th>
                        <th style="width: 10%;">{{language_data('Clock In')}}</th>
                        <th style="width: 13%;">{{language_data('Clock Out')}}</th>
                        <th style="width: 7%;">{{language_data('Late')}}</th>
                        <th style="width: 15%;">{{language_data('Early Leaving')}}</th>
                        <th style="width: 5%;">{{language_data('Overtime')}}</th>
                        <th style="width: 10%;">{{language_data('Working Hours')}}</th>
                        <th style="width: 10%;">{{language_data('Status')}}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($attendance as $d)
                    <tr>
                        <td >{{$d->employee_info->fname}} {{$d->employee_info->lname}}</td>
                        <td >{{get_date_format($d->date)}}</td>
                        <td >{{$d->clock_in}}</td>
                        <td >{{$d->clock_out}}</td>
                        <td >{{round($d->late/60,2)}} H</td>
                        <td >{{round($d->early_leaving/60,2)}} H</td>
                        <td >{{$d->overtime}} H</td>
                        <td >{{round($d->total/60,2)+$d->overtime}} H</td>
                        @if($d->status=='Absent')
                            <td ><p>{{language_data('Absent')}}</p></td>
                        @elseif($d->status=='Holiday')
                            <td ><p>{{language_data('Holiday')}}</p></td>
                        @else
                            <td ><p>{{language_data('Present')}}</p></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
</body>
</html>