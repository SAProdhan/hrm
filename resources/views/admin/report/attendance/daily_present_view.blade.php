@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection

@section('content')
    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('DAILY PRESENT')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('Report Condition')}}</h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="{{url('reports/attendance-daily-present')}}">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="el2">{{language_data('Date')}}</label>
                                            <input type="text" id="date_from" class="form-control datePicker" required="" name="date" value="{{get_date_format($date)}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
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

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="el3">{{language_data('Employee')}}</label>
                                            <select class="selectpicker form-control" multiple data-live-search="true" name="department">
                                                <option value="" >{{language_data('Select Employee')}}</option>
                                                @foreach($employees as $d)
                                                    <option value="{{$d->id}}" @if($d->id==$emp_id) selected @endif>{{$d->fname}} {{$d->lname}} ({{$d->employee_code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-search"></i> {{language_data('Preview')}}</button>

                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
            @if($date!='')
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('Attendance')}}</h3>
                            <form action="{{url('reports/attendance-month-wise-pdf')}}" method="post">
                                <input type="hidden" name="emp_id[]" value="{{$emp_id}}">
                                <input type="hidden" name="date" value="{{get_date_format($date)}}">
                                @if($emp_id !='')
                                    @foreach($emp_id as $d)
                                    <input type="hidden" name="employee[]" value="{{$d}}">
                                    @endforeach
                                @else
                                <input type="hidden" name="employee[]" value="{{$emp_id}}">
                                @endif
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-file-pdf-o"></i> {{language_data('Generate PDF')}}</button>
                            </form>
                            <br>
                        </div>

                        <div class="row" style="padding-left:20px; padding-bottom:20px">
                            <div class="col-md-10 offset-md-2 text-uppercase pr-3">
                                DAILY PRESENT DATE OF {{get_date_format($date)}} ({{date('D', strtotime($date))}})
                            </div>
                        </div>
                        
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
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
                    </div>
                </div>
            @endif
            </div>
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
