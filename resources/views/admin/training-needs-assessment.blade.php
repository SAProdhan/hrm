@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
    {!! Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('Training Needs Assessment')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('Training Needs Assessment')}}</h3>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#add-new-training"><i class="fa fa-plus"></i> {{language_data('Add')}} {{language_data('Training Needs Assessment')}}</button>
                            <br>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10%;">{{language_data('Department')}}</th>
                                    <th style="width: 15%;">{{language_data('Training Type')}}</th>
                                    <th style="width: 20%;">{{language_data('Training')}} {{language_data('Subject')}}</th>
                                    <th style="width: 20%;">{{language_data('Title')}}</th>
                                    <th style="width: 10%;">{{language_data('Status')}}</th>
                                    <th style="width: 25%;" class="text-right">{{language_data('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tnassessment as $et)
                                    <tr>
                                        <td data-label="Department"><p>{{$et->department_name->department}}</p></td>
                                        <td data-label="Training Type"><p>{{$et->training_type}}</p></td>
                                        <td data-label="Training Subject"><p>{{$et->training_subject}}</p></td>
                                        <td data-label="Title"><p>{{$et->title}}</p></td>
                                        <td data-label="Status">
                                            @if($et->status=='pending')
                                                <span class="label label-warning">{{language_data('Pending')}}</span>
                                            @elseif($et->status=='approved')
                                                <span class="label label-success">{{language_data('Approved')}}</span>
                                            @elseif($et->status=='completed')
                                                <span class="label label-info">{{language_data('Completed')}}</span>
                                            @else
                                            <span class="label label-danger">{{language_data('Rejected')}}</span>
                                            @endif
                                        </td>
                                        <td data-label="Actions" class="text-right">
                                            <a class="btn btn-success btn-xs" href="{{url('training/view-training-needs-assessment/'.$et->id)}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
                                            <a href="#" class="btn btn-danger btn-xs cdelete" id="{{$et->id}}"><i class="fa fa-trash"></i> {{language_data('Delete')}}</a>
                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


            <!-- Modal -->
            <div class="modal fade" id="add-new-training" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{language_data('Add')}} {{language_data('Training Needs Assessment')}}</h4>
                        </div>
                        <form class="form-some-up" role="form" method="post" action="{{url('training/post-new-training-needs-assessment')}}">
                            <div class="modal-body">


                                <div class="form-group">
                                    <label>{{language_data('Department')}}</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="department">
                                        @foreach($department as $e)
                                            <option value="{{$e->id}}">{{$e->department}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>{{language_data('Training Type')}}</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="training_type">
                                        <option value="Online Training">{{language_data('Online Training')}}</option>
                                        <option value="Seminar">{{language_data('Seminar')}}</option>
                                        <option value="Lecture">{{language_data('Lecture')}}</option>
                                        <option value="Workshop">{{language_data('Workshop')}}</option>
                                        <option value="Hands On Training">{{language_data('Hands On Training')}}</option>
                                        <option value="Webinar">{{language_data('Webinar')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Training')}} {{language_data('Subject')}}</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="training_subject">
                                        <option value="HR Training">{{language_data('HR Training')}}</option>
                                        <option value="Employees Development">{{language_data('Employees Development')}}</option>
                                        <option value="IT Training">{{language_data('IT Training')}}</option>
                                        <option value="Finance Training">{{language_data('Finance Training')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Nature Of Training')}}</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="training_nature">
                                        <option value="Internal">{{language_data('Internal')}}</option>
                                        <option value="External">{{language_data('External')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Training')}} {{language_data('Title')}}</label>
                                    <input type="text" class="form-control" name="training_title" required="">
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Training')}} {{language_data('Employee')}}</label>
                                    <select class="form-control selectpicker" multiple data-live-search="true" name="employee[]">
                                        @foreach($employee as $e)
                                            <option value="{{$e->id}}">{{$e->fname}} {{$e->lname}} ({{$e->employee_code}})</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>{{language_data('Training')}} {{language_data('Reason')}}</label>
                                    <textarea class="textarea-wysihtml5 form-control" name="training_reason"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Preferred')}} {{language_data('Trainer')}}</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="trainer">
                                        @foreach($trainers as $t)
                                            <option value="{{$t->id}}">{{$t->first_name}} {{$t->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Preferred')}}  {{language_data('Training Location')}}</label>
                                    <input type="text" class="form-control" name="training_location">
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Preferred')}}  {{language_data('Start Date')}}</label>
                                    <input type="text" class="form-control datePicker" name="training_from">
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Preferred')}} {{language_data('End Date')}}</label>
                                    <input type="text" class="form-control datePicker" name="training_to">
                                </div>


                                <div class="form-group">
                                    <label>{{language_data('Preferred')}}  {{language_data('Training Cost')}}</label>
                                    <input type="text" class="form-control" name="training_cost">
                                </div>


                                <div class="form-group">
                                    <label>{{language_data('Preferred')}}  {{language_data('Travel Cost')}}</label>
                                    <input type="text" class="form-control" name="travel_cost">
                                </div>


                                <div class="form-group">
                                    <label>{{language_data('Status')}}</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="status">
                                        <option value="pending">{{language_data('Pending')}}</option>
                                        <option value="approved">{{language_data('Approved')}}</option>
                                        <option value="rejected">{{language_data('Rejected')}}</option>
                                        <option value="completed">{{language_data('Completed')}}</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>{{language_data('Training')}} {{language_data('Description')}}</label>
                                    <textarea class="textarea-wysihtml5 form-control" name="description"></textarea>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                                <button type="submit" class="btn btn-primary">{{language_data('Add')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection

{{--External Style Section--}}
@section('script')
    {!! Html::script("assets/libs/moment/moment.min.js")!!}
    {!! Html::script("assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")!!}
    {!! Html::script("assets/libs/wysihtml5x/wysihtml5x-toolbar.min.js")!!}
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}
    {!! Html::script("assets/libs/data-table/datatables.min.js")!!}
    {!! Html::script("assets/js/bootbox.min.js")!!}

    <script>
        $(document).ready(function () {
            /*For DataTable*/
            $('.data-table').DataTable();

            /*For Delete Job Info*/
            $(".cdelete").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/training/delete-training-needs-assessment/" + id;
                    }
                });
            });


        });
    </script>
@endsection
