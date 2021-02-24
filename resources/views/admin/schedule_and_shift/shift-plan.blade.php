@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection

@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('Shift Schedule')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('Set employee Schedule')}}</h3>
                        </div>
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="{{route('shiftin-plan.store')}}">
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

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="employee">{{language_data('Employee')}}</label>
                                            <select class="selectpicker form-control" multiple data-live-search="true" name="employee[]" id="employee">
                                            @foreach($employee as $d)
                                                <option value="{{$d->id}}" >{{$d->fname}} {{$d->lname}} ({{$d->employee_code}})</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="schedule">{{language_data('Schedule')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="schedule">
                                                @foreach($schedules as $d)
                                                    <option value="{{$d->id}}" >{{$d->name}} ({{$d->start}} to {{$d->end}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-add"></i> {{language_data('Set')}}</button>

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
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 25%;">{{language_data('Employee Name')}}</th>
                                    <th style="width: 15%;">{{language_data('Code')}}</th>
                                    <th style="width: 10%;">{{language_data('Schedule')}}</th>
                                    <th style="width: 15%;">{{language_data('From')}}</th>
                                    <th style="width: 15%;">{{language_data('To')}}</th>
                                    <th style="width: 20%;">{{language_data('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($employee as $d)
                                @if($d->schedule)
                                <tr>
                                    <td data-label="employee_name"><a href="{{url('employees/view/'.$d->employee_id)}}">{{$d->fname}} {{$d->lname}}</a></td>
                                    <td data-label="Code">{{$d->employee_code}}</td>
                                    <td data-label="Device">{{$d->schedule->name}}</td>
                                    <td data-label="From">{{$d->schedule->start}}</td>
                                    <td data-label="From">{{$d->schedule->end}}</td>
                                    <td data-label="Actions">
                                        <div class="btn-group btn-mini-group dropdown-default">
                                            <a class="btn btn-success btn-sm dropdown-toggle btn-animated from-top fa fa-caret-down" data-toggle="dropdown" href="#" aria-expanded="false"><span><i class="fa fa-bars"></i></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" data-toggle="modal" data-target=".modal_edit_shift_plan_{{$d->id}}" class="text-success" title="{{language_data('Edit')}}"><i class="fa fa-edit"></i></a>
                                                </li>
                                                <li class="text-center">
                                                    <form method="POST" action="{{route('shiftin-plan.destroy',$d->id)}}" style="display:inline-block; text-align:center;">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger btn-xs" title="{{language_data('Delete')}}"><i class="fa fa-trash"></i></button>
                                                    </form> 
                                                </li>
                                            </ul>
                                        </div>
                                        @include('admin.schedule_and_shift.modal.edit-shift-plan')
                                    </td>
                                </tr>
                                @endif

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


            /*For Employee Loading*/
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
