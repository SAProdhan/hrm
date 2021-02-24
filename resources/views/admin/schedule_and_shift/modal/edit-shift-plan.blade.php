<div class="modal fade modal_edit_shift_plan_{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{language_data('Edit')}} {{language_data('Schedule For')}} <strong>{{$d->fname}} {{$d->lname}}</strong></h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{route('shiftin-plan.update',$d->id)}}" method="post">

                <div class="modal-body">

                    <div class="form-group">
                        <label for="el3">{{language_data('Schedule')}}</label>
                        <select class="selectpicker form-control" data-live-search="true" name="schedule">
                            @foreach($schedules as $s)
                                <option value="{{$s->id}}" {{$s->id==$d->schedule_id? 'selected':''}}>{{$s->name}} ({{$s->start}} to {{$s->end}})</option>
                            @endforeach
                        </select>
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

