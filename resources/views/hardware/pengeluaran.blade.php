@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/hardware/general.checkout') }}
@parent
@stop

{{-- Page content --}}
@section('content')

<style>
    .input-group {
        padding-left: 0px !important;
    }
</style>

<div class="row">
    <!-- left column -->
    <div class="col-md-7">
        <div class="box box-default">
            <form class="form-horizontal" method="post" action="" autocomplete="off">
                <div class="box-header with-border">
                    <h2 class="box-title"> {{ trans('admin/hardware/form.tag') }} {{ $item->asset_tag }}</h2>
                </div>
                <div class="box-body">
                    {{csrf_field()}}
                    @if ($item->company && $item->company->name)
                    <div class="form-group">
                        {{ Form::label('model', trans('general.company'), array('class' => 'col-md-3 control-label')) }}
                        <div class="col-md-8">
                            <p class="form-control-static">
                                {{ $item->company->name }}
                            </p>
                        </div>
                    </div>
                    @endif
                    <!-- AssetModel name -->
                    {{-- <div class="form-group">
                        {{ Form::label('model', trans('admin/hardware/form.model'), array('class' => 'col-md-3
                        control-label')) }}
                        <div class="col-md-8">
                            <p class="form-control-static">
                                @if (($item->model) && ($item->model->name))
                                {{ $item->model->name }}
                                @else
                                <span class="text-danger text-bold">
                                    <i class="fas fa-exclamation-triangle"></i>{{
                                    trans('admin/hardware/general.model_invalid')}}
                                    <a href="{{ route('hardware.edit', $item->id) }}"></a> {{
                                    trans('admin/hardware/general.model_invalid_fix')}}</span>
                                @endif
                            </p>
                        </div>
                    </div> --}}

                    <div class="form-group {{ $errors->has('kode_barang') ? ' has-error' : '' }}">
                        <label for="kode_barang" class="col-md-3 control-label">Kode Barang</label>
                        <div class="col-md-7 col-sm-12">
                          <input class="form-control" type="text" name="kode_barang" aria-label="kode_barang" id="kode_barang"
                            value="{{ old('name', $item->asset_tag) }}" {!! (Helper::checkIfRequired($item, 'kode_barang' ))
                            ? ' data-validation="required" required' : '' !!} readonly />
                          {!! $errors->first('kode_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                              aria-hidden="true"></i> :message</span>') !!}
                        </div>
                      </div>
            
                      <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-3 control-label">Nama Barang</label>
                        <div class="col-md-7 col-sm-12">
                          <input class="form-control" type="text" name="name" aria-label="name" id="name"
                            value="{{ old('name', $item->name) }}" {!! (Helper::checkIfRequired($item, 'name' ))
                            ? ' data-validation="required" required' : '' !!} readonly />
                          {!! $errors->first('name', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                              aria-hidden="true"></i> :message</span>') !!}
                        </div>
                      </div>
            
                      <div class="form-group {{ $errors->has('kategori_barang') ? ' has-error' : '' }}">
                        <label for="kategori_barang" class="col-md-3 control-label">Kategori Barang</label>
                        <div class="col-md-7 col-sm-12">
                          <input class="form-control" type="text" name="kategori_barang" aria-label="kategori_barang"
                            id="kategori_barang" value="{{ old('name', $item->kategori_barang) }}" {!!
                            (Helper::checkIfRequired($item, 'kategori_barang' )) ? ' data-validation="required" required' : '' !!} readonly />
                            <input class="form-control" type="hidden" name="nomor_kategori_barang" aria-label="nomor_kategori_barang" id="nomor_kategori_barang" value="{{ old('nomor_kategori_barang', $item->nomor_kategori_barang) }}" {!! (Helper::checkIfRequired($item, 'nomor_kategori_barang' )) ? ' data-validation="required" required' : '' !!} readonly />
                          {!! $errors->first('kategori_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                      </div>
            
                      <div class="form-group {{ $errors->has('jumlah_barang') ? ' has-error' : '' }}">
                        <label for="jumlah_barang" class="col-md-3 control-label">Jumlah Barang Sebelumnya</label>
                        <div class="col-md-7 col-sm-12">
                          <input class="form-control" type="text" name="jumlah_barang" aria-label="jumlah_barang" id="jumlah_barang"
                            value="{{ old('name', $item->jumlah_barang) }}" {!! (Helper::checkIfRequired($item, 'jumlah_barang' ))
                            ? ' data-validation="required" required' : '' !!} readonly />
                          {!! $errors->first('jumlah_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                              aria-hidden="true"></i> :message</span>') !!}
                        </div>
                      </div>
                      
            
                      <div class="form-group {{ $errors->has('satuan_barang') ? ' has-error' : '' }}">
                        <label for="satuan_barang" class="col-md-3 control-label">Satuan Barang</label>
                        <div class="col-md-7 col-sm-12">
                          <input class="form-control" type="text" name="satuan_barang" aria-label="satuan_barang"
                            id="satuan_barang" value="{{ old('satuan_barang', $item->satuan_barang) }}" {!!
                            (Helper::checkIfRequired($item, 'satuan_barang' )) ? ' data-validation="required" required' : ''
                            !!} readonly />
                          {!! $errors->first('satuan_barang', '<span class="alert-msg" aria-hidden="true"><i
                              class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                      </div>

                    <!-- Status -->
                    <div class="form-group {{ $errors->has('status_id') ? 'error' : '' }}">
                        {{ Form::label('status_id', trans('admin/hardware/form.status'), array('class' => 'col-md-3
                        control-label')) }}
                        <div class="col-md-7 required">
                            {{ Form::select('status_id', $statusLabel_list, $item->status_id, array('class'=>'select2',
                            'style'=>'width:100%','', 'aria-label'=>'status_id')) }}
                            {!! $errors->first('status_id', '<span class="alert-msg" aria-hidden="true"><i
                                    class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true',
                    'location_select' => 'true'])

                    @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.user'),
                    'fieldname' => 'assigned_user', 'required'=>'true'])
                    
                    <!-- We have to pass unselect here so that we don't default to the asset that's being checked out. We want that asset to be pre-selected everywhere else. -->
                    @include ('partials.forms.edit.asset-select', ['translated_name' => trans('general.asset'), 'fieldname' => 'assigned_asset', 'unselect' => 'true', 'style' => 'display:none;', 'required'=>'true'])

                    @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'assigned_location', 'style' => 'display:none;', 'required'=>'true'])

                    <div class="form-group {{ $errors->has('kode_dokumen') ? ' has-error' : '' }}">
                        <label for="kode_dokumen" class="col-md-3 control-label">{{ trans('Kode Dokumen Pabean') }}</label>
                        <div class="col-md-7 col-sm-11">
                            {{ Form::select('kode_dokumen', $kodeDokumen , old('kode_dokumen', ''),
                            array('class'=>'select2 kode_dokumen', 'style'=>'width:100%','id'=>'status_select_id', 'aria-label'=>'kode_dokumen', 'data-validation' => "required")) }}
                            {!! $errors->first('kode_dokumen', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('nomor_daftar') ? ' has-error' : '' }}">
                        <label for="nomor_daftar" class="col-md-3 control-label">Nomor Daftar</label>
                        <div class="col-md-7 col-sm-12">
                            <input class="form-control" type="text" name="nomor_daftar" aria-label="nomor_daftar" id="nomor_daftar" {!!
                                (Helper::checkIfRequired($item, 'nomor_daftar' )) ? ' data-validation="required" required' : ''
                                !!} value="{{ old('nomor_daftar', '') }}" />
                            {!! $errors->first('nomor_daftar', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>
                    
                    <div class="form-group {{ $errors->has('tanggal_daftar') ? ' has-error' : '' }}">
                        <label for="tanggal_daftar" class="col-md-3 control-label">{{ trans('Tanggal Daftar') }}</label>
                        <div class="col-md-8">
                            <div class="input-group col-md-7">
                                    <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                                        <input type="text" class="form-control" placeholder="{{ trans('tanggal daftar') }}" name="tanggal_daftar" id="tanggal_daftar" readonly value="{{  old('tanggal_daftar', '') }}" style="background-color:inherit">
                                        <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                {!! $errors->first('tanggal_daftar', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('nomor_pengeluaran') ? ' has-error' : '' }}">
                        <label for="nomor_pengeluaran" class="col-md-3 control-label">Nomor Pengeluaran</label>
                        <div class="col-md-7 col-sm-12">
                            <input class="form-control" type="text" name="nomor_pengeluaran" aria-label="nomor_pengeluaran"
                                id="nomor_pengeluaran" value="{{ old('nomor_pengeluaran', '') }}" {!!
                                (Helper::checkIfRequired($item, 'nomor_pengeluaran' ))
                                ? ' data-validation="required" required' : '' !!} />
                            {!! $errors->first('nomor_pengeluaran', '<span class="alert-msg" aria-hidden="true"><i
                                    class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    <!-- Checkout/Checkin Date -->
                    <div class="form-group {{ $errors->has('checkout_at') ? 'error' : '' }}">
                        {{ Form::label('checkout_at', trans('Tanggal Pengeluaran'), array('class' =>
                        'col-md-3 control-label')) }}
                        <div class="col-md-8">
                            <div class="input-group date col-md-7" data-provide="datepicker"
                                data-date-format="yyyy-mm-dd" data-date-end-date="0d" data-date-clear-btn="true">
                                <input type="text" class="form-control" placeholder="{{ trans('Tanggal Pengeluaran') }}"
                                    name="checkout_at" id="checkout_at" value="{{ old('checkout_at', '') }}">
                                <span class="input-group-addon"><i class="fas fa-calendar"
                                        aria-hidden="true"></i></span>
                            </div>
                            {!! $errors->first('checkout_at', '<span class="alert-msg" aria-hidden="true"><i
                                    class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('nama_pengirim') ? ' has-error' : '' }}">
                        <label for="nama_pengirim" class="col-md-3 control-label">Nama Pengirim</label>
                        <div class="col-md-7 col-sm-12">
                            <input class="form-control" type="text" name="nama_pengirim"
                                aria-label="nama_pengirim" id="nama_pengirim"
                                value="{{ old('nama_pengirim', '') }}" {!!
                                (Helper::checkIfRequired($item, 'nama_pengirim' ))
                                ? ' data-validation="required" required' : '' !!} />
                            {!! $errors->first('nama_pengirim', '<span class="alert-msg" aria-hidden="true"><i
                                    class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    <!-- Expected Checkin Date -->
                    <div class="form-group hidden {{ $errors->has('expected_checkin') ? 'error' : '' }}">
                        {{ Form::label('expected_checkin', trans('admin/hardware/form.expected_checkin'), array('class'
                        => 'col-md-3 control-label')) }}
                        <div class="col-md-8">
                            <div class="input-group date col-md-7" data-provide="datepicker"
                                data-date-format="yyyy-mm-dd" data-date-start-date="0d" data-date-clear-btn="true">
                                <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="expected_checkin" id="expected_checkin" value="{{ old('expected_checkin') }}">
                                <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                            </div>
                            {!! $errors->first('expected_checkin', '<span class="alert-msg" aria-hidden="true"><i
                                    class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    <!-- Note -->
                    {{--  <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                        {{ Form::label('note', trans('admin/hardware/form.notes'), array('class' => 'col-md-3
                        control-label')) }}
                        <div class="col-md-7">
                            <textarea class="col-md-6 form-control" id="note"
                                name="note">{{ old('note', $item->note) }}</textarea>
                            {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i
                                    class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>  --}}

                    <div class="form-group {{ $errors->has('jumlah_barang_peng') ? ' has-error' : '' }}">
                        <label for="jumlah_barang_peng" class="col-md-3 control-label">Jumlah Barang Pengeluaran</label>
                        <div class="col-md-7 col-sm-12">
                            <input class="form-control" type="number" min="1" name="jumlah_barang_peng" aria-label="jumlah_barang_peng" id="jumlah_barang_peng"
                                value="{{ old('jumlah_barang_peng', '') }}" {!! (Helper::checkIfRequired($item, 'jumlah_barang_peng' )) ? ' data-validation="required" required' : '' !!} />
                            {!! $errors->first('jumlah_barang_peng', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('harga_satuan_barang') ? ' has-error' : '' }}">
                        <label for="harga_satuan_barang" class="col-md-3 control-label">Harga Satuan Barang</label>
                        <div class="col-md-7 col-sm-12">
                          <input class="form-control" type="text" name="harga_satuan_barang" aria-label="harga_satuan_barang"
                            id="harga_satuan_barang" value="{{ old('harga_satuan_barang', $item->harga_satuan_barang) }}" {!! (Helper::checkIfRequired($item, 'harga_satuan_barang' )) ? ' data-validation="required" required' : '' !!} readonly/>
                          {!! $errors->first('harga_satuan_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                      </div>
                      
                      <div class="form-group {{ $errors->has('harga_total_barang') ? ' has-error' : '' }}">
                        <label for="harga_total_barang" class="col-md-3 control-label">Harga Total Barang</label>
                        <div class="col-md-7 col-sm-12">
                          <input class="form-control" type="text" name="harga_total_barang" aria-label="harga_total_barang"
                            id="harga_total_barang" value="{{ old('harga_total_barang', $item->harga_total_barang) }}" {!!
                            (Helper::checkIfRequired($item, 'harga_total_barang' )) ? ' data-validation="required" required' : ''
                            !!} readonly />
                          {!! $errors->first('harga_total_barang', '<span class="alert-msg" aria-hidden="true"><i
                              class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                      </div>

                    {{-- terbaru --}}

                    <div class="form-group {{ $errors->has('kode_dokumen') ? ' has-error' : '' }}">
                        <label for="kode_dokumen" class="col-md-3 control-label">{{ trans('Kode Dokumen Pabean') }}333</label>
                        <div class="col-md-7 col-sm-11">
                            {{ Form::select('kode_dokumen', $kodeDokumen , old('kode_dokumen', ''),
                            array('class'=>'select2
                            kode_dokumen', 'style'=>'width:100%','id'=>'status_select_id', 'aria-label'=>'kode_dokumen',
                            'data-validation' => "required")) }}
                            {!! $errors->first('kode_dokumen', '<span class="alert-msg" aria-hidden="true"><i
                                    class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('nomor_dokumen') ? ' has-error' : '' }}">
                        <label for="nomor_dokumen" class="col-md-3 control-label">Nomor Dokumen Pabean (HS-Code)3</label>
                        <div class="col-md-7 col-sm-12">
                            <input class="form-control" type="text" name="nomor_dokumen" aria-label="nomor_dokumen"
                                id="nomor_dokumen" value="{{ old('name', '') }}" {!!
                                (Helper::checkIfRequired($item, 'nomor_dokumen' ))
                                ? ' data-validation="required" required' : '' !!} />
                            {!! $errors->first('nomor_dokumen', '<span class="alert-msg" aria-hidden="true"><i
                                    class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>
                    

                    @include ('partials.forms.edit.tanggal_dokumen')
                    
                    

                    {{--  <div class="form-group {{ $errors->has('entry_status') ? ' has-error' : '' }}">
                        <label for="entry_status" class="col-md-3 control-label">{{ trans('Status Kelengkapan') }}</label>
                        <div class="col-md-7 col-sm-11">
                            {{ Form::select('entry_status', array('' => 'Masukkan Status', 'l' => 'Lengkap', 'tl' => 'Tidak Lengkap') , old('entry_status', ''),
                            array('class'=>'select2
                            entry_status', 'style'=>'width:100%','id'=>'status_select_id', 'aria-label'=>'entry_status',
                            'data-validation' => "required")) }}
                            {!! $errors->first('entry_status', '<span class="alert-msg" aria-hidden="true"><i
                                    class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>  --}}

                    

                    @if ($item->requireAcceptance() || $item->getEula() || ($snipeSettings->webhook_endpoint!=''))
                    <div class="form-group notification-callout">
                        <div class="col-md-8 col-md-offset-3">
                            <div class="callout callout-info">

                                @if ($item->requireAcceptance())
                                <i class="far fa-envelope" aria-hidden="true"></i>
                                {{ trans('admin/categories/general.required_acceptance') }}
                                <br>
                                @endif

                                @if ($item->getEula())
                                <i class="far fa-envelope" aria-hidden="true"></i>
                                {{ trans('admin/categories/general.required_eula') }}
                                <br>
                                @endif

                                @if ($snipeSettings->webhook_endpoint!='')
                                <i class="fab fa-slack" aria-hidden="true"></i>
                                {{ trans('general.webhook_msg_note') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
                <!--/.box-body-->
                <div class="box-footer">
                    <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
                    <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-check icon-white"
                            aria-hidden="true"></i> {{ trans('general.checkout') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!--/.col-md-7-->

    <!-- right column -->
    <div class="col-md-5" id="current_assets_box" style="display:none;">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('admin/users/general.current_assets') }}</h2>
            </div>
            <div class="box-body">
                <div id="current_assets_content">
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('moar_scripts')
<script>
  $(document).on("blur", "#harga_satuan_barang", function(){
    let jumlahBarang = $("#jumlah_barang_peng").val();
    let hargaBarang  = $(this).val();
    if(hargaBarang != ""){
        let totalHargaBarang = parseInt(jumlahBarang) * parseInt(hargaBarang);
        $("#harga_total_barang").val(totalHargaBarang).trigger("change");
    }
  })
  $(document).on("blur", "#jumlah_barang_peng", function(){
    let jumlahBarang = $(this).val();
    let hargaBarang  = $("#harga_satuan_barang").val();
    if(hargaBarang != ""){
      let totalHargaBarang = parseInt(jumlahBarang) * parseInt(hargaBarang);
      $("#harga_total_barang").val(totalHargaBarang).trigger("change");
      console.log(hargaBarang);
    }
  });  
    
  </script>
  
  <!--lampirkan dokumen-->
  <script>
let selectedFiles = [];

document.getElementById('lampiran').addEventListener('change', function (e) {
    selectedFiles = Array.from(e.target.files);
    renderPreview();
});

function renderPreview() {
    const preview = document.getElementById('preview-area');
    preview.innerHTML = '';

    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            let content;

            if (file.type.startsWith('image/')) {
                content = `<img src="${e.target.result}" style="width:80px;height:100px;object-fit:cover;border:1px solid #ccc;" />`;
            } else if (file.type === 'application/pdf') {
                content = `<img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" style="width:60px;height:70px;" />`;
            } else {
                content = `<span>${file.name}</span>`;
            }

            preview.innerHTML += `
                <div class="col-md-3 text-center" style="position: relative; margin-bottom: 10px;">
                    ${content}
                    <div style="position:absolute;top:0;right:5px;cursor:pointer;" onclick="removeFile(${index})">
                        <span style="color:red;font-size:20px;">&times;</span>
                    </div>
                    <div style="font-size:12px;word-break:break-all;">${file.name}</div>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    });

    updateInputFiles();
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    renderPreview();
}

function updateInputFiles() {
    const input = document.getElementById('lampiran');
    const dataTransfer = new DataTransfer();

    selectedFiles.forEach(file => dataTransfer.items.add(file));
    input.files = dataTransfer.files;
}
</script>
  @stop