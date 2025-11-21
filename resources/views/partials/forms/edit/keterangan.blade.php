<!-- Notes -->
<div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
    <label for="keterangan" class="col-md-3 control-label">{{ trans('Keterangan') }}</label>
    <div class="col-md-7 col-sm-12">
        <textarea class="col-md-6 form-control" id="keterangan" aria-label="keterangan" name="keterangan" style="min-width:100%;">{{ old('keterangan', $item->keterangan) }}</textarea>
        {!! $errors->first('keterangan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
