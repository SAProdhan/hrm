@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection

@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('Attendance')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('Search Condition')}}</h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="{{url('reports/attendance-month-wise')}}">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="el2">{{language_data('Month')}}</label>
                                            <input type="text" id="date_from" class="form-control monthPicker" required="" name="month" value="{{$month}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="el3">{{language_data('Department')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="department" id="department_id">
                                                <option value="0">{{language_data('Select Department')}}</option>
                                                @foreach($department as $d)
                                                <option value="{{$d->id}}" @if($dep_id==$d->id) selected @endif> {{$d->department}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="el3">{{language_data('Employee')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="employee" id="employee" required> 
                                                <option value="" >{{language_data('Select Employee')}}</option>
                                                @foreach($employees as $d)
                                                    <option value="{{$d->id}}" @if($d->id==$emp_id) selected @endif>{{$d->fname}} {{$d->lname}} ({{$d->employee_code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-search"></i> {{language_data('Search')}}</button>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
            @if(isset($employee))
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        @if($month!='')
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('Attendance')}}</h3>
                            <a href="{{url('reports/attendance-month-wise-pdf/'.$month.'/'.$emp_id)}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-file-pdf-o"></i> {{language_data('Generate PDF')}}</a><br>
                            @endif
                        </div>
                        
                        <div class="row" style="padding-left:20px; padding-bottom:20px">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 text-center"></H1></div>
                                </div>
                                <h4>Employee Information:</h4>
                                 <div class="row">
                                     <div class="col-md-3">Name</div>
                                     <div class="col-md-7">: {{$employee->fname}} {{$employee->lname}}</div>
                                     <div class="col-md-2"><strong>Month: {{date('F Y',strtotime($month))}}</strong></div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-3">ID</div>
                                     <div class="col-md-9">: {{$employee->employee_code}}</div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-3">Designation</div>
                                     <div class="col-md-9">: {{$employee->designation_name->designation}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">Department</div>
                                     <div class="col-md-9">: {{$employee->department_name->department}}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">{{language_data('Date')}}</th>
                                        <th style="width: 10%;">{{language_data('Clock In')}}</th>
                                        <th style="width: 10%;">{{language_data('Clock Out')}}</th>
                                        <th style="width: 5%;">{{language_data('Late')}}</th>
                                        <th style="width: 5%;">{{language_data('Early Leaving')}}</th>
                                        <th style="width: 5%;">{{language_data('Overtime')}}</th>
                                        <th style="width: 10%;">{{language_data('Total Work')}}</th>
                                        <th style="width: 10%;">{{language_data('Status')}}</th>
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
                                        <td data-label="Date">{{get_date_format($d->date)}}</td>
                                        <td data-label="Clock_In">{{$d->clock_in}}</td>
                                        <td data-label="Clock_out">{{$d->clock_out}}</td>
                                        <td data-label="Late">{{floor($d->late/60)}}:{{floor($d->late%60)}}H</td>
                                        <td data-label="Early_leaving">{{floor($d->early_leaving/60)}}:{{floor($d->early_leaving%60)}}H</td>
                                        <td data-label="Overtime">{{floor($d->overtime/60)}}:{{floor($d->overtime%60)}}H</td>
                                        <td data-label="Total_Work">{{floor($d->total/60)}}:{{floor($d->total%60)}} H</td>
                                        @if($d->status=='Absent')
                                        <td data-label="Status"><p class="btn btn-danger btn-xs">{{language_data('Absent')}}</p></td>
                                        @elseif($d->status=='Holiday')
                                        <td data-label="Status"><p class="btn btn-complete btn-xs">{{language_data('Holiday')}}</p></td>
                                        @elseif($d->status=='Leave')
                                        <td data-label="Status"><p class="btn btn-primary btn-xs">{{language_data('leave')}}</p></td>
                                        @else
                                        <td data-label="Status"><p class="btn btn-success btn-xs">{{language_data('Present')}}</p></td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <h4 style="padding-left:20px;">Report summary: </h4>
                        <h6></h6>
                        <div class="row" style="padding-left:20px;">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">Total: {{$total}} days</div>
                                    <div class="col-md-4">Present: {{$present}} days</div>
                                    <div class="col-md-4">Absent: {{$absent}} days</div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row" style="padding-left:20px; padding-bottom:20px;">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">Late: {{$late}} days</div>
                                    <div class="col-md-4">Leave: {{$leave}} days</div>
                                    <div class="col-md-4">Holidays: {{$holiday}} days</div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <br>
        <br>
    </section>

@endsection

{{--External Style Section--}}
@section('script')
    {!! Html::script("assets/libs/data-table/datatables.min.js")!!}
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/libs/moment/moment.min.js")!!}
    {!! Html::script("assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}
    {!! Html::script("assets/js/bootbox.min.js")!!}
    <script>
        $(document).ready(function () {

            /*For DataTable*/
            $('.data-table').DataTable();

            /*For Designation Loading*/
            $("#department_id").change(function () {
                var id = $(this).val();
                var _url = $("#_url").val();
                var dataString = 'dep_id=' + id;
                $.ajax
                ({
                    type: "POST",
                    url: _url + '/departments/get-employee',
                    data: dataString,
                    cache: false,
                    success: function ( data ) {
                        $("#employee").html( data).removeAttr('disabled').selectpicker('refresh');
                    }
                });
            });
        });
    </script>
@endsection
