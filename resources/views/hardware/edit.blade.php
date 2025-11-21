
@extends('layouts/edit-form', [
    'createText' => trans('admin/hardware/form.create'),
    'updateText' => trans('admin/hardware/form.update'),
    'topSubmit' => true,
    'helpText' => trans('help.assets'),
    'helpPosition' => 'right',
    'formAction' => ($item->id) ? route('hardware.update', ['hardware' => $item->id]) : route('hardware.store'),
])


{{-- Page content --}}
@section('inputFields')
  
    {{--  {!! $errors !!}  --}}
        
    {{--@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])--}}
    <div class="form-group">
            <label for="companiess" class="col-md-3 control-label">Company</label>
            <div class="col-md-7 col-sm-12">
              {!! $errors->first('lokasi_asset', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              <select name="companiess" id="companiess" class="form-control select2" aria-label="companiess" data-selected="{{ old('ncompanies', $item->ncompanies) }}">
                      <option value="">Pilih Company</option>
                  </select>
            </div>
          </div>
    @include ('partials.forms.edit.serial', ['fieldname'=> 'serials[1]', 'old_val_name' => 'serials.1', 'translated_serial' => trans('admin/hardware/form.serial')])

    

    <div class="input_fields_wrap">
    </div>

    {{--  @include ('partials.forms.edit.model-select', ['translated_name' => trans('admin/hardware/form.model'), 'fieldname' => 'model_id', 'field_req' => true])  --}}


    @include ('partials.forms.edit.status', [ 'required' => 'true'])
    @if (!$item->id)
        @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true', 'location_select' => 'true', 'style' => 'display:none;'])
        @include ('partials.forms.edit.asset-select', ['translated_name' => trans('admin/hardware/form.checkout_to'), 'fieldname' => 'assigned_asset', 'style' => 'display:none;', 'required' => 'false'])
        {{--  @include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/hardware/form.checkout_to'), 'fieldname' => 'assigned_user', 'style' => 'display:none;', 'required' => 'false'])  --}}
        {{--  @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/hardware/form.checkout_to'), 'fieldname' => 'assigned_location', 'style' => 'display:none;', 'required' => 'false'])  --}}
    @elseif (($item->assignedTo) && ($item->deleted_at == ''))
        <!-- This is an asset and it's currently deployed, so let them edit the expected checkin date -->
        @include ('partials.forms.edit.datepicker', ['translated_name' => trans('admin/hardware/form.expected_checkin'),'fieldname' => 'expected_checkin'])
    @endif

    {{--  @include ('partials.forms.edit.notes')  --}}
    {{--  @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/hardware/form.default_location'), 'fieldname' => 'rtd_location_id', 'help_text' => trans('general.rtd_location_help')])  --}}
    {{--  @include ('partials.forms.edit.requestable', ['requestable_text' => trans('admin/hardware/general.requestable')])  --}}
    
    {{--  @include ('partials.forms.edit.location-select', ['translated_name' => trans('Lokasi'), 'fieldname' => 'location_id'])  --}}


    {{--  @include ('partials.forms.edit.image-upload', ['image_path' => app('assets_upload_path')])  --}}

    
    {{--  @include ('partials.forms.edit.warranty')  --}}

    <!-- byod checkbox -->
    {{--  <div class="form-group">
        <div class="col-md-7 col-md-offset-3">
            <label for="byod" class="form-control">
                <input type="checkbox" value="1" name="byod" {{ (old('remote', $item->byod)) == '1' ? ' checked="checked"' : '' }} aria-label="byod">
                {{ trans('general.byod') }}

            </label>
            <p class="help-block">{{ trans('general.byod_help') }}
            </p>
        </div>
    </div>  --}}

    <div class="form-group {{ $errors->has('status_pemasukan_mgpa') ? ' has-error' : '' }}">
        <label for="status_pemasukan_mgpa" class="col-md-3 control-label">Status Asset ITDC</label>
        <div class="col-md-7 col-sm-11">
            {{ Form::select('status_pemasukan_mgpa', ['' => 'Pilih Status', 'barang asset' => 'Barang Asset', 'barang penangguhan' => 'Barang Penangguhan', 'barang modal pembebasan' => 'Barang Modal Pembebasan'] , old('status_pemasukan_mgpa', $item->status_pemasukan_mgpa), array('class'=>'select2 status_pemasukan_mgpa', 'style'=>'width:100%','id'=>'status_pemasukan_mgpa', 'aria-label'=>'status_pemasukan_mgpa', 'data-validation' => "required")) }}
            {!! $errors->first('status_pemasukan_mgpa', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div> 
    </div>
    <!-- <div class="form-group {{ $errors->has('nomor_purchase') ? ' has-error' : '' }}" id="nomor_purchase">
        <label for="nomor_purchase" class="col-md-3 control-label">Nomor Purchase</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="text" name="nomor_purchase" aria-label="nomor_purchase" id="nomor_purchase" value="{{ old('nomor_purchase', $item->nomor_purchase) }}" {!!  (Helper::checkIfRequired($item, 'nomor_purchase')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('nomor_purchase', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div> -->
    <div class="form-group {{ $errors->has('event') ? ' has-error' : '' }}">
        <label for="event" class="col-md-3 control-label">Event</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="text" name="event" aria-label="event" id="event" value="{{ old('event', $item->event) }}" {!!  (Helper::checkIfRequired($item, 'event')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('event', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('namalokasi') ? ' has-error' : '' }}">
            <label for="namalokasi" class="col-md-3 control-label">Lokasi Asset</label>
            <div class="col-md-7 col-sm-11">

            {{-- Select + Tombol Tambah & Hapus --}}
            <div style="display: flex; gap: 5px; align-items: center;">
                <div style="flex: 1;">
                    {{ Form::select('namalokasi', $listlokasi, old('namalokasi', $item->namalokasi ?? ''), [
                        'class' => 'form-control select2',
                        'style' => 'width:100%',
                        'id' => 'namalokasi',
                        ]) }}
                    </div>

                    {{-- Tombol Tambah --}}
                    <button type="button" class="btn btn-primary" id="tambahLokasi" title="Tambah Lokasi Baru">
                        <i class="fas fa-plus"></i>
                    </button>

                    {{-- Tombol Hapus --}}
                    <button type="button" class="btn btn-danger" id="hapusLokasi" title="Hapus Lokasi yang Dipilih">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>

                {{-- Input Status Baru --}}
                <div id="inputBaruWrapperLokasi" style="margin-top: 10px; display: none;">
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <input type="text" name="lokasibaru" id="lokasibaru" class="form-control" placeholder="Lokasi (contoh: Mandalika)">
                        <small id="error_lokasibaru" class="text-danger" style="display:none;">Lokasi tidak boleh kosong.</small>

                        <div style="text-align: right;">
                            <button type="button" class="btn btn-secondary" id="simpanlokasibaru">Simpan</button>
                        </div>
                    </div>
                </div>

                {{-- Error dari server untuk namalokasi --}}
                {!! $errors->first('namalokasi', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
            </div>
        </div>

    <div class="form-group {{ $errors->has('detail_lokasi') ? ' has-error' : '' }}">
                            <label for="detail_lokasi" class="col-md-3 control-label">Detail Lokasi Asset</label>
                            <div class="col-md-7 col-sm-11">

                                {{-- Select + Tombol Tambah & Hapus --}}
                                <div style="display: flex; gap: 5px; align-items: center;">
                                    <div style="flex: 1;">
                                        {{ Form::select('detail_lokasi', $listdetaillokasi, old('detail_lokasi', $item->detail_lokasi ?? ''), [
                                            'class' => 'form-control select2',
                                            'style' => 'width:100%',
                                            'id' => 'detail_lokasi',
                                        ]) }}
                                    </div>

                                    {{-- Tombol Tambah --}}
                                    <button type="button" class="btn btn-primary" id="tambahDetailLokasi" title="Tambah Detail Lokasi Baru">
                                        <i class="fas fa-plus"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <button type="button" class="btn btn-danger" id="hapusDetailLokasi" title="Hapus Detail Lokasi yang Dipilih">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>

                                {{-- Input Status Baru --}}
                                <div id="inputBaruWrapperdetail" style="margin-top: 10px; display: none;">
                                    <div style="display: flex; flex-direction: column; gap: 5px;">
                                        <input type="text" name="detaillokasibaru" id="detaillokasibaru" class="form-control" placeholder="Detail Lokasi (contoh: Mandalika)">
                                        <small id="error_detaillokasibaru" class="text-danger" style="display:none;">Detail Lokasi tidak boleh kosong.</small>

                                        <div style="text-align: right;">
                                            <button type="button" class="btn btn-secondary" id="simpanDetailLokasiBaru">Simpan</button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Error dari server untuk detail_lokasi --}}
                                {!! $errors->first('detail_lokasi', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
                            </div>
    </div>
    

    <div class="form-group {{ $errors->has('nama_owner') ? ' has-error' : '' }}">
            <label for="nama_owner" class="col-md-3 control-label">Owner</label>
            <div class="col-md-7 col-sm-11">

                {{-- Select + Tombol Tambah & Hapus --}}
                <div style="display: flex; gap: 5px; align-items: center;">
                    <div style="flex: 1;">
                        {{ Form::select('nama_owner', $listownerr, old('nama_owner', $item->nama_owner ?? ''), [
                            'class' => 'form-control select2',
                            'style' => 'width:100%',
                            'id' => 'nama_owner',
                        ]) }}
                    </div>

                    {{-- Tombol Tambah --}}
                    <button type="button" class="btn btn-primary" id="tambahOwner" title="Tambah Owner Baru">
                        <i class="fas fa-plus"></i>
                    </button>

                    {{-- Tombol Hapus --}}
                    <button type="button" class="btn btn-danger" id="hapusOwner" title="Hapus Owner yang Dipilih">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>

                {{-- Input Status Baru --}}
                <div id="inputBaruWrapperOwner" style="margin-top: 10px; display: none;">
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <input type="text" name="ownerbaru" id="ownerbaru" class="form-control" placeholder="Owner (contoh: ITDC)">
                        <small id="error_ownerbaru" class="text-danger" style="display:none;">Owner tidak boleh kosong.</small>

                        <div style="text-align: right;">
                            <button type="button" class="btn btn-secondary" id="simpanownerbaru">Simpan</button>
                        </div>
                    </div>
                </div>

                {{-- Error dari server untuk nama_owner --}}
                {!! $errors->first('nama_owner', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
            </div>
        </div>

    

    <div class="form-group {{ $errors->has('departemenMGPA') ? ' has-error' : '' }}">
        <label for="departemenMGPA" class="col-md-3 control-label">Departemen</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="text" name="departemenMGPA" aria-label="departemenMGPA" id="departemenMGPA" value="{{ old('departemen', $item->departemen) }}" {!!  (Helper::checkIfRequired($item, 'departemenMGPA')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('departemenMGPA', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('site') ? ' has-error' : '' }}">
        <label for="site" class="col-md-3 control-label">Site</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" value="Pertamina Mandalika International Sirkuit" type="text" name="site" aria-label="site" id="site" value="{{ old('site', $item->site) }}" {!!  (Helper::checkIfRequired($item, 'site')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('site', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>

    

    <!-- Asset Tag -->
    <div class="form-group {{ $errors->has('asset_tag') ? ' has-error' : '' }}">
        <label for="asset_tag" class="col-md-3 control-label">{{ trans('Kode Asset') }}</label>
        @if  ($item->id)
            <!-- we are editing an existing asset,  there will be only one asset tag -->
            <div class="col-md-7 col-sm-12{{  (Helper::checkIfRequired($item, 'asset_tag')) ? ' required' : '' }}">
            <input class="form-control" type="text" name="asset_tags[1]" id="asset_tag" value="{{ old('asset_tag', $item->asset_tag) }}" data-validation="required">
                {!! $errors->first('asset_tags', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
                {!! $errors->first('asset_tag', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
            </div>
        @else
            <!-- we are creating a new asset - let people use more than one asset tag -->
            <div class="col-md-7 col-sm-12{{  (Helper::checkIfRequired($item, 'asset_tag')) ? ' required' : '' }}">
                <input class="form-control" type="text" name="asset_tags[1]" id="asset_tag" value="{{ old('asset_tags.1', \App\Models\Asset::autoincrement_asset()) }}" data-validation="required">
                {!! $errors->first('asset_tags', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
                {!! $errors->first('asset_tag', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
            </div>
            {{--  <div class="col-md-2 col-sm-12">
                <button class="add_field_button btn btn-default btn-sm">
                    <i class="fas fa-plus"></i>
                </button>
            </div>   --}}
        @endif
    </div>  

    @include ('partials.forms.edit.name', ['translated_name' => trans('Nama Asset')])

    <div class="form-group {{ $errors->has('kategori_barang') ? ' has-error' : '' }}">
        <label for="kategori_barang" class="col-md-3 control-label">{{ trans('Kategori Asset') }}</label>
        <div class="col-md-7 col-sm-11">
            {{ Form::select('kategori_barang', $category , old('kategori_barang', $item->kategori_barang), array('class'=>'select2 kategori_barang', 'style'=>'width:100%','id'=>'kategori_barang', 'aria-label'=>'kategori_barang', 'data-validation' => "required")) }}
            <input class="form-control" type="hidden" name="nomor_kategori_barang" aria-label="nomor_kategori_barang" id="nomor_kategori_barang" value="{{ old('nomor_kategori_barang', $item->nomor_kategori_barang) }}"/>
            {!! $errors->first('kategori_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div> 
    </div>
    <!-- EDIT DISINI -->
        <div class="form-group {{ $errors->has('kode_dokumen_pabean') ? ' has-error' : '' }}">
                <label for="kode_dokumen" class="col-md-3 control-label">Kode Dokumen Pabean</label>
                <div class="col-md-7 col-sm-11">

                    {{-- Select dan tombol + sejajar --}}
                    <div style="display: flex; gap: 5px; align-items: center;">
                        <div style="flex: 1;">
                            {{ Form::select('kode_dokumen', $kodeDokumen, old('kode_dokumen', $item->kode_dokumen_pabean ?? ''), [
                                'class' => 'form-control select2',
                                'id' => 'kode_dokumen',
                            ]) }}
                        </div>

                        
                        {{-- Tombol Tambah --}}
                        <button type="button" class="btn btn-primary" id="tambahKodeDokumen" title="Tambah Kode Dokumen Baru">
                            <i class="fas fa-plus"></i>
                        </button>

                        {{-- Tombol Hapus --}}
                        <button type="button" class="btn btn-danger" id="hapusKodeDokumen" title="Hapus Kode yang Dipilih">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>


                    <div id="inputBaruWrapper" style="margin-top: 10px; display: none;">
                        <div style="display: flex; flex-direction: column; gap: 5px;">

                            <input type="text" name="kode_baru" id="kode_baru" class="form-control" placeholder="Kode Dokumen (contoh: 0407999)">

                            <input type="text" name="label_baru" id="label_baru" class="form-control" placeholder="Label Dokumen (contoh: BC Tambahan)">

                            <div style="text-align: right;">
                                <button type="button" class="btn btn-secondary" id="simpanKodeDokumenBaru">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Error Message --}}
                    {!! $errors->first('kode_dokumen_pabean', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
                </div>
        </div>
    <div class="form-group {{ $errors->has('nomor_pengajuan') ? ' has-error' : '' }}">
            <label for="nomor_pengajuan" class="col-md-3 control-label">Nomor Pengajuan</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nomor_pengajuan" aria-label="nomor_pengajuan" id="nomor_pengajuan" value="{{ old('nomor_pengajuan', !empty($item->Pemasukan->nomor_pengajuan) ? $item->Pemasukan->nomor_pengajuan : '') }}" />
                {!! $errors->first('nomor_pengajuan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
    </div>
    
    <div class="form-group {{ $errors->has('tanggal_pengajuan') ? ' has-error' : '' }}">
            <label for="tanggal_pengajuan" class="col-md-3 control-label">{{ trans('Tanggal Pengajuan') }}</label>
            <div class="input-group col-md-4">
                 <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                     <input type="text" class="form-control" placeholder="{{ trans('tanggal pengajuan') }}" name="tanggal_pengajuan" id="tanggal_pengajuan" readonly value="{{  old('tanggal_pengajuan', !empty($item->Pemasukan->tanggal_pengajuan) ? $item->Pemasukan->tanggal_pengajuan : '') }}"  style="background-color:inherit">
                     <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                </div>
                {!! $errors->first('tanggal_pengajuan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
    </div>
    
    <div class="form-group {{ $errors->has('fasilitas') ? ' has-error' : '' }}">
        <label class="col-md-3 control-label">Fasilitas Fiskal</label>
        <div class="col-md-7 col-sm-11" style="padding-top: 7px;">
        {{-- === RADIO === --}}
        <!-- <span class="alert-msg" aria-hidden="true">Berikan tanda " , " untuk memisahkan</span> -->
        <label style="display: flex; align-items: center; margin-bottom: 5px;">
            {{ Form::radio('bea', 'Pembebasan Bea Masuk Barang Modal', old('bea', $item->bea) == 'Pembebasan Bea Masuk Barang Modal', ['style' => 'margin-right:8px;']) }}
            <span>Pembebasan Bea Masuk Barang Modal</span>
        </label>

        <label style="display: flex; align-items: center; margin-bottom: 5px;">
            {{ Form::radio('bea', 'Pembebasan Bea Masuk Barang Konsumsi', old('bea', $item->bea) == 'Pembebasan Bea Masuk Barang Konsumsi', ['style' => 'margin-right:8px;']) }}
            <span>Pembebasan Bea Masuk Barang Konsumsi</span>
        </label>

        <label style="display: flex; align-items: center; margin-bottom: 10px;">
            {{ Form::radio('bea', 'Penangguhan Bea Masuk', old('bea', $item->bea) == 'Penangguhan Bea Masuk', ['style' => 'margin-right:8px;']) }}
            <span>Penangguhan Bea Masuk</span>
        </label>

        {{-- === CHECKBOX === --}}
        <label style="display: flex; align-items: center; margin-bottom: 5px;">
            {{ Form::checkbox('PPN', 1, old('ppn', $item->ppn) == 1, ['style' => 'margin-right:8px;']) }}
            <span>Tidak Dipungut PPN</span>
        </label>

        <label style="display: flex; align-items: center; margin-bottom: 5px;">
            {{ Form::checkbox('PPhImpor', 1, old('pph_impor', $item->pph_impor) == 1, ['style' => 'margin-right:8px;']) }}
            <span>Tidak Dipungut PPh Impor</span>
        </label>

        <label style="display: flex; align-items: center; margin-bottom: 5px;">
            {{ Form::checkbox('PPnBM', 1, old('ppnbm', $item->ppnbm) == 1, ['style' => 'margin-right:8px;']) }}
            <span>Tidak Dipungut PPnBM</span>
        </label>
            {!! $errors->first('Bea', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
        </div>
    </div>
    
    
    
    <div class="form-group {{ $errors->has('jumlah_barang') ? ' has-error' : '' }}">
        <!-- <label for="jumlah_barang" class="col-md-3 control-label">Jumlah Barang</label> -->
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="hidden" min="0" value="0" name="jumlah_barang" aria-label="jumlah_barang" id="jumlah_barang" value="{{ old('jumlah_barang', $item->jumlah_barang) }}" {!!  (Helper::checkIfRequired($item, 'jumlah_barang')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('jumlah_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('satuan_barang') ? ' has-error' : '' }}">
        <label for="satuan_barang" class="col-md-3 control-label">Satuan</label>
        <div class="col-md-7 col-sm-11">
            {{ Form::select('satuan_barang', !empty($satuan) ? $satuan : ['' => 'pilih Data'] , old('satuan_barang', $item->satuan_barang), array('class'=>'select2 satuan_barang', 'style'=>'width:100%','id'=>'satuan_barang', 'aria-label'=>'satuan_barang', 'data-validation' => "required")) }}
            {!! $errors->first('satuan_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div> 
    </div>
    <div class="form-group {{ $errors->has('harga_satuan_barang') ? ' has-error' : '' }}">
        <label for="harga_satuan_barang" class="col-md-3 control-label">Harga Barang</label>
        <div class="col-md-7 col-sm-12">
            <div class="row">
                <div class="col-md-5">
                    {{ Form::select('mata_uang', $mataUang , old('mata_uang', $item->mata_uang), array('class'=>'select2 mata_uang', 'style'=>'width:100%','id'=>'mata_uang', 'aria-label'=>'mata_uang', 'data-validation' => "required")) }}
                    {!! $errors->first('mata_uang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                </div>    
                <div class="col-md-7">
                    <input class="form-control" type="number" name="harga_satuan_barang" aria-label="harga_satuan_barang" id="harga_satuan_barang" value="{{ old('harga_satuan_barang', $item->harga_satuan_barang) }}" {!!  (Helper::checkIfRequired($item, 'harga_satuan_barang')) ? ' data-validation="required" required' : '' !!}  />
                    {!! $errors->first('harga_satuan_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                </div>    
            </div>
        </div>
    </div>
    <div class="form-group {{ $errors->has('harga_total_barang') ? ' has-error' : '' }}">
        <label for="harga_total_barang" class="col-md-3 control-label">Harga Total Barang</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="number" name="harga_total_barang" aria-label="harga_total_barang" id="harga_total_barang" value="{{ old('harga_total_barang', $item->harga_total_barang) }}" {!!  (Helper::checkIfRequired($item, 'harga_total_barang')) ? ' data-validation="required" required' : '' !!} readonly />
            {!! $errors->first('harga_total_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
    <div class="form-group {{ $statusEdit == false ? 'hidden' : '' }}">
        <label for="lampiran" class="col-md-3 control-label">Lampiran saat ini</label>
        <div class="col-md-7 col-sm-12">
            @php
                $rawLampiran = $item->lampiran;
                $lampiranArray = preg_split('/\s*,\s*/', $item->lampiran);
            @endphp
    
            @php
                $index = 0;
            @endphp
            
            @foreach($lampiranArray as $raw)
                @php
                    $clean = trim(preg_replace('/[[:^print:]]/u', '', $raw));
                @endphp
                @if($clean !== '')
                    <div class="d-flex align-items-center mb-2" style="gap: 10px;">
                        <a href="{{ asset($clean) }}" target="_blank">{{ basename($clean) }}</a>
                        <form method="POST" action="{{ route('hardware.lampiran.delete', ['id' => $item->id, 'index' => $index]) }}" onsubmit="return confirm('Yakin hapus file ini?')" style="display:inline;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" style="color: red; border: none; background: transparent;">❌</button>
                        </form>
                    </div>
                    @php $index++; @endphp
                @endif
            @endforeach
            
            @if($index === 0)
                <div class="text-muted">Tidak ada lampiran</div>
            @endif
        </div>
    </div>

    @csrf
        <div class="form-group{{ $errors->has('lampiran') ? ' has-error' : '' }}">
          <label for="lampiran" class="col-md-3 control-label">Lampiran Dokumen</label>
          <div class="col-md-7 col-sm-12">
            <input type="file" name="lampiran[]" id="lampiran" class="form-control" multiple accept=".pdf,.jpg,.jpeg,.png,.bmp" />
            {!! $errors->first('lampiran', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
            <div id="preview-area" class="row" style="margin-top: 10px;"></div>
          </div>
        </div>
        

    <!-- <div class="form-group {{ $errors->has('saldo_awal') ? ' has-error' : '' }}">
        <label for="saldo_awal" class="col-md-3 control-label">Saldo Awal</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="number" min="0" name="saldo_awal" aria-label="saldo_awal" id="saldo_awal" value="{{ old('saldo_awal', $item->saldo_awal) }}" {!!  (Helper::checkIfRequired($item, 'saldo_awal')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('saldo_awal', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div> -->
    
        

    <!--<div class="form-group {{ $statusEdit == false ? 'hidden' : '' }} {{ $errors->has('pemasukan') ? ' has-error' : '' }}">-->
    <!--    <label for="pemasukan" class="col-md-3 control-label">Pemasukan</label>-->
    <!--    <div class="col-md-7 col-sm-12">-->
    <!--        <input class="form-control" type="number" min="0" name="pemasukan" aria-label="pemasukan" id="pemasukan" value="{{ old('pemasukan', $item->pemasukan != "" ? $item->pemasukan : 0 ) }}" {!!  (Helper::checkIfRequired($item, 'pemasukan')) ? ' data-validation="required" required' : '' !!}  />-->
    <!--        {!! $errors->first('pemasukan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
    <!--    </div>-->
    <!--</div>-->

    <!--<div class="form-group {{ $statusEdit == false ? 'hidden' : '' }} {{ $errors->has('pengeluaran') ? ' has-error' : '' }}">-->
    <!--    <label for="pengeluaran" class="col-md-3 control-label">Pengeluaran</label>-->
    <!--    <div class="col-md-7 col-sm-12">-->
    <!--        <input class="form-control" type="number" min="0" name="pengeluaran" aria-label="pengeluaran" id="pengeluaran" value="{{ old('pengeluaran', $item->pengeluaran != "" ? $item->pengeluaran : 0 ) }}" {!!  (Helper::checkIfRequired($item, 'pengeluaran')) ? ' data-validation="required" required' : '' !!}  />-->
    <!--        {!! $errors->first('pengeluaran', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
    <!--    </div>-->
    <!--</div>-->

    <!--<div class="form-group {{ $statusEdit == false ? 'hidden' : '' }} {{ $errors->has('penyesuaian') ? ' has-error' : '' }}">-->
    <!--    <label for="penyesuaian" class="col-md-3 control-label">Penyesuaian</label>-->
    <!--    <div class="col-md-7 col-sm-12">-->
    <!--        <input class="form-control" type="number" name="penyesuaian" aria-label="penyesuaian" id="penyesuaian" value="{{ old('penyesuaian', $item->penyesuaian != "" ? $item->penyesuaian : 0 ) }}" {!!  (Helper::checkIfRequired($item, 'penyesuaian')) ? ' data-validation="required" required' : '' !!}  />-->
    <!--        {!! $errors->first('penyesuaian', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
    <!--    </div>-->
    <!--</div>-->

    <!--<div class="form-group {{ $statusEdit == false ? 'hidden' : '' }} {{ $errors->has('saldo_buku') ? ' has-error' : '' }}">-->
    <!--    <label for="saldo_buku" class="col-md-3 control-label">Saldo Buku</label>-->
    <!--    <div class="col-md-7 col-sm-12">-->
    <!--        <input class="form-control" type="number" min="0" name="saldo_buku" aria-label="saldo_buku" id="saldo_buku" value="{{ old('saldo_buku', $item->saldo_buku != "" ? $item->saldo_buku : 0 ) }}" {!!  (Helper::checkIfRequired($item, 'saldo_buku')) ? ' data-validation="required" required' : '' !!}  />-->
    <!--        {!! $errors->first('saldo_buku', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
    <!--    </div>-->
    <!--</div>-->

    <!--<div class="form-group {{ $statusEdit == false ? 'hidden' : '' }} {{ $errors->has('stock_opname') ? ' has-error' : '' }}">-->
    <!--    <label for="stock_opname" class="col-md-3 control-label">Stockopname</label>-->
    <!--    <div class="col-md-7 col-sm-12">-->
    <!--        <input class="form-control" type="number" min="0" name="stock_opname" aria-label="stock_opname" id="stock_opname" value="{{ old('stock_opname', $item->stock_opname != "" ? $item->stock_opname : 0 ) }}" {!!  (Helper::checkIfRequired($item, 'stock_opname')) ? ' data-validation="required" required' : '' !!}  />-->
    <!--        {!! $errors->first('stock_opname', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
    <!--    </div>-->
    <!--</div>-->

    <!--<div class="form-group {{ $statusEdit == false ? 'hidden' : '' }} {{ $errors->has('selisih') ? ' has-error' : '' }}">-->
    <!--    <label for="selisih" class="col-md-3 control-label">Selisih</label>-->
    <!--    <div class="col-md-7 col-sm-12">-->
    <!--        <input class="form-control" type="number" name="selisih" aria-label="selisih" id="selisih" value="{{ old('selisih', $item->selisih != "" ? $item->selisih : 0 ) }}" {!!  (Helper::checkIfRequired($item, 'selisih')) ? ' data-validation="required" required' : '' !!}  />-->
    <!--        {!! $errors->first('selisih', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
    <!--    </div>-->
    <!--</div>-->

    <!--<div class="form-group {{ $statusEdit == false ? 'hidden' : '' }} {{ $errors->has('hasil_pencacahan') ? ' has-error' : '' }}">-->
    <!--    <label for="hasil_pencacahan" class="col-md-3 control-label">Hasil Pencacahan</label>-->
    <!--    <div class="col-md-7 col-sm-12">-->
    <!--        <input class="form-control" type="number" min="0" name="hasil_pencacahan" aria-label="hasil_pencacahan" id="hasil_pencacahan" value="{{ old('hasil_pencacahan', $item->hasil_pencacahan != "" ? $item->hasil_pencacahan : 0 ) }}" {!!  (Helper::checkIfRequired($item, 'hasil_pencacahan')) ? ' data-validation="required" required' : '' !!}  />-->
    <!--        {!! $errors->first('hasil_pencacahan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
    <!--    </div>-->
    <!--</div>-->

    <!--<div class="form-group {{ $statusEdit == false ? 'hidden' : '' }} {{ $errors->has('jumlah_selisih') ? ' has-error' : '' }}">-->
    <!--    <label for="jumlah_selisih" class="col-md-3 control-label">Jumlah Selisih</label>-->
    <!--    <div class="col-md-7 col-sm-12">-->
    <!--        <input class="form-control" type="number" name="jumlah_selisih" aria-label="jumlah_selisih" id="jumlah_selisih" value="{{ old('jumlah_selisih', $item->jumlah_selisih != "" ? $item->jumlah_selisih : 0 ) }}" {!!  (Helper::checkIfRequired($item, 'jumlah_selisih')) ? ' data-validation="required" required' : '' !!}  />-->
    <!--        {!! $errors->first('jumlah_selisih', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
    <!--    </div>-->
    <!--</div>-->


    @include ('partials.forms.edit.keterangan');

    <!-- <div class="form-group {{ $errors->has('jenis_transaksi') ? ' has-error' : '' }}">
        <label for="jenis_transaksi" class="col-md-3 control-label">Jenis Transaksi Pemasukan</label>
        <div class="col-md-7 col-sm-11">
            {{ Form::select('jenis_transaksi', ['' => 'Pilih Data Transaksi', 'y' => 'Ya', 't' => 'Tidak'] , old('jenis_transaksi', $item->jenis_transaksi), array('class'=>'select2 jenis_transaksi', 'style'=>'width:100%','id'=>'jenis_transaksi', 'aria-label'=>'jenis_transaksi', 'data-validation' => "required")) }}
            {!! $errors->first('jenis_transaksi', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div> 
    </div> -->

    
    <div id="transaksi_pemasukan" class="hidden">
        <!--<div class="form-group {{ $errors->has('lokasi') ? ' has-error' : '' }}">-->
        <!--    <label for="lokasi" class="col-md-3 control-label">Lokasi</label>-->
        <!--    <div class="col-md-7 col-sm-12">-->
        <!--        <input class="form-control" type="text" name="lokasi" aria-label="lokasi" id="lokasi" value="{{ old('lokasi', $item->lokasi) }}" {!!  (Helper::checkIfRequired($item, 'lokasi')) ? ' data-validation="required" required' : '' !!}  />-->
        <!--        {!! $errors->first('lokasi', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
        <!--    </div>-->
        <!--</div>-->
    
        <!--<div class="form-group{{ $errors->has('detail_lokasi') ? ' has-error' : '' }}">-->
        <!--    <label for="detail_lokasi" class="col-md-3 control-label">Detail Lokasi</label>-->
        <!--    <div class="col-md-7 col-sm-12">-->
        <!--        <textarea class="col-md-6 form-control" id="detail_lokasi" aria-label="detail_lokasi" name="detail_lokasi" style="min-width:100%;">{{ old('detail_lokasi', $item->detail_lokasi) }}</textarea>-->
        <!--        {!! $errors->first('detail_lokasi', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
        <!--    </div>-->
        <!--</div>-->
        
        <div class="form-group {{ $errors->has('nomor_daftar') ? ' has-error' : '' }}">
            <label for="nomor_daftar" class="col-md-3 control-label">Nomor Daftar</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nomor_daftar" aria-label="nomor_daftar" id="nomor_daftar" value="{{ old('nomor_daftar', !empty($item->Pemasukan->nomor_daftar) ? $item->Pemasukan->nomor_daftar : '') }}" />
                {!! $errors->first('nomor_daftar', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('tanggal_daftar') ? ' has-error' : '' }}">
            <label for="tanggal_daftar" class="col-md-3 control-label">{{ trans('Tanggal Daftar') }}</label>
            <div class="input-group col-md-4">
                 <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                     <input type="text" class="form-control" placeholder="{{ trans('tanggal daftar') }}" name="tanggal_daftar" id="tanggal_daftar" readonly value="{{  old('tanggal_daftar', !empty($item->Pemasukan->tanggal_daftar) ? $item->Pemasukan->tanggal_daftar : '') }}"  style="background-color:inherit">
                     <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                </div>
                {!! $errors->first('tanggal_daftar', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('nomor_pemasukan') ? ' has-error' : '' }}">
            <label for="nomor_penerimaan_barang" class="col-md-3 control-label">Nomor Bukti Penerimaan Barang</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nomor_penerimaan_barang" aria-label="nomor_penerimaan_barang" id="nomor_penerimaan_barang" value="{{ old('nomor_penerimaan_barang', !empty($item->Pemasukan->nomor_pemasukan) ? $item->Pemasukan->nomor_pemasukan : '') }}" />
                {!! $errors->first('nomor_pemasukan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                <p id="msg" class="text-danger text-sm"></p>
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('tanggal_pemasukan') ? ' has-error' : '' }}">
            <label for="tanggal_penerimaan_barang" class="col-md-3 control-label">{{ trans('Tanggal Penerimaan Barang') }}</label>
            <div class="input-group col-md-4">
                 <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                     <input type="text" class="form-control" placeholder="{{ trans('Tanggal Penerimaan Barang') }}" name="tanggal_penerimaan_barang" id="tanggal_penerimaan_barang" readonly value="{{  old('tanggal_penerimaan_barang', !empty($item->Pemasukan->tanggal_pemasukan) ? $item->Pemasukan->tanggal_pemasukan : '') }}"  style="background-color:inherit">
                     <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                </div>
                {!! $errors->first('tanggal_pemasukan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('nama_pengirim') ? ' has-error' : '' }}">
            <label for="nama_pengirim" class="col-md-3 control-label">Nama Pengirim Barang</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nama_pengirim" aria-label="nama_pengirim" id="nama_pengirim" value="{{ old('nama_pengirim', !empty($item->Pemasukan->nama_pengirim) ? $item->Pemasukan->nama_pengirim : '') }}" />
                {!! $errors->first('nama_pengirim', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
    
        
    
    
        <div class="form-group {{ $errors->has('nomor_dokumen_pabean') ? ' has-error' : '' }}">
            <label for="nomor_dokumen" class="col-md-3 control-label">Nomor Dokumen Pabean</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nomor_dokumen" aria-label="nomor_dokumen"
                id="nomor_dokumen" value="{{ old('nomor_dokumen', !empty($item->Pemasukan->nomor_dokumen_pabean) ? $item->Pemasukan->nomor_dokumen_pabean : '') }}"  />
                {!! $errors->first('nomor_dokumen_pabean', '<span class="alert-msg" aria-hidden="true"><i
                    class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('tanggal_dokumen_pabean') ? ' has-error' : '' }}">
            <label for="tanggal_dokumen" class="col-md-3 control-label">{{ trans('Tanggal Dokumen Pabean') }}</label>
            <div class="input-group col-md-4">
                 <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                     <input type="text" class="form-control" placeholder="{{ trans('Tanggal Dokumen') }}" name="tanggal_dokumen" id="tanggal_dokumen" readonly value="{{  old('tanggal_dokumen', !empty($item->Pemasukan->tanggal_dokumen_pabean) ? $item->Pemasukan->tanggal_dokumen_pabean : '') }}" style="background-color:inherit">
                     <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                </div>
                {!! $errors->first('tanggal_dokumen_pabean', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>

        <div class="form-group{{ $errors->has('keterangan_pemasukan') ? ' has-error' : '' }}">
            <label for="keterangan_pemasukan" class="col-md-3 control-label">{{ trans('Keterangan') }}</label>
            <div class="col-md-7 col-sm-12">
            {{ Form::select('keterangan_pemasukan', $keteranganPemasukan , old('keterangan_pemasukan', $item->keterangan_pemasukan), array('class'=>'select2 keterangan_pemasukan', 'style'=>'width:100%','id'=>'keterangan_pemasukan', 'aria-label'=>'keterangan_pemasukan', 'data-validation' => "required")) }}
            {!! $errors->first('keterangan_pemasukan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>
    </div>    

    

    

     
    {{--  <div class="form-group {{ $errors->has('stock_opname') ? ' has-error' : '' }}">
        <label for="stock_opname" class="col-md-3 control-label">Stock Opname</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="text" name="stock_opname" aria-label="stock_opname" id="stock_opname" value="{{ old('name', $item->stock_opname) }}" {!!  (Helper::checkIfRequired($item, 'stock_opname')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('stock_opname', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
    <!-- <div class="form-group {{ $errors->has('saldo_awal') ? ' has-error' : '' }}">
        <label for="saldo_awal" class="col-md-3 control-label">Saldo Awal</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="text" name="saldo_awal" aria-label="saldo_awal" id="saldo_awal" value="{{ old('saldo_awal', $item->saldo_awal) }}" {!!  (Helper::checkIfRequired($item, 'saldo_awal')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('saldo_awal', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div> -->
    <div class="form-group {{ $errors->has('penyesuaian') ? ' has-error' : '' }}">
        <label for="penyesuaian" class="col-md-3 control-label">Penyesuaian</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="text" name="penyesuaian" aria-label="penyesuaian" id="penyesuaian" value="{{ old('penyesuaian', $item->penyesuaian) }}" {!!  (Helper::checkIfRequired($item, 'penyesuaian')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('penyesuaian', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
    <!-- <div class="form-group {{ $errors->has('saldo_buku') ? ' has-error' : '' }}">
        <label for="saldo_buku" class="col-md-3 control-label">Saldo Buku</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="text" name="saldo_buku" aria-label="saldo_buku" id="saldo_buku" value="{{ old('saldo_buku', $item->saldo_buku) }}" {!!  (Helper::checkIfRequired($item, 'saldo_buku')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('saldo_buku', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div> -->
    <!-- <div class="form-group {{ $errors->has('selisih') ? ' has-error' : '' }}">
        <label for="selisih" class="col-md-3 control-label">Selisih</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="text" name="selisih" aria-label="selisih" id="selisih" value="{{ old('selisih', $item->selisih) }}" {!!  (Helper::checkIfRequired($item, 'selisih')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('selisih', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div> -->
    <div class="form-group {{ $errors->has('pemasukan') ? ' has-error' : '' }}">
        <label for="pemasukan" class="col-md-3 control-label">Pemasukan</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="text" name="pemasukan" aria-label="pemasukan" id="pemasukan" value="{{ old('pemasukan', $item->pemasukan) }}" {!!  (Helper::checkIfRequired($item, 'pemasukan')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('pemasukan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('pengeluaran') ? ' has-error' : '' }}">
        <label for="pengeluaran" class="col-md-3 control-label">Pengeluaran</label>
        <div class="col-md-7 col-sm-12">
            <input class="form-control" type="text" name="pengeluaran" aria-label="pengeluaran" id="pengeluaran" value="{{ old('pengeluaran', $item->pengeluaran) }}" {!!  (Helper::checkIfRequired($item, 'pengeluaran')) ? ' data-validation="required" required' : '' !!}  />
            {!! $errors->first('pengeluaran', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>  --}}
    

    <div id='custom_fields_content'>
        <!-- Custom Fields -->
        @if ($item->model && $item->model->fieldset)
        <?php $model = $item->model; ?>
        @endif
        @if (Request::old('model_id'))
            @php
                $model = \App\Models\AssetModel::find(old('model_id'));
            @endphp
        @elseif (isset($selected_model))
            @php
                $model = $selected_model;
            @endphp
        @endif
        @if (isset($model) && $model)
        @include("models/custom_fields_form",["model" => $model])
        @endif
    </div>

    {{--  <div class="form-group">
    <label class="col-md-3 control-label"></label>

        <div class="col-md-9 col-sm-9 col-md-offset-3">

        <a id="optional_info" class="text-primary">
            <i class="fa fa-caret-right fa-2x" id="optional_info_icon"></i>
            <strong>{{ trans('admin/hardware/form.optional_infos') }}</strong>
        </a>

        </div>
        
        <div id="optional_details" class="col-md-12" style="display:none">
        <br>
            @include ('partials.forms.edit.name', ['translated_name' => trans('admin/hardware/form.name')])
            @include ('partials.forms.edit.warranty')

            <!-- byod checkbox -->
            <div class="form-group">
                <div class="col-md-7 col-md-offset-3">
                    <label for="byod" class="form-control">
                        <input type="checkbox" value="1" name="byod" {{ (old('remote', $item->byod)) == '1' ? ' checked="checked"' : '' }} aria-label="byod">
                        {{ trans('general.byod') }}

                    </label>
                    <p class="help-block">{{ trans('general.byod_help') }}
                    </p>
                </div>
            </div>
        </div>
    </div>  --}}

    {{--  <div class="form-group">
        <div class="col-md-9 col-sm-9 col-md-offset-3">
            <a id="order_info" class="text-primary">
                <i class="fa fa-caret-right fa-2x" id="order_info_icon"></i>
                <strong>{{ trans('admin/hardware/form.order_details') }}</strong>
            </a>
        </div>

        <div id='order_details' class="col-md-12" style="display:none">
            <br>
            @include ('partials.forms.edit.order_number')
            @include ('partials.forms.edit.purchase_date')
            @include ('partials.forms.edit.eol_date')
            @include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])

                @php
                $currency_type = null;
                if ($item->id && $item->location) {
                    $currency_type = $item->location->currency;
                }
                @endphp

            @include ('partials.forms.edit.purchase_cost', ['currency_type' => $currency_type])

        </div>
    </div>  --}}
   
@stop

@section('moar_scripts')



<script nonce="{{ csrf_token() }}">

    @if(Request::has('model_id'))
        //TODO: Refactor custom fields to use Livewire, populate from server on page load when requested with model_id
    $(document).ready(function() {
        fetchCustomFields();
    });
    @endif

    $(document).ready(function() {
        $("#nomor_purchase").hide();
        let jenis = $("#jenis_transaksi").val();
        if(jenis == "y"){
            $("#transaksi_pemasukan").removeClass("hidden");
        }
    });

    $(document).on("change", "#status_pemasukan_mgpa", function(){
        let statusPemasukanMGPA = $(this).val();
        if(statusPemasukanMGPA == "barang asset"){
            $("#nomor_purchase").show();
        }else{
            $("#nomor_purchase").hide();
        }
    })
    
    $(document).on("blur", "#harga_satuan_barang", function(){
        let jumlahBarang = $("#jumlah_barang").val();
        let hargaBarang  = $(this).val();
        if(hargaBarang != ""){
            let totalHargaBarang = parseFloat(jumlahBarang) + parseFloat(hargaBarang);
            $("#harga_total_barang").val(totalHargaBarang).trigger("change");
        }
    })
    $(document).on("blur", "#jumlah_barang", function(){
        let jumlahBarang = $(this).val();
        let hargaBarang  = $("#harga_satuan_barang").val();
        if(hargaBarang != ""){
            let totalHargaBarang = parseFloat(jumlahBarang) + parseFloat(hargaBarang);
            $("#harga_total_barang").val(totalHargaBarang).trigger("change");
        }
    });
    $(document).on("change", "#kategori_barang", function(){
        let kategoriBarang = $(this).val();
        let kodeKategori = 0;
        if(kategoriBarang == "Bahan Baku"){
            kodeKategori = 1;
        }else if(kategoriBarang == "Bahan Penolong"){
            kodeKategori = 2;
        }else if(kategoriBarang == "Bahan Habis Pakai"){
            kodeKategori = 3;
        }else if(kategoriBarang == "Barang Dagangan"){
            kodeKategori = 4;
        }else if(kategoriBarang == "Mesin dan Peralatan"){
            kodeKategori = 5;
        }else if(kategoriBarang == "Barang dalam proses"){
            kodeKategori = 6;
        }else if(kategoriBarang == "Barang Jadi"){
            kodeKategori = 7;
        }else if(kategoriBarang == "Barang Reject & Scrapt"){
            kodeKategori = 8;
        }else if(kategoriBarang == "Eletrical"){
            kodeKategori = 9;
        }else if(kategoriBarang == "Electronic"){
            kodeKategori = 10;
        }else if(kategoriBarang == "Electronics"){
            kodeKategori = 11;
        }else if(kategoriBarang == "Furniture & Applience"){
            kodeKategori = 12;
        }else if(kategoriBarang == "Hospitality RB 18"){
            kodeKategori = 13;
        }else if(kategoriBarang == "Marshall Equipment"){
            kodeKategori = 14;
        }else if(kategoriBarang == "Others"){
            kodeKategori = 15;
        }else if(kategoriBarang == "Safety Equiptment"){
            kodeKategori = 16;
        }else if(kategoriBarang == "Vehicle & Machinery"){
            kodeKategori = 17;
        }else{
            kodeKategori = 0;
        }

        $("#nomor_kategori_barang").val(kodeKategori).trigger("change");
    });

    $(document).on("change", "#jenis_transaksi", function(){
        console.log("gjsa");
        let jenisTransaksi = $(this).val();
        if(jenisTransaksi == "y"){
            $("#transaksi_pemasukan").removeClass("hidden");
        }else{
            $("#transaksi_pemasukan").addClass("hidden");
            $("#nomor_daftar").val('').trigger("change");
            $("#tanggal_daftar").val('').trigger("change");
            $("#nomor_penerimaan_barang").val('').trigger("change");
            $("#tanggal_penerimaan_barang").val('').trigger("change");
            $("#nama_pengirim").val('').trigger("change");
            $("#nomor_dokumen").val('').trigger("change");
            $("#tanggal_dokumen").val('').trigger("change");

        }
    });
    
    $(document).on("blur", "#nomor_penerimaan_barang", function(){
        let nomorPengiriman = $(this).val();
        console.log(nomorPengiriman);
        
        $.ajax({
            url: "{{config('app.url') }}/hardware/cekNomorPengiriman/" + nomorPengiriman,
            headers: {
                "X-Requested-With": 'XMLHttpRequest',
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            }, 
            _token: "{{ csrf_token() }}",
            type : "GET",
            dataType : "json",
            success : function(data){
                if(data.status == 201){
                    $("#msg").text("Data Nomor Pengiriman Sudah Ada");
                }else{
                    $("#msg").text("");
                }
            }
        });
    });


    var transformed_oldvals={};

    function fetchCustomFields() {
        var oldvals = $('#custom_fields_content').find('input,select').serializeArray();
        for(var i in oldvals) {
            transformed_oldvals[oldvals[i].name]=oldvals[i].value;
        }

        var modelid = $('#model_select_id').val();
        if (modelid == '') {
            $('#custom_fields_content').html("");
        } else {

            $.ajax({
                type: 'GET',
                url: "{{ config('app.url') }}/models/" + modelid + "/custom_fields",
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                _token: "{{ csrf_token() }}",
                dataType: 'html',
                success: function (data) {
                    $('#custom_fields_content').html(data);
                    $('#custom_fields_content select').select2(); //enable select2 on any custom fields that are select-boxes
                    //now re-populate the custom fields based on the previously saved values
                    $('#custom_fields_content').find('input,select').each(function (index,elem) {
                        if(transformed_oldvals[elem.name]) {
                             {{-- If there already *is* is a previously-input 'transformed_oldvals' handy,
                                  overwrite with that previously-input value *IF* this is an edit of an existing item *OR*
                                  if there is no new default custom field value coming from the model --}}
                            if({{ $item->id ? 'true' : 'false' }} || $(elem).val() == '') {
                                $(elem).val(transformed_oldvals[elem.name]).trigger('change'); //the trigger is for select2-based objects, if we have any
                            }
                        }

                    });
                }
            });
        }
    }

    function user_add(status_id) {

        if (status_id != '') {
            $(".status_spinner").css("display", "inline");
            $.ajax({
                url: "{{config('app.url') }}/api/v1/statuslabels/" + status_id + "/deployable",
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $(".status_spinner").css("display", "none");
                    $("#selected_status_status").fadeIn();

                    if (data == true) {
                        $("#assignto_selector").show();
                        $("#assigned_user").show();

                        $("#selected_status_status").removeClass('text-danger');
                        $("#selected_status_status").removeClass('text-warning');
                        $("#selected_status_status").addClass('text-success');
                        $("#selected_status_status").html('<i class="fas fa-check"></i> {{ trans('admin/hardware/form.asset_deployable')}}');


                    } else {
                        $("#assignto_selector").hide();
                        $("#selected_status_status").removeClass('text-danger');
                        $("#selected_status_status").removeClass('text-success');
                        $("#selected_status_status").addClass('text-warning');
                        $("#selected_status_status").html('<i class="fas fa-exclamation-triangle"></i> {{ trans('admin/hardware/form.asset_not_deployable')}} ');
                    }
                }
            });
        }
    }


    $(function () {
        //grab custom fields for this model whenever model changes.
        $('#model_select_id').on("change", fetchCustomFields);

        //initialize assigned user/loc/asset based on statuslabel's statustype
        user_add($(".status_id option:selected").val());

        //whenever statuslabel changes, update assigned user/loc/asset
        $(".status_id").on("change", function () {
            user_add($(".status_id").val());
        });

    });


    // Add another asset tag + serial combination if the plus sign is clicked
    $(document).ready(function() {

        var max_fields      = 100; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var x               = 1; //initial text box count




        $(add_button).click(function(e){ //on add input button click

            e.preventDefault();

            var auto_tag        = $("#asset_tag").val().replace(/[^\d]/g, '');
            var box_html        = '';
			const zeroPad 		= (num, places) => String(num).padStart(places, '0');

            // Check that we haven't exceeded the max number of asset fields
            if (x < max_fields) {

                if (auto_tag!='') {
                     auto_tag = zeroPad(parseInt(auto_tag) + parseInt(x),auto_tag.length);
                } else {
                     auto_tag = '';
                }

                x++; //text box increment

                box_html += '<span class="fields_wrapper">';
                box_html += '<div class="form-group"><label for="asset_tag" class="col-md-3 control-label">{{ trans('admin/hardware/form.tag') }} ' + x + '</label>';
                box_html += '<div class="col-md-7 col-sm-12 required">';
                box_html += '<input type="text"  class="form-control" name="asset_tags[' + x + ']" value="{{ (($snipeSettings->auto_increment_prefix!='') && ($snipeSettings->auto_increment_assets=='1')) ? $snipeSettings->auto_increment_prefix : '' }}'+ auto_tag +'" data-validation="required">';
                box_html += '</div>';
                box_html += '<div class="col-md-2 col-sm-12">';
                box_html += '<a href="#" class="remove_field btn btn-default btn-sm"><i class="fas fa-minus"></i></a>';
                box_html += '</div>';
                box_html += '</div>';
                box_html += '</div>';
                box_html += '<div class="form-group"><label for="serial" class="col-md-3 control-label">{{ trans('admin/hardware/form.serial') }} ' + x + '</label>';
                box_html += '<div class="col-md-7 col-sm-12">';
                box_html += '<input type="text"  class="form-control" name="serials[' + x + ']">';
                box_html += '</div>';
                box_html += '</div>';
                box_html += '</span>';
                $(wrapper).append(box_html);

            // We have reached the maximum number of extra asset fields, so disable the button
            } else {
                $(".add_field_button").attr('disabled');
                $(".add_field_button").addClass('disabled');
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user clicks on remove text
            $(".add_field_button").removeAttr('disabled');
            $(".add_field_button").removeClass('disabled');
            e.preventDefault();
            //console.log(x);

            $(this).parent('div').parent('div').parent('span').remove();
            x--;
        });


        $('.expand').click(function(){
            id = $(this).attr('id');
            fields = $(this).text();
            if (txt == '+'){
                $(this).text('-');
            }
            else{
                $(this).text('+');
            }
            $("#"+id).toggle();

        });

        {{-- TODO: Clean up some of the duplication in here. Not too high of a priority since we only copied it once. --}}
        $("#optional_info").on("click",function(){
            $('#optional_details').fadeToggle(100);
            $('#optional_info_icon').toggleClass('fa-caret-right fa-caret-down');
            var optional_info_open = $('#optional_info_icon').hasClass('fa-caret-down');
            document.cookie = "optional_info_open="+optional_info_open+'; path=/';
        });

        $("#order_info").on("click",function(){
            $('#order_details').fadeToggle(100);
            $("#order_info_icon").toggleClass('fa-caret-right fa-caret-down');
            var order_info_open = $('#order_info_icon').hasClass('fa-caret-down');
            document.cookie = "order_info_open="+order_info_open+'; path=/';
        });

        var all_cookies = document.cookie.split(';')
        for(var i in all_cookies) {
            var trimmed_cookie = all_cookies[i].trim(' ')
            if (trimmed_cookie.startsWith('optional_info_open=')) {
                elems = all_cookies[i].split('=', 2)
                if (elems[1] == 'true') {
                    $('#optional_info').trigger('click')
                }
            }
            if (trimmed_cookie.startsWith('order_info_open=')) {
                elems = all_cookies[i].split('=', 2)
                if (elems[1] == 'true') {
                    $('#order_info').trigger('click')
                }
            }
        }

    });


$(document).ready(function () {
    // Ambil nilai dari data-selected
    var selectedCompany = $('#companiess').data('selected');
    console.log('Selected Company:', selectedCompany); // Debug nilai terpilih

    // Lakukan AJAX untuk mengambil data companies
    $.ajax({
        url: '/get-companiess',
        type: 'GET',
        success: function (data) {
            console.log('Companies Data:', data); // Debug data dari server
            
            // Kosongkan dropdown dan tambahkan opsi default
            $('#companiess').empty().append('<option value="">Pilih Company</option>');

            // Tambahkan opsi dari data ke dropdown
            data.forEach(function (company) {
                $('#companiess').append(
                    `<option value="${company.name}">${company.name}</option>`
                );
            });

            // Set nilai yang dipilih
            if (selectedCompany) {
                $('#companiess').val(selectedCompany); // Tetapkan nilai
                $('#companiess').trigger('change'); // Trigger event jika pakai Select2
            }
        },
        error: function () {
            alert('Gagal mengambil data companies.');
        },
    });
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


<script>
    // Owner
    $(document).ready(function () {
        // Toggle input status baru
        $('#tambahOwner').on('click', function () {
            $('#inputBaruWrapperOwner').slideToggle();
        });

        // Simpan Owner baru
        $('#simpanownerbaru').on('click', function () {
            let nama_owner = $('#ownerbaru').val().trim();

            if (nama_owner === '') {
                $('#error_ownerbaru').show();
                return;
            } else {
                $('#error_ownerbaru').hide();
            }

            $.ajax({
                url: '{{ route("ownerr.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    nama_owner: nama_owner,
                },
                success: function (response) {
                    // Tambahkan ke select box dan pilih otomatis
                    const option = new Option(response.nama_owner, response.id, true, true);
                    $('#nama_owner').append(option).trigger('change');

                    // Reset input
                    $('#ownerbaru').val('');
                    $('#inputBaruWrapperOwner').slideUp();
                },
                error: function (xhr) {
                    let msg = 'Gagal menyimpan Owner.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    alert(msg);
                }
            });
        });

        // Hapus status terpilih
        $('#hapusOwner').on('click', function () {
            let selectedOwner = $('#nama_owner').val();

            if (!selectedOwner) {
                alert('Silakan pilih Owner yang ingin dihapus.');
                return;
            }

            if (!confirm('Apakah kamu yakin ingin menghapus Owner ini?')) {return;}

            $.ajax({
                url: '{{ route("ownerr.destroy") }}',
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: selectedOwner
                },
                success: function () {
                    $('#nama_owner option[value="' + selectedOwner + '"]').remove();
                    if ($('#nama_owner option').length > 0) {
                        $('#nama_owner').prop('selectedIndex', 0).trigger('change');
                    } else {
                        // Jika tidak ada lagi option, kosongkan
                        $('#nama_owner').append('<option value="">(Tidak ada Owner)</option>').val('').trigger('change');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal menghapus Owner.');
                }
            });
        });
    });
</script>
<script>
    // Lokasi
    $(document).ready(function () {
        // Toggle input lokasi baru
        $('#tambahLokasi').on('click', function () {
            $('#inputBaruWrapperLokasi').slideToggle();
        });

        // Simpan status baru
        $('#simpanlokasibaru').on('click', function () {
            let namalokasi = $('#lokasibaru').val().trim();

            if (namalokasi === '') {
                $('#error_lokasibaru').show();
                return;
            } else {
                $('#error_lokasibaru').hide();
            }

            $.ajax({
                url: '{{ route("lokasi_pem.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    namalokasi: namalokasi,
                },
                success: function (response) {
                    // Tambahkan ke select box dan pilih otomatis
                    const option = new Option(response.namalokasi, response.id, true, true);
                    $('#namalokasi').append(option).trigger('change');

                    // Reset input
                    $('#lokasibaru').val('');
                    $('#inputBaruWrapperLokasi').slideUp();
                },
                error: function (xhr) {
                    let msg = 'Gagal menyimpan Lokasi.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    alert(msg);
                }
            });
        });

        // Hapus lokasi terpilih
        $('#hapusLokasi').on('click', function () {
            let selectedLokasi = $('#namalokasi').val();

            if (!selectedLokasi) {
                alert('Silakan pilih Lokasi yang ingin dihapus.');
                return;
            }

            if (!confirm('Apakah kamu yakin ingin menghapus Lokasi ini?')) {return;}

            $.ajax({
                url: '{{ route("lokasi_pem.destroy") }}',
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: selectedLokasi
                },
                success: function () {
                    $('#namalokasi option[value="' + selectedLokasi + '"]').remove();
                    if ($('#namalokasi option').length > 0) {
                        $('#namalokasi').prop('selectedIndex', 0).trigger('change');
                    } else {
                        // Jika tidak ada lagi option, kosongkan
                        $('#namalokasi').append('<option value="">(Tidak ada Lokasi)</option>').val('').trigger('change');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal menghapus Lokasi.');
                }
            });
        });
    });
</script>

<script>
    // Detail Lokasi
    $(document).ready(function () {
        // Toggle input status baru
        $('#tambahDetailLokasi').on('click', function () {
            $('#inputBaruWrapperdetail').slideToggle();
        });

        // Simpan status baru
        $('#simpanDetailLokasiBaru').on('click', function () {
            let detail_lokasi = $('#detaillokasibaru').val().trim();

            if (detail_lokasi === '') {
                $('#error_detaillokasibaru').show();
                return;
            } else {
                $('#error_detaillokasibaru').hide();
            }

            $.ajax({
                url: '{{ route("detail_lokasi_pem.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    detail_lokasi: detail_lokasi,
                },
                success: function (response) {
                    // Tambahkan ke select box dan pilih otomatis
                    const option = new Option(response.detail_lokasi, response.id, true, true);
                    $('#detail_lokasi').append(option).trigger('change');

                    // Reset input
                    $('#detaillokasibaru').val('');
                    $('#inputBaruWrapperdetail').slideUp();
                },
                error: function (xhr) {
                    let msg = 'Gagal menyimpan Detail Lokasi.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    alert(msg);
                }
            });
        });

        // Hapus Detail Lokasi terpilih
        $('#hapusDetailLokasi').on('click', function () {
            let selecteddetaillokasi = $('#detail_lokasi').val();

            if (!selecteddetaillokasi) {
                alert('Silakan pilih Detail Lokasi yang ingin dihapus.');
                return;
            }

            if (!confirm('Apakah kamu yakin ingin menghapus status ini?')) {return;}

            $.ajax({
                url: '{{ route("detail_lokasi_pem.destroy") }}',
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: selecteddetaillokasi
                },
                success: function () {
                    $('#detail_lokasi option[value="' + selecteddetaillokasi + '"]').remove();
                    if ($('#detail_lokasi option').length > 0) {
                        $('#detail_lokasi').prop('selectedIndex', 0).trigger('change');
                    } else {
                        // Jika tidak ada lagi option, kosongkan
                        $('#detail_lokasi').append('<option value="">(Tidak ada jenis)</option>').val('').trigger('change');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal menghapus Jenis Pengeluaran.');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#tambahKodeDokumen').on('click', function () {
            $('#inputBaruWrapper').slideToggle();
        });

        $('#simpanKodeDokumenBaru').on('click', function () {
            let kode = $('#kode_baru').val().trim();
            let label = $('#label_baru').val().trim();

            if (kode === '' || label === '') {
                alert('Mohon isi kedua kolom: kode dan label dokumen.');
                return;
            }

            // Tombol simpan input baru
            $.ajax({
                url: '{{ route("kode-dokumen.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    kode: kode,
                    label: label
                },
                success: function (response) {
                    // Tambahkan ke select dan pilih langsung
                    const option = new Option(response.label, response.kode, true, true);
                    $('#kode_dokumen').append(option).trigger('change');

                    // Reset form input
                    $('#kode_baru').val('');
                    $('#label_baru').val('');
                    $('#inputBaruWrapper').slideUp();
                },
                error: function () {
                    alert('Gagal menyimpan kode dokumen. Mungkin kode sudah ada?');
                }
            });
        });

        // Tombol hapus kode dokumen
        $('#hapusKodeDokumen').on('click', function () {
            let selectedKode = $('#kode_dokumen').val();

            if (!selectedKode) {
                alert('Silakan pilih kode yang ingin dihapus.');
                return;
            }

            if (!confirm('Apakah kamu yakin ingin menghapus kode ini?')) {
                return;
            }

            $.ajax({
                url: '{{ route("kode-dokumen.destroy") }}',
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    kode: selectedKode
                },
                success: function () {
                    // Hapus dari select
                    $('#kode_dokumen option[value="' + selectedKode + '"]').remove();
                    $('#kode_dokumen').val('').trigger('change');
                },
                error: function () {
                    alert('Gagal menghapus kode dokumen.');
                }
            });
        });
    });
</script>
@stop