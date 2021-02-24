@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
@endsection

@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('Manage')}} {{language_data('Schedule')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            @include('notification.notify')
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <form class="form-control" role="form" action="{{route('schedule.index')}}" method="post">
                                <div class="panel-heading text-center">
                                    <h1 class="panel-title"> {{language_data('Add')}} {{language_data('Schedule')}}</h1>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="el2">{{language_data('Schedule Name')}}</label>
                                            <input type="text" class="form-control" required="" name="name" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="el2">{{language_data('Effective From')}}</label>
                                            <input type="text" id="date_from" class="form-control datePicker" required="" name="start" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="el2">{{language_data('Effective To')}}</label>
                                            <input type="text" id="date_to" class="form-control datePicker" required="" name="end" value="">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="schedule">
                                    <div class="row">
                                        <div class="form-group col-sm-4" id="shifList">
                                            <label for="el3">{{language_data('Shift/Holiday')}}</label>
                                            <select class="form-control" required name="shift[]">
                                                    <option value="">{{language_data('Select Shift/Holiday')}}</option>
                                                @foreach($shifts as $d)
                                                    <option value="{{$d->id}}">{{$d->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-3" id="days_cont">
                                            <label>{{language_data('Days Continued')}}</label>
                                            <input type="number" class="form-control" required name="days[]" max="7" value="">
                                        </div>
                                        <div class="form-group col-sm-3" id="seq">
                                            <label>{{language_data('Sequence')}}</label>
                                            <input type="number" class="form-control" required name="sequence[]" value="">
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <label>{{language_data('Add more')}}</label>
                                            <button class="form-control btn btn-lite addMore" type="button"> <i class="fa fa-plus text-dark plusIcon actionIcon"></i> </button>
                                        </div>
                                    </div>
                                </div>
                                

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {{--<input type="hidden" value="_method" name=""> --}}
                                <button type="submit" class="btn btn-success btn-sm text-center"><i class="fa fa-edit"></i> {{language_data('Add Schedule')}} </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('All Schedules')}}</h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 5%;">{{language_data('SL')}}#</th>
                                    <th style="width: 10%;">{{language_data('Name')}}</th>
                                    <th style="width: 10%;">{{language_data('Start at')}}</th>
                                    <th style="width: 10%;">{{language_data('End at')}}</th>
                                    <th style="width: 45%;">{{language_data('Shifting Plan')}}</th>
                                    <th style="width: 20%;">{{language_data('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($schedules as $d)
                                <tr>
                                    <td data-label="SL">{{$d->id}}</td>
                                    <td data-label="Name"><p>{{$d->name}}</p></td>
                                    <td data-label="Start"><p>{{$d->start}}</p></td>
                                    <td data-label="End"><p>{{$d->end}}</p></td>
                                    <td data-label="ShiftingPlan"><p>

                                        @foreach($d->shiftingplan as $plan)
                                            
                                            {{$plan->shift->name}}, Days->  {{$plan->days}},  Sequence-> {{$plan->sequence}}<br>
                                            
                                        @endforeach
                                        </p>
                                    </td>
                                    <td>
                                        <a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target=".modal_edit_schdedule_{{$d->id}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
                                        @include('admin.schedule_and_shift.modal.edit-schedule')
                                        <form method="POST" action="{{route('schedule.destroy',$d->id)}}" style="display:inline-block;">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> {{language_data('Delete')}}</button>
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
        <div class="fieldgroup" style="display:none;">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label>{{language_data('Shift/Holiday')}}</label>
                    <select class="form-control" data-live-search="false" required name="shift[]">
                            <option value="">{{language_data('Select Shift/Holiday')}}</option>
                        @foreach($shifts as $d)
                            <option value="{{$d->id}}">{{$d->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-sm-3" >
                    <label>{{language_data('Days Continued')}}</label>
                    <input type="number" class="form-control" required name="days[]" value="">
                </div>
                <div class="form-group col-sm-3">
                    <label>{{language_data('Sequence')}}</label>
                    <input type="number" class="form-control" required name="sequence[]" value="">
                </div>
                <div class="form-group col-sm-2">
                    <label>{{language_data('Remove')}}</label>
                    <button class="form-control btn btn-lite remove" type="button"> <i class="fa fa-minus text-danger minusIcon actionIcon"></i> </button>
                </div>
            </div>
        </div>
    </section>

@endsection

{{--External Style Section--}}
@section('script')
    {!! Html::script("assets/libs/moment/moment.min.js")!!}
    {!! Html::script("assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")!!}
    {!! Html::script("assets/libs/data-table/datatables.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}

    <script>

        $(document).ready(function () {
            $('.data-table').DataTable();
            
            $(".addMore").click(function(){
                var fieldgroup = $('.fieldgroup').html();

                $(".schedule").append(fieldgroup);
            });

            //remove fields group
            $(".schedule").on("click",".remove",function(){ 
                $(this).closest(".row").remove();
            });

            /*Linked Date*/

            $("#date_from").on("dp.change", function (e) {
                $('#date_to').data("DateTimePicker").minDate(e.date);
            });

            $("#date_to").on("dp.change", function (e) {
                $('#date_from').data("DateTimePicker").maxDate(e.date);
            });
            /*Linked Date*/

            $(".date_from").on("dp.change", function (e) {
                $('.date_to').data("DateTimePicker").minDate(e.date);
            });

            $(".date_to").on("dp.change", function (e) {
                $('.date_from').data("DateTimePicker").maxDate(e.date);
            });
        });

    </script>
@endsection
