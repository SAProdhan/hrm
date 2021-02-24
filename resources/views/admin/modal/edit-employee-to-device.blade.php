<div class="modal fade modal_edit_designation_{{$d->employee_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{language_data('Edit')}} {{language_data('Device for ')}} <strong>{{$d->employee->fname}} {{$d->employee->lname}}</strong></h4>
            </div>
            <form class="form-some-up form-block" role="form" action="" method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <label>{{language_data('Device')}}</label>
                        <!-- <input type="time" class="form-control" required name="start" value="{{$d->start}}"> -->
                        <select class="selectpicker form-control device" data-live-search="true" name="device">
                            <option value="">{{language_data('Select Device')}}</option>
                            @foreach($device as $data)
                            <option value="{{$data->id}}" {{$data->id == $d->device->id? 'selected': ''}}> {{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="uid">{{language_data('User from device')}}</label>
                        <select class="uid selectpicker form-control" data-live-search="true" disabled name="uid">
                        
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
