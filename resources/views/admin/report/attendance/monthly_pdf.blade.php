<!DOCTYPE html>
<html lang="en">
<title>{{app_config('AppName')}} - {{language_data('Attendance')}}</title>
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
{!! Html::style("assets/libs/bootstrap/css/bootstrap.min.css") !!}
<head>
    <style>
        html { margin: 10px;}
        table tr td{
            border:solid 1px black;
            font-size: 10px;
            padding-left:2px;
            /* text-align:center; */
        }
        table tr th{
            font-weight:bold;
            border:solid 1px black;
            font-size: 10px;
            padding-left:2px;
            text-align:center;
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
                {{--<!-- <pre>
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
        </div>--}}
        <br>
        <div class="row">
            <table class="col-xs-12">
                <thead>
                    <tr>
                        <th rowspan="2" style="width:4%;">{{language_data('Emp Id')}}</th>
                        <th rowspan="2" style="width:8%;">{{language_data('Name')}}</th>
                        <th rowspan="2" style="width:13%;">{{language_data('Designation')}}</th>
                        <th colspan="{{$days}}" style="width:65%;">{{language_data('Days')}}</th>
                        <th rowspan="2" style="width:2%;">{{language_data('P')}}</th>
                        <th rowspan="2" style="width:2%;">{{language_data('A')}}</th>
                        <th rowspan="2" style="width:2%;">{{language_data('LP')}}</th>
                        <th rowspan="2" style="width:2%;">{{language_data('L')}}</th>
                        <th rowspan="2" style="width:2%;">{{language_data('H')}}</th>
                    </tr>
                    <tr>
                    @for($i=1;$i<=$days;$i++)
                    <th style="width:2%;">{{$i}}</th>
                    @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthly_att as $d)
                    <tr>
                        <td>{{$d['code']}}</td>
                        <td>{{$d['name']}}</td>
                        <td>{{$d['designation']}}</td>
                        @for($i=1;$i<=$days;$i++)
                        <td>{{$d['att'][$i]}}</td>
                        @endfor
                        <td>{{$d['p']}}</td>
                        <td>{{$d['a']}}</td>
                        <td>{{$d['lp']}}</td>
                        <td>{{$d['l']}}</td>
                        <td>{{$d['h']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>   
        <br>
    </div>
</body>
</html>