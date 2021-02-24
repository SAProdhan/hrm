@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection

@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('Employee Connected to device')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('Add employee to device')}}</h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="{{url('employees/device')}}">

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="el3">{{language_data('Department')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="department" id="department_id">
                                                <option value="0">{{language_data('Select Department')}}</option>
                                                @foreach($department as $d)
                                                <option value="{{$d->id}}"> {{$d->department}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{--<div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="el3">{{language_data('Designation')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="designation" id="designation">
                                                <option value="">{{language_data('Select Designation')}}</option>
                                            </select>
                                        </div>
                                    </div>--}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="el3">{{language_data('Employee')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="employee" id="employee">
                                            <option selected disabled>{{language_data('Select Employee')}}</option>
                                                @foreach($employee as $d)
                                                    <option value="{{$d->id}}" >{{$d->fname}} {{$d->lname}} ({{$d->employee_code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="device">{{language_data('Device')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="device" id="device_id">
                                                <option selected disabled>{{language_data('Select Device')}}</option>
                                                @foreach($device as $d)
                                                <option value="{{$d->id}}"> {{$d->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="uid">{{language_data('User from device')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" disabled name="uid" id="uid">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-link"></i> {{language_data('Connect')}}</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('Employee with Device')}}</h3>
                        {{--    @if($date_from=='' && $date_to=='')
                                <a href="{{url('attendance/get-all-pdf-report')}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-file-pdf-o"></i> {{language_data('Generate PDF')}}</a><br>
                            @else
                                <a href="{{url('attendance/get-pdf-report/'.$date_from.'_'.$date_to.'/'.$emp_id.'/'.$dep_id.'/'.$des_id)}}" class="btn btn-success btn-xs pull-right"><i class="fa fa-file-pdf-o"></i> {{language_data('Generate PDF')}}</a><br>
                            @endif
                            --}}

                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 20%;">{{language_data('Employee Name')}}</th>
                                    <th style="width: 20%;">{{language_data('Code')}}</th>
                                    <th style="width: 20%;">{{language_data('Device')}}</th>
                                    <th style="width: 20%;">{{language_data('ID(in device)')}}</th>
                                    <th style="width: 20%;">{{language_data('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($employeeIndevice as $d)
                                    <tr>
                                        <td data-label="employee_name"><a href="{{url('employees/view/'.$d->employee_id)}}">{{$d->employee->fname}} {{$d->employee->lname}}</a></td>
                                        <td data-label="Code">{{$d->employee->employee_code}}</td>
                                        <td data-label="Device">{{$d->device->name}}</td>
                                        <td data-label="uid">{{$d->uid}}</td>
                                        <td data-label="Actions">
                                            {{--<a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target=".modal_edit_designation_{{$d->employee_id}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
                                            @include('admin.modal.edit-employee-to-device')--}}
                                            <form method="POST" action="{{url('employees/device-remove')}}" style="display:inline-block;">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="employee_id" value="{{$d->employee->id}}">
                                                <input type="hidden" name="device_id" value="{{$d->device->id}}">
                                                <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure? You want to delete {{$d->employee->fname}} {{$d->employee->lname}} from {{$d->device->name}}?')"><i class="fa fa-trash"></i> {{language_data('Delete')}}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
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
                {{--$.ajax
                ({
                    type: "POST",
                    url: _url + '/attendance/get-designation',
                    data: dataString,
                    cache: false,
                    success: function ( data ) {
                        $("#designation").html( data).removeAttr('disabled').selectpicker('refresh');
                    }
                });--}}
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

            /*For get user from device */
            $("#device_id").change(function () {
                var id = $(this).val();
                var _url = $("#_url").val();
                var dataString = 'id=' + id;
                $.ajax
                ({
                    type: "POST",
                    url: _url + '/employee/get-uid',
                    data: dataString,
                    cache: false,
                    success: function ( data ) {
                        $("#uid").html( data).removeAttr('disabled').selectpicker('refresh');
                    }
                });
            });
            $(".device").change(function () {
                var id = $(this).val();
                var _url = $("#_url").val();
                var dataString = 'id=' + id;
                $.ajax
                ({
                    type: "POST",
                    url: _url + '/employee/get-uid',
                    data: dataString,
                    cache: false,
                    success: function ( data ) {
                        $(".uid").html( data).removeAttr('disabled').selectpicker('refresh');
                    }
                });
            });

        });
    </script>


@endsection
