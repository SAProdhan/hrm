@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('System Settings')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab"><i class="fa fa-cog"></i> {{language_data('General')}}</a></li>
                        <li role="presentation"><a href="#officeTime" aria-controls="officeTime" role="tab"
                                                   data-toggle="tab"><i
                                        class="fa fa-clock-o"></i> {{language_data('Office Time')}}</a></li>
                        <li role="presentation"><a href="#expense" aria-controls="expense" role="tab" data-toggle="tab"><i
                                        class="fa fa-bar-chart"></i> {{language_data('Expense')}}</a></li>
                        <li role="presentation"><a href="#leave" aria-controls="leave" role="tab" data-toggle="tab"><i
                                        class="fa fa-bed"></i> {{language_data('Leave')}}</a></li>
                        <li role="presentation"><a href="#device" aria-controls="device" role="tab" data-toggle="tab"><i
                                        class="fa fa-bed"></i> {{language_data('Devices')}}</a></li>
                        <li role="presentation"><a href="#award" aria-controls="award" role="tab" data-toggle="tab"><i
                                        class="fa fa-trophy"></i> {{language_data('Award')}}</a></li>
                        <li role="presentation"><a href="#job" aria-controls="job" role="tab" data-toggle="tab"><i
                                        class="fa fa-briefcase"></i> {{language_data('Job')}}</a></li>
                    </ul>

                    <div class="tab-content panel p-20">

                        {{--General tab--}}
                        <div role="tabpanel" class="tab-pane active" id="general">
                            <div class="row">
                                <div class="col-md-7">
                                    <form class="" role="form" action="{{url('settings/post-general-setting')}}" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>{{language_data('Application Name')}}</label>
                                            <input type="text" class="form-control" required name="app_name"
                                                   value="{{app_config('AppName')}}">
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('Application Title')}}</label>
                                            <input type="text" class="form-control" name="app_title" required=""
                                                   value="{{app_config('AppTitle')}}">
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('Address')}}</label>
                                            <textarea class="form-control textarea-wysihtml5"
                                                      name="address">{{app_config('Address')}}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('System Email')}}</label>
                                            <span class="help">{{language_data('Remember: All Email Going to the Receiver from this Email')}}</span>
                                            <input type="email" class="form-control" required name="email"
                                                   value="{{app_config('Email')}}">
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('Footer Text')}}</label>
                                            <input type="text" class="form-control" required name="footer"
                                                   value="{{app_config('FooterTxt')}}">
                                        </div>


                                        <div class="form-group">
                                            <label>{{language_data('Application Logo')}}</label>
                                            <div class="input-group input-group-file">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                {{language_data('Browse')}} <input type="file" class="form-control" name="app_logo">
                                            </span>
                                        </span>
                                                <input type="text" class="form-control" readonly="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('Application Favicon')}}</label>
                                            <div class="input-group input-group-file">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                {{language_data('Browse')}} <input type="file" class="form-control" name="app_fav">
                                            </span>
                                        </span>
                                                <input type="text" class="form-control" readonly="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('Email Gateway')}}</label>
                                            <select class="selectpicker form-control gateway" name="email_gateway">
                                                <option value="default" @if(app_config('Gateway')=='default')
                                                        selected @endif>Server Default
                                                </option>
                                                <option value="smtp" @if(app_config('Gateway')=='smtp') selected @endif>
                                                    SMTP
                                                </option>
                                            </select>
                                        </div>

                                        <div class="show-smtp">

                                            <div class="form-group">
                                                <label for="fname">{{language_data('SMTP Host Name')}}</label>
                                                <input type="text" class="form-control" required="" name="host_name"
                                                       value="{{app_config('SMTPHostName')}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="fname">{{language_data('SMTP User Name')}}</label>
                                                <input type="text" class="form-control" required="" name="user_name"
                                                       value="{{app_config('SMTPUserName')}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="fname">{{language_data('SMTP Password')}}</label>
                                                <input type="text" class="form-control" required="" name="password"
                                                       value="{{app_config('SMTPPassword')}}">
                                            </div>


                                            <div class="form-group">
                                                <label for="fname">{{language_data('SMTP Port')}}</label>
                                                <input type="text" class="form-control" required="" name="port"
                                                       value="{{app_config('SMTPPort')}}">
                                            </div>


                                            <div class="form-group">
                                                <label for="Default Gateway">{{language_data('SMTP Secure')}}</label>
                                                <select name="secure" class="selectpicker form-control">
                                                    <option value="tls" @if(app_config('SMTPSecure')=='tls')
                                                            selected @endif>TLS
                                                    </option>
                                                    <option value="ssl"
                                                            @if(app_config('SMTPSecure')=='ssl')selected @endif>
                                                        SSL
                                                    </option>
                                                </select>
                                            </div>


                                        </div>

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> {{language_data('Update')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{--Office Time Tab--}}
                        <div role="tabpanel" class="tab-pane" id="officeTime">
                            <div class="row">
                                <div class="col-md-10">
                                    <form class="" role="form" action="{{url('settings/post-office-time')}}" method="post">
                                        <div class="row">
                                            <div class="form-group col-md-7">
                                                <label for="officetime">{{language_data('Office In Time')}}</label>
                                                <input type='text' class="form-control timePicker" name="office_in_time" value="{{app_config('OfficeInTime')}}"/>
                                            </div>
                                            <div class="form-group col-md-5">
                                                <label for="officetime">{{language_data('Rest In Time(munites)')}}</label>
                                                <input type='number' class="form-control" name="rest_in_time" value="{{app_config('RestInTime')}}" min="0" max="59"/>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-7">
                                                <label for="officetime">{{language_data('Office Out Time')}}</label>
                                                <input type='text' class="form-control timePicker" name="office_out_time" value="{{app_config('OfficeOutTime')}}"/>
                                            </div>
                                            <div class="form-group col-md-5">
                                                <label for="officetime">{{language_data('Rest Out Time(munites)')}}</label>
                                                <input type='number' class="form-control" name="rest_out_time" value="{{app_config('RestOutTime')}}" min="0" max="59"/>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-7">
                                                <label for="officetime">{{language_data('Weekly Holiday')}}</label>
                                                <!-- <input type='text' class="form-control timePicker" name="WeeklyHoliday" value="{{json_decode(app_config('OfficeOutTime'))}}"/> -->
                                                <select class="form-control selectpicker" multiple data-live-search="true" name="WeeklyHoliday[]">
                                                    <option value="0" {{in_array('0', unserialize(app_config('WeeklyHoliday')))? 'selected': ''}}>Sunday</option>
                                                    <option value="1" {{in_array('1', unserialize(app_config('WeeklyHoliday')))? 'selected': ''}}>Monday</option>
                                                    <option value="2" {{in_array('2', unserialize(app_config('WeeklyHoliday')))? 'selected': ''}}>Tuesday</option>
                                                    <option value="3" {{in_array('3', unserialize(app_config('WeeklyHoliday')))? 'selected': ''}}>Wednesday</option>
                                                    <option value="4" {{in_array('4', unserialize(app_config('WeeklyHoliday')))? 'selected': ''}}>Thursday</option>
                                                    <option value="5" {{in_array('5', unserialize(app_config('WeeklyHoliday')))? 'selected': ''}}>Friday</option>
                                                    <option value="6" {{in_array('6', unserialize(app_config('WeeklyHoliday')))? 'selected': ''}}>Saturday</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-5">
                                                <label for="officetime">{{language_data('Maximum over time(Hours)')}}</label>
                                                <input type='number' class="form-control" name="MaxOverTime" value="{{app_config('MaxOverTime')}}" min="0" max="12"/>
                                            </div>
                                        </div>

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> {{language_data('Update')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{--Expense Tab--}}
                        <div role="tabpanel" class="tab-pane" id="expense">
                            <div class="row">
                                <div class="col-lg-4">
                                    <form class="" role="form" method="post"
                                          action="{{url('settings/post-expense-title')}}">
                                        <h3 class="panel-title"> {{language_data('Add New Expense Title')}}</h3>

                                        <div class="form-group">
                                            <label>{{language_data('Expense Title')}}</label>
                                            <span class="help">e.g. "{{language_data('Employee Salary')}}"</span>
                                            <input type="text" class="form-control" required name="expense">
                                        </div>


                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                    </form>
                                </div>
                                <div class="col-lg-8">
                                    <h3 class="panel-title">{{language_data('Expense Title List')}}</h3>
                                    <table class="table data-table table-hover table-ultra-responsive">
                                        <thead>
                                        <tr>
                                            <th style="width: 10%;">{{language_data('SL')}}#</th>
                                            <th style="width: 65%;">{{language_data('Expense Title')}}</th>
                                            <th style="width: 25%;">{{language_data('Actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($expense_title as $d)
                                            <tr>
                                                <td data-label="SL">{{$d->id}}</td>
                                                <td data-label="Expense"><p>{{$d->expense}}</p></td>
                                                <td>

                                                    <a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target=".modal_edit_expense_type_{{$d->id}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
                                                    @include('admin.modal-expense-type')

                                                    <a href="#" class="btn btn-danger btn-xs deleteExpense" id="{{$d->id}}"><i class="fa fa-trash"></i> {{language_data('Delete')}}</a>
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{--Leave Tab--}}
                        <div role="tabpanel" class="tab-pane" id="leave">
                            <div class="row">
                                <div class="col-lg-4">
                                    <form class="" role="form" method="post"
                                          action="{{url('settings/post-leave-type')}}">
                                        <h3 class="panel-title"> {{language_data('Leave Type')}}</h3>

                                        <div class="form-group">
                                            <label>{{language_data('Leave Title')}}</label>
                                            <span class="help">e.g. "{{language_data('Sick Leave')}}"</span>
                                            <input type="text" class="form-control" required name="leave">
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('Leave Quota')}}</label>
                                            <span class="help">e.g. "12" Days/Year</span>
                                            <input type="number" class="form-control" required name="leave_quota">
                                        </div>


                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                    </form>
                                </div>

                                <div class="col-lg-8">
                                    <h3 class="panel-title">{{language_data('Leave Title List')}}</h3>
                                    <table class="table data-table table-hover table-ultra-responsive">
                                        <thead>
                                        <tr>
                                            <th style="width: 10%;">{{language_data('SL')}}#</th>
                                            <th style="width: 40%;">{{language_data('Leave Type')}}</th>
                                            <th style="width: 20%;">{{language_data('Leave Quota')}}</th>
                                            <th style="width: 25%;">{{language_data('Actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($leave_type as $d)
                                            <tr>
                                                <td data-label="SL">{{$d->id}}</td>
                                                <td data-label="Leave"><p>{{$d->leave}}</p></td>
                                                <td data-label="LeaveQuota"><p>{{$d->leave_quota}}</p></td>
                                                <td>

                                                    <a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target=".modal_edit_leave_type_{{$d->id}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
                                                    @include('admin.modal-leave-type')


                                                    <a href="#" class="btn btn-danger btn-xs deleteLeave" id="{{$d->id}}"><i class="fa fa-trash"></i> {{language_data('Delete')}}</a>
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        
                        {{--Device Tab--}}
                        <div role="tabpanel" class="tab-pane" id="device">
                            <div class="row">
                                <div class="col-lg-4">
                                    <form class="" role="form" method="post"
                                          action="{{route('device.store')}}">
                                        <h3 class="panel-title"> {{language_data('Add Device')}}</h3>

                                        <div class="form-group">
                                            <label>{{language_data('Name')}}</label>
                                            <span class="help">e.g. "{{language_data('Device1')}}"</span>
                                            <input type="text" class="form-control" required name="name">
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('IP')}}</label>
                                            <span class="help">e.g. 192.168.0.100</span>
                                            <input type="text" class="form-control" required name="ip" minlength="7" maxlength="15" size="15" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$">
                                        </div>
                                        <div class="form-group">
                                            <label>{{language_data('Port')}}</label>
                                            <span class="help">e.g. 4536</span>
                                            <input type="number" class="form-control" required name="port">
                                        </div>


                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                    </form>
                                </div>

                                <div class="col-lg-8">
                                    <h3 class="panel-title">{{language_data('Devises List')}}</h3>
                                    <table class="table data-table table-hover table-ultra-responsive">
                                        <thead>
                                        <tr>
                                            <th style="width: 10%;">{{language_data('SL')}}#</th>
                                            <th style="width: 20%;">{{language_data('Name')}}</th>
                                            <th style="width: 20%;">{{language_data('Ip')}}</th>
                                            <th style="width: 15%;">{{language_data('Port')}}</th>
                                            <th style="width: 25%;">{{language_data('Actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($devices)==0)
                                            <tr><td colspan=5>
                                            <span><center>Sorry no data found!</center></span>
                                            </td></tr>
                                        @else
                                            @foreach($devices as $d)
                                                <tr>
                                                    <td data-label="SL">{{$d->id}}</td>
                                                    <td data-label="DeviceName"><p>{{$d->name}}</p></td>
                                                    <td data-label="DeviceIp"><p>{{$d->ip}}</p></td>
                                                    <td data-label="DevicePort"><p>{{$d->port}}</p></td>
                                                    <td>

                                                        <a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target=".modal_edit_device_{{$d->id}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
                                                        @include('admin.modal-device')
                                                        <a href="#" class="btn btn-danger btn-xs deleteDevice" id="{{$d->id}}"><i class="fa fa-trash"></i> {{language_data('Delete')}}</a>
                                                    </td>
                                                </tr>

                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        {{--Award Tab--}}
                        <div role="tabpanel" class="tab-pane" id="award">
                            <div class="row">

                                <div class="col-lg-4">
                                    <form class="" role="form" method="post"
                                          action="{{url('settings/post-award-name')}}">
                                        <h3 class="panel-title"> {{language_data('Award Name')}}</h3>

                                        <div class="form-group">
                                            <label>{{language_data('Award Name')}}</label>
                                            <span class="help">e.g. "{{language_data('Best Employee')}}"</span>
                                            <input type="text" class="form-control" required name="award">
                                        </div>


                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                    </form>
                                </div>

                                <div class="col-lg-8">
                                    <h3 class="panel-title">{{language_data('Award Name List')}}</h3>
                                    <table class="table data-table table-hover table-ultra-responsive">
                                        <thead>
                                        <tr>
                                            <th style="width: 10%;">{{language_data('SL')}}#</th>
                                            <th style="width: 65%;">{{language_data('Award Name')}}</th>
                                            <th style="width: 25%;">{{language_data('Actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($award as $d)
                                            <tr>
                                                <td data-label="SL">{{$d->id}}</td>
                                                <td data-label="Expense"><p>{{$d->award}}</p></td>
                                                <td>


                                                    <a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target=".modal_edit_award_type_{{$d->id}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
                                                    @include('admin.modal-award-type')


                                                    <a href="#" class="btn btn-danger btn-xs deleteAward" id="{{$d->id}}"><i class="fa fa-trash"></i> {{language_data('Delete')}}</a>
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        {{--Job tab--}}
                        <div role="tabpanel" class="tab-pane" id="job">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form class="" role="form" method="post"
                                          action="{{url('settings/post-job-file-extension')}}">
                                        <h3 class="panel-title"> {{language_data('Job File Extension')}}</h3>

                                        <div class="form-group">
                                            <label>{{language_data('Supported File Extension')}}</label>
                                            <span class="help">e.g. "Doc,PDF" ({{language_data('Remember: File Extension Separated By Comma')}}
                                                )</span>
                                            <input type="text" class="form-control" required name="file_extension"
                                                   value="{{app_config('JobFileExtension')}}">
                                        </div>


                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> {{language_data('Save')}} </button>
                                    </form>
                                </div>

                            </div>
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
    {!! Html::script("assets/js/bootbox.min.js")!!}
    <script>
        $(document).ready(function () {
            /*For Delete Expense*/
            $(".deleteExpense").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/settings/delete-expense/" + id;
                    }
                });
            });

            /*For Delete Leave*/
            $(".deleteLeave").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/settings/delete-leave/" + id;
                    }
                });
            });


            /*For Delete Award*/
            $(".deleteAward").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/settings/delete-award/" + id;
                    }
                });
            });




            var EmailGatewaySV = $('.gateway');
            if (EmailGatewaySV.val() == 'default') {
                $('.show-smtp').hide();
            }

            EmailGatewaySV.on('change', function () {
                var value = $(this).val();
                if (value == 'smtp') {
                    $('.show-smtp').show();
                } else {
                    $('.show-smtp').hide();
                }

            });

        });

    </script>

@endsection
