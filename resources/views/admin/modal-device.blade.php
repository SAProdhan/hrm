<div class="modal fade modal_edit_device_{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{language_data('Edit')}} {{language_data('Device')}}</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{route('device.update', $d->id)}}" method="post">

                <div class="modal-body">

                    <div class="form-group">
                        <label>{{language_data('Name')}} :</label>
                        <input type="text" class="form-control" required="" name="name" value="{{$d->name}}">
                    </div>
                
                    <div class="form-group">
                        <label>{{language_data('IP')}}</label>
                        <input type="text" class="form-control" required name="ip" value="{{$d->ip}}" minlength="7" maxlength="15" size="15" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$">
                    </div>

                    <div class="form-group">
                        <label>{{language_data('Port')}}</label>
                        <input type="number" class="form-control" required name="port" value="{{$d->port}}">
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" name="cmd" value="{{$d->id}}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{language_data('Update')}}</button>
                </div>

            </form>
        </div>
    </div>

</div>

