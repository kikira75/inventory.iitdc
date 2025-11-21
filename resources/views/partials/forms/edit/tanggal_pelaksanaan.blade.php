<!-- Purchase Date -->
<div class="form-group {{ $errors->has('tanggal_pelaksanaan') ? ' has-error' : '' }}">
    {{ Form::label('tanggal_pelaksanaan', trans('Tanggal Pelaksanaan'), array('class' =>'col-md-3 control-label')) }}
    <div class="col-md-8">
        <div class="input-group date col-md-7" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-end-date="0d" data-date-clear-btn="true">
            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan', date('Y-m-d')) }}">
            <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
        </div>
        {!! $errors->first('tanggal_pelaksanaan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>