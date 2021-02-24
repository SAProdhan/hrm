<div class="modal fade modal_edit_designation_{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{language_data('Edit')}} {{language_data('Schedule')}}</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{route('shift.update',$d->id)}}" method="post">

                <div class="modal-body">

                    <div class="form-group">
                        <label>{{language_data('Shift Name')}}</label>
                        <span class="help">e.g. "{{language_data('A')}}"</span>
                        <input type="text" class="form-control" required name="name" value="{{$d->name}}">
                    </div>

                    <div class="form-group">
                        <label>{{language_data('Start at')}}</label>
                        <span class="help">e.g. "{{language_data('09:00 AM')}}"</span>
                        <input type="time" class="form-control" required name="start" value="{{$d->start}}">
                    </div>

                    <div class="form-group">
                        <label>{{language_data('End at')}}</label>
                        <span class="help">e.g. "{{language_data('05:00 PM')}}"</span>
                        <input type="time" class="form-control" required name="end" value="{{$d->end}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="cmd" value="{{$d->id}}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{language_data('Update')}}</button>
                </div>

            </form>
        </div>
    </div>

</div>

