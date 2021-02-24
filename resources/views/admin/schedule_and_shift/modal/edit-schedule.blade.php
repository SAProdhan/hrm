<div class="modal fade modal_edit_schdedule_{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{language_data('Edit')}} {{language_data('Schedule')}}</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{route('schedule.update',$d->id)}}" method="post">

                <div class="modal-body">

                    <div class="form-group">
                        <label>{{language_data('Schedule Name')}} :</label>
                        <input type="text" class="form-control" required="" name="name" value="{{$d->name}}">
                    </div>


                    <div class="form-group">
                        <label for="el2">{{language_data('Effective From')}}</label>
                        <input type="text" class="form-control datePicker date_from" required="" name="start" value="{{$d->start}}">
                    </div>

                    <div class="form-group">
                        <label for="el2">{{language_data('Effective To')}}</label>
                        <input type="text" class="form-control datePicker date_to" required="" name="end" value="{{$d->end}}">
                    </div>
                    <div class="schedule">
                    @foreach($d->shiftingplan as $i=>$plan)
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label for="el3">{{language_data('Shift/Holiday')}}</label>
                                <select class="form-control" required name="shift[]">
                                        <option value="">{{language_data('Select Shift/Holiday')}}</option>
                                    @foreach($shifts as $s)
                                        <option value="{{$s->id}}" {{$s->id==$plan->shift->id? 'selected': ''}}>{{$s->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-3">
                                <label>{{language_data('Days Continued')}}</label>
                                <input type="number" class="form-control" required name="days[]" max="7" value="{{$plan->days}}">
                            </div>
                            <div class="form-group col-sm-3">
                                <label>{{language_data('Sequence')}}</label>
                                <input type="number" class="form-control" required name="sequence[]" value="{{$plan->sequence}}">
                            </div>
                            @if($i==0)
                            <div class="form-group col-sm-2">
                                <label>{{language_data('Add more')}}</label>
                                <button class="form-control btn btn-lite addMore" type="button"> <i class="fa fa-plus text-dark plusIcon actionIcon"></i> </button>
                            </div>
                            @else
                            <div class="form-group col-sm-2">
                                <label>{{language_data('Remove')}}</label>
                                <button class="form-control btn btn-lite remove" type="button"> <i class="fa fa-minus text-danger minusIcon actionIcon"></i> </button>
                            </div>
                            @endif
                        </div>
                    @endforeach
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="_method" value="PUT">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{language_data('Update')}}</button>
                </div>

            </form>
        </div>
    </div>

</div>

