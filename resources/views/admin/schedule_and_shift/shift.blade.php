@extends('master')

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('Shift')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-4">
                    <div class="panel">
                        <div class="panel-body">
                            <form class="" role="form" method="post" action="{{route('shift.store')}}">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> {{language_data('Add Shift')}}</h3>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Shift Name')}}</label>
                                    <span class="help">e.g. "{{language_data('A')}}"</span>
                                    <input type="text" class="form-control" required name="name">
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Start at')}}</label>
                                    <span class="help">e.g. "{{language_data('09:00 AM')}}"</span>
                                    <input type="time" class="form-control" required name="start">
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('End at')}}</label>
                                    <span class="help">e.g. "{{language_data('05:00 PM')}}"</span>
                                    <input type="time" class="form-control" required name="end">
                                </div>

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('All Shifts')}}</h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10%;">{{language_data('SL')}}#</th>
                                    <th style="width: 25%;">{{language_data('Name')}}</th>
                                    <th style="width: 20%;">{{language_data('Start at')}}</th>
                                    <th style="width: 20%;">{{language_data('End at')}}</th>
                                    <th style="width: 25%;">{{language_data('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shifts as $d)
                                    @if($d->id != 0)
                                <tr>
                                    <td data-label="SL">{{$d->id}}</td>
                                    <td data-label="Designation"><p>{{$d->name}}</p></td>
                                    <td data-label="Department"><p>{{$d->start}}</p></td>
                                    <td data-label="Department"><p>{{$d->end}}</p></td>
                                    <td>

                                        <a class="btn btn-success btn-xs" href="#" data-toggle="modal" data-target=".modal_edit_designation_{{$d->id}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
                                        @include('admin.schedule_and_shift.modal.edit-shift')
                                        <form method="POST" action="{{route('shift.destroy',$d->id)}}" style="display:inline-block;">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> {{language_data('Delete')}}</button>
                                        </form>
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
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}
    {!! Html::script("assets/libs/data-table/datatables.min.js")!!}
    {!! Html::script("assets/js/bootbox.min.js")!!}
    <script>
        $(document).ready(function(){
            $('.data-table').DataTable();
        });
    </script>
@endsection
