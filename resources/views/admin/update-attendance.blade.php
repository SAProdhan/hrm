@extends('master')


{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('Update Attendance')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            @include('notification.notify')
            <div class="row">

                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-body">
                            <form class="" role="form" action="{{url('attendance/post-update-attendance')}}" method="post">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> {{language_data('Update Attendance')}}</h3>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Employee')}}</label>
                                    <select class="selectpicker form-control" multiple data-live-search="true" name="employee[]">
                                        @foreach($employee as $d)
                                            <option value="{{$d->id}}">{{$d->fname}} {{$d->lname}} ({{$d->employee_code}})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="el2">{{language_data('Date From')}}</label>
                                    <input type="text" id="date_from" class="form-control datePicker" required="" name="date_from" >
                                </div>
                                <div class="form-group">
                                    <label for="el2">{{language_data('Date To')}}</label>
                                    <input type="text" id="date_to" class="form-control datePicker" required="" name="date_to">
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Clock In')}}</label>
                                    <input type="text" class="form-control timePicker" required name="clock_in" value="{{app_config('OfficeInTime')}}">
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Clock Out')}}</label>
                                    <input type="text" class="form-control timePicker" required name="clock_out" value="{{app_config('OfficeOutTime')}}">
                                </div>

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> {{language_data('Update')}} </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-body">
                            <form class="" role="form" action="{{url('attendance/post-update-attendance-device')}}" method="post">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> {{language_data('Update Attendance From Device')}}</h3>
                                </div>
                                <div class="form-group">
                                    <label>{{language_data('Select Device')}}</label>
                                    <select class="selectpicker form-control" data-live-search="true" name="device">
                                        @foreach($devices as $d)
                                            <option value="{{$d->id}}">{{$d->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="el2">{{language_data('Date From')}}</label>
                                    <input type="text" id="date_from" class="form-control datePicker" required="" name="date_from" >
                                </div>
                                <div class="form-group">
                                    <label for="el2">{{language_data('Date To')}}</label>
                                    <input type="text" id="date_to" class="form-control datePicker" required="" name="date_to">
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> {{language_data('Update')}} </button>
                                <!-- <a href="{{route('device.create')}}" class="btn btn-success btn-sm pull-left"><i class="fa fa-save"></i> {{language_data('Get log')}} </a> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

{{--External Style Section--}}
@section('script')
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/libs/moment/moment.min.js")!!}
    {!! Html::script("assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}
    <script>
        $(document).ready(function () {
            /*Linked Date*/

            $("#date_from").on("dp.change", function (e) {
                $('#date_to').data("DateTimePicker").minDate(e.date);
            });

            $("#date_to").on("dp.change", function (e) {
                $('#date_from').data("DateTimePicker").maxDate(e.date);
            });

        });
    </script>
@endsection
