@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Pemasukan') }}
@parent
@stop

@section('content')

<style>
  .input-group {
    padding-left: 0px !important;
  }
</style>

{{--  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif  --}}

<div class="row">
  <!-- left column -->
  <div class="col-md-7">
    <div class="box box-default">
      <form class="form-horizontal" method="post" action="" autocomplete="off" enctype="multipart/form-data">
        <div class="box-header with-border">
          <h2 class="box-title"> {{ trans('admin/hardware/form.tag') }} ( {{ $item->asset_tag }} )</h2>
        </div>
        <div class="box-body">
          {{csrf_field()}}
          @if ($item->company && $item->company->name)
          <!--<div class="form-group">-->
          <!--  {{ Form::label('model', trans('general.company'), array('class' => 'col-md-3 control-label')) }}-->
          <!--  <div class="col-md-8">-->
          <!--    <p class="form-control-static">-->
          <!--      {{ $item->company->name }}-->
          <!--    </p>-->
          <!--  </div>-->
          <!--</div>-->
          @endif

          <div class="form-group {{ $errors->has('nama_company') ? ' has-error' : '' }}">
            <label for="nama_company" class="col-md-3 control-label">Company</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="nama_company" aria-label="nama_company" id="nama_company"
                value="{{ old('nama_company', $item->ncompanies) }}" {!! (Helper::checkIfRequired($item, 'nama_company' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('nama_company', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('kode_barang') ? ' has-error' : '' }}">
            <label for="kode_barang" class="col-md-3 control-label">Kode Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="kode_barang" aria-label="kode_barang" id="kode_barang"
                value="{{ old('kode_barang', $item->asset_tag) }}" {!! (Helper::checkIfRequired($item, 'kode_barang' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('kode_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <!-- <div class="">
            <div class="">
              <input class="form-control" type="hidden" name="metode_pengadaan" aria-label="metode_pengadaan" id="metode_pengadaan"
                value="{{ old('metode_pengadaan', $item->metode_pengadaan) }}" {!! (Helper::checkIfRequired($item, 'metode_pengadaan' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('metode_pengadaan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div> -->

          <div class="-group">
            <div class="">
              <input class="form-control" type="hidden" name="site" aria-label="site" id="site"
                value="{{ old('site', $item->site) }}" {!! (Helper::checkIfRequired($item, 'site' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('site', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="">
            <div class="">
              <input class="form-control" type="hidden" name="event" aria-label="event" id="event"
                value="{{ old('event', $item->event) }}" {!! (Helper::checkIfRequired($item, 'event' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('event', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="">
            <div class="">
              <input class="form-control" type="hidden" name="status_pemasukan_mgpa" aria-label="status_pemasukan_mgpa" id="status_pemasukan_mgpa"
                value="{{ old('status_pemasukan_mgpa', $item->status_pemasukan_mgpa) }}" {!! (Helper::checkIfRequired($item, 'status_pemasukan_mgpa' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('status_pemasukan_mgpa', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('serial_barang') ? ' has-error' : '' }}">
            <label for="serial_barang" class="col-md-3 control-label">Serial Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="serial_barang" aria-label="serial_barang" id="serial_barang"
                value="{{ old('serial_barang', $item->serial_barang) }}" {!! (Helper::checkIfRequired($item, 'serial_barang' ))
                ? ' data-validation="required" required' : '' !!}  />
              {!! $errors->first('serial_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <!--<div class="form-group {{ $errors->has('owner') ? ' has-error' : '' }}">-->
          <!--    <label for="owner" class="col-md-3 control-label">Owner</label>-->
          <!--    <div class="col-md-7 col-sm-12">-->
          <!--        {!! $errors->first('owner', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
          <!--        <select name="owner" id="owner" class="form-control select2" aria-label="owner" data-selected="{{ old('owner', $item->owner) }}">-->
          <!--            <option value="">Pilih Owner</option>-->
          <!--        </select>-->
          <!--    </div>-->
          <!--</div>-->
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
          

          <!--<div class="form-group {{ $errors->has('lokasi_asset') ? ' has-error' : '' }}">-->
          <!--  <label for="lokasi_asset" class="col-md-3 control-label">Lokasi</label>-->
          <!--  <div class="col-md-7 col-sm-12">-->
          <!--    {!! $errors->first('lokasi_asset', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
          <!--    <select name="lokasi_asset" id="lokasi_asset" class="form-control select2" aria-label="lokasi_asset" data-selected="{{ old('lokasi_asset', $item->lokasi_asset) }}">-->
          <!--            <option value="">Pilih Lokasi</option>-->
          <!--        </select>-->
          <!--  </div>-->
          <!--</div>-->
          
          <div class="form-group {{ $errors->has('namalokasi') ? ' has-error' : '' }}">
              <label for="namalokasi" class="col-md-3 control-label">Lokasi</label>
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
    
          <!--<div class="form-group{{ $errors->has('detail_lokasi_asset') ? ' has-error' : '' }}">-->
          <!--    <label for="detail_lokasi_asset" class="col-md-3 control-label">Detail Lokasi</label>-->
          <!--    <div class="col-md-7 col-sm-12">-->
          <!--        <select name="detail_lokasi_asset" id="detail_lokasi_asset" class="form-control select2" aria-label="detail_lokasi_asset" data-selected="{{ old('detail_lokasi_asset', $item->detail_lokasi_asset) }}">-->
          <!--            <option value="">Pilih Detail Lokasi</option>-->
          <!--        </select>-->
          <!--        {!! $errors->first('detail_lokasi_asset', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
          <!--    </div>-->
          <!--</div>-->
          
          <div class="form-group {{ $errors->has('detail_lokasi') ? ' has-error' : '' }}">
                            <label for="detail_lokasi" class="col-md-3 control-label">Detail Lokasi</label>
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

          <!-- <div class="form-group {{ $errors->has('lokasi') ? ' has-error' : '' }}">
            <label for="lokasi" class="col-md-3 control-label">Lokasi</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="lokasi" aria-label="lokasi" id="lokasi" value="{{ old('lokasi', $item->lokasi) }}" {!!  (Helper::checkIfRequired($item, 'lokasi')) ? ' data-validation="required" required' : '' !!}  />
              {!! $errors->first('lokasi', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>
    
          <div class="form-group{{ $errors->has('detail_lokasi') ? ' has-error' : '' }}">
              <label for="detail_lokasi" class="col-md-3 control-label">Detail Lokasi</label>
              <div class="col-md-7 col-sm-12">
                  <textarea class="col-md-6 form-control" id="detail_lokasi" aria-label="detail_lokasi" name="detail_lokasi" style="min-width:100%;">{{ old('detail_lokasi', $item->detail_lokasi) }}</textarea>
                  {!! $errors->first('detail_lokasi', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
          </div> -->

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

          <div class="form-group {{ $errors->has('departemen') ? ' has-error' : '' }}">
            <label for="departemen" class="col-md-3 control-label">Departemen</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="departemen" aria-label="departemen" id="departemen" value="{{ old('departemen', $item->departemen) }}" {!! (Helper::checkIfRequired($item, 'departemen' )) ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('departemen', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          

          <div class="form-group {{ $errors->has('kategori_barang') ? ' has-error' : '' }}">
            <label for="kategori_barang" class="col-md-3 control-label">Kategori Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="kategori_barang" aria-label="kategori_barang"
                id="kategori_barang" value="{{ old('kategori_barang', $item->kategori_barang) }}" {!!
                (Helper::checkIfRequired($item, 'kategori_barang' )) ? ' data-validation="required" required' : '' !!}
                readonly />
                {!! $errors->first('kategori_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
                <input class="form-control" type="hidden" name="nomor_kategori_barang" aria-label="nomor_kategori_barang"
                id="nomor_kategori_barang" value="{{ old('nomor_kategori_barang', $item->nomor_kategori_barang) }}" {!!
                (Helper::checkIfRequired($item, 'nomor_kategori_barang' )) ? ' data-validation="required" required' : '' !!}
                readonly />
              {!! $errors->first('nomor_kategori_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('jumlah_barang') ? ' has-error' : '' }}">
            <label for="jumlah_barang" class="col-md-3 control-label">Jumlah Barang Sebelumnya</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="jumlah_barang" aria-label="jumlah_barang" id="jumlah_barang"
                value="{{ old('jumlah_barang', $item->jumlah_barang) }}" {!! (Helper::checkIfRequired($item, 'jumlah_barang' ))
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

          <div class="form-group {{ $errors->has('jumlah_barang_tambahan') ? ' has-error' : '' }}">
            <label for="jumlah_barang_tambahan" class="col-md-3 control-label">Jumlah Barang Tambahan</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="number" min="1" name="jumlah_barang_tambahan" placeholder="1"  aria-label="jumlah_barang_tambahan"
                id="jumlah_barang_tambahan" value="{{ old('jumlah_barang_tambahan', '') }}"  required />
              {!! $errors->first('jumlah_barang_tambahan', '<span class="alert-msg" aria-hidden="true"><i
                  class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
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
              <input class="form-control" type="text" name="harga_total_barang" aria-label="harga_total_barang"
                id="harga_total_barang" value="{{ old('harga_total_barang', $item->harga_total_barang) }}" {!!
                (Helper::checkIfRequired($item, 'harga_total_barang' )) ? ' data-validation="required" required' : ''
                !!} readonly />
              {!! $errors->first('harga_total_barang', '<span class="alert-msg" aria-hidden="true"><i
                  class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          {{--  @include ('partials.forms.edit.keterangan')  --}}

        <div class="form-group {{ $errors->has('nomor_daftar') ? ' has-error' : '' }}">
          <label for="nomor_daftar" class="col-md-3 control-label">Nomor Pendaftaran</label>
          <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="nomor_daftar" aria-label="nomor_daftar" maxlength="6" id="nomor_daftar" {!!
                (Helper::checkIfRequired($item, 'nomor_daftar' )) ? ' data-validation="required" required' : ''
                !!} value="{{ old('nomor_daftar', !empty($item->nomor_daftar) ? $item->nomor_daftar : '') }}" />
              {!! $errors->first('nomor_daftar', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
          </div>
        </div>
    
        <div class="form-group {{ $errors->has('tanggal_daftar') ? ' has-error' : '' }}">
            <label for="tanggal_daftar" class="col-md-3 control-label">{{ trans('Tanggal Pendaftaran') }}</label>
            <div class="col-md-8">
              <div class="input-group col-md-6">
                   <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                       <input type="text" class="form-control" placeholder="{{ trans('Tanggal Pendaftaran') }}" name="tanggal_daftar" id="tanggal_daftar" readonly value="{{  old('tanggal_daftar', !empty($item->tanggal_daftar) ? $item->tanggal_daftar : '') }}" style="background-color:inherit" required>
                       <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                  </div>
                  {!! $errors->first('tanggal_daftar', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('nomor_pemasukan') ? ' has-error' : '' }}">
            <label for="nomor_penerimaan_barang" class="col-md-3 control-label">Nomor Pemasukan Barang</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nomor_penerimaan_barang" aria-label="nomor_penerimaan_barang" id="nomor_penerimaan_barang" value="{{ old('nomor_penerimaan_barang', !empty($item->nomor_pemasukan) ? $item->nomor_pemasukan : '') }}" {!!  (Helper::checkIfRequired($item, 'nomor_pemasukan')) ? ' data-validation="required" required' : '' !!}  />
                {!! $errors->first('nomor_pemasukan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('tanggal_pemasukan') ? ' has-error' : '' }}">
            <label for="tanggal_penerimaan_barang" class="col-md-3 control-label">{{ trans('Tanggal Pemasukan Barang') }}</label>
            <div class="col-md-8">
              <div class="input-group col-md-6">
                   <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                       <input type="text" class="form-control" placeholder="{{ trans('Tanggal Penerimaan Barang') }}" name="tanggal_penerimaan_barang" id="tanggal_penerimaan_barang" readonly value="{{  old('tanggal_penerimaan_barang', !empty($item->tanggal_pemasukan) ? $item->tanggal_pemasukan : '') }}" {!! (Helper::checkIfRequired($item, 'tanggal_pemasukan' )) ? ' data-validation="required" required' : '' !!} style="background-color:inherit" required>
                       <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                  </div>
                  {!! $errors->first('tanggal_pemasukan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('nama_pengirim') ? ' has-error' : '' }}">
            <label for="nama_pengirim" class="col-md-3 control-label">Nama Pengirim Barang</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nama_pengirim" aria-label="nama_pengirim" id="nama_pengirim" value="{{ old('nama_pengirim', !empty($item->nama_pengirim) ? $item->nama_pengirim : 'PT BAKHTERA FREIGHT WORLWIDE') }}" {!!  (Helper::checkIfRequired($item, 'nama_pengirim')) ? ' data-validation="required" required' : '' !!}  />
                {!! $errors->first('nama_pengirim', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
    
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

                {{-- Input untuk kode baru --}}
                <!-- <div id="inputBaruWrapper" style="margin-top: 10px; display: none;">
                    <div style="display: flex; gap: 5px;">
                        <input type="text" name="kode_dokumen_baru" id="kode_dokumen_baru" class="form-control" placeholder="Masukkan Kode Dokumen Baru">
                        <button type="button" class="btn btn-secondary" id="simpanKodeDokumenBaru">
                            Simpan
                        </button>
                    </div>
                </div> -->

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
    
        <div class="form-group {{ $errors->has('nomor_dokumen_pabean') ? ' has-error' : '' }}">
            <label for="nomor_dokumen" class="col-md-3 control-label">Nomor Dokumen Pabean (HS-Code)</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nomor_dokumen" aria-label="nomor_dokumen"
                id="nomor_dokumen" value="{{ old('nomor_dokumen', !empty($item->nomor_dokumen_pabean) ? $item->nomor_dokumen_pabean : '') }}" {!! (Helper::checkIfRequired($item, 'nomor_dokumen_pabean' )) ? ' data-validation="required" required' : '' !!} />
                {!! $errors->first('nomor_dokumen_pabean', '<span class="alert-msg" aria-hidden="true"><i
                    class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('tanggal_dokumen_pabean') ? ' has-error' : '' }}">
            <label for="tanggal_dokumen" class="col-md-3 control-label">{{ trans('Tanggal Dokumen Pabean') }}</label>
            <div class="col-md-8">
              <div class="input-group col-md-6">
                   <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                       <input type="text" class="form-control" placeholder="{{ trans('Tanggal Dokumen') }}" name="tanggal_dokumen" id="tanggal_dokumen" readonly value="{{  old('tanggal_dokumen', !empty($item->tanggal_dokumen_pabean) ? $item->tanggal_dokumen_pabean : '') }}" style="background-color:inherit" required>
                       <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                  </div>
                  {!! $errors->first('tanggal_dokumen_pabean', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
            </div>
        </div>
        <!--<div class="form-group{{ $errors->has('keterangan_pemasukan') ? ' has-error' : '' }}">-->
        <!--    <label for="keterangan_pemasukan" class="col-md-3 control-label">{{ trans('Keterangan') }}</label>-->
        <!--    <div class="col-md-7 col-sm-12">-->
        <!--    {{ Form::select('keterangan_pemasukan', $keteranganPemasukan , old('keterangan_pemasukan', $item->keterangan_pemasukan), array('class'=>'select2 keterangan_pemasukan', 'style'=>'width:100%','id'=>'keterangan_pemasukan', 'aria-label'=>'keterangan_pemasukan', 'data-validation' => "required")) }}-->
        <!--    {!! $errors->first('keterangan_pemasukan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}-->
        <!--    </div>-->
        <!--</div>-->
        <div class="form-group {{ $errors->has('listketerangan') ? ' has-error' : '' }}">
            <label for="listketerangan" class="col-md-3 control-label">Keterangan</label>
            <div class="col-md-7 col-sm-11">

                {{-- Select + Tombol Tambah & Hapus --}}
                <div style="display: flex; gap: 5px; align-items: center;">
                    <div style="flex: 1;">
                        {{ Form::select('listketerangan', $listketerangan, old('listketerangan', $item->listketerangan ?? ''), [
                            'class' => 'form-control select2',
                            'style' => 'width:100%',
                            'id' => 'listketerangan',
                        ]) }}
                    </div>

                    {{-- Tombol Tambah --}}
                    <button type="button" class="btn btn-primary" id="tambahKeterangan" title="Tambah Keterangan Baru">
                        <i class="fas fa-plus"></i>
                    </button>

                    {{-- Tombol Hapus --}}
                    <button type="button" class="btn btn-danger" id="hapusKeterangan" title="Hapus Keterangan yang Dipilih">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>

                {{-- Input Status Baru --}}
                <div id="inputBaruWrapperKeterangan" style="margin-top: 10px; display: none;">
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <input type="text" name="keteranganbaru" id="keteranganbaru" class="form-control" placeholder="Keterangan (contoh: Bagus)">
                        <small id="error_keteranganbaru" class="text-danger" style="display:none;">Keterangan tidak boleh kosong.</small>

                        <div style="text-align: right;">
                            <button type="button" class="btn btn-secondary" id="simpanketeranganbaru">Simpan</button>
                        </div>
                    </div>
                </div>

                {{-- Error dari server untuk listketerangan --}}
                {!! $errors->first('listketerangan', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
            </div>
        </div>
        
        @csrf
        <div class="form-group{{ $errors->has('lampiran') ? ' has-error' : '' }}">
          <label for="lampiran" class="col-md-3 control-label">Lampiran Dokumen</label>
          <div class="col-md-7 col-sm-12">
            <input type="file" name="lampiran[]" id="lampiran" class="form-control" multiple accept=".pdf,.jpg,.jpeg,.png,.bmp" />
            <!--<input type="file" name="lampiran" id="lampiran" class="form-control" multiple accept=".pdf,.jpg,.jpeg,.png,.bmp" />-->
            {!! $errors->first('lampiran', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
            <div id="preview-area" class="row" style="margin-top: 10px;"></div>
          </div>
        </div>
        
        </div>
        <!--/.box-body-->
        <div class="box-footer">
          <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
          <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-check icon-white"
              aria-hidden="true"></i> {{ trans('general.save') }}</button>
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
    let jumlahBarang = $("#jumlah_barang_tambahan").val();
    let hargaBarang  = $(this).val();
    if(hargaBarang != ""){
        let totalHargaBarang = parseInt(jumlahBarang) * parseInt(hargaBarang);
        $("#harga_total_barang").val(totalHargaBarang).trigger("change");
    }
  })
  $(document).on("blur", "#jumlah_barang_tambahan", function(){
    let jumlahBarang = $(this).val();
    let hargaBarang  = $("#harga_satuan_barang").val();
    if(hargaBarang != ""){
      let totalHargaBarang = parseInt(jumlahBarang) * parseInt(hargaBarang);
      $("#harga_total_barang").val(totalHargaBarang).trigger("change");
      console.log(hargaBarang);
    }
  });


    $(document).ready(function () {
    // Ambil nilai yang dipilih dari data-selected
    var selectedowner = $('#owner').data('selected');
    console.log('Selected Owner:', selectedowner); // Debug nilai terpilih

    // Ambil kode barang otomatis saat halaman dimuat
    var kodeBarang = $("#kode_barang").val();
    // console.log('Kode Barang:', kodeBarang); // Debug kode_barang

    // Panggil AJAX untuk mengambil lokasi berdasarkan kode_barang
//     $.ajax({
//         url: 'public/get-barang-data',
//         type: 'GET',
//         data: { kode_barang: kodeBarang },
//         success: function (data) {
//             console.log('Owner Data:', data); // Debug data dari server
            
//             // Kosongkan dropdown lokasi_asset
//             $('#owner').empty();
//             $('#owner').append('<option value="">Pilih Lokasi</option>');

//             // Tambahkan lokasi ke dropdown
//             data.owners.forEach(function (owner) {
//                 $('#owner').append(
//                     `<option value="${owner}">${owner}</option>`
//                 );
//             });

//             // Set nilai yang dipilih jika ada
//             if (selectedowner) {
//                 $('#owner').val(selectedowner); // Tetapkan nilai
//                 $('#owner').trigger('change'); // Trigger jika pakai Select2
//             }
//         },
//         error: function () {
//             alert('Gagal mengambil data Lokasi Asset.');
//         }
//     });
// });



//     //Lokasi select
//     $(document).ready(function () {
//     // Ambil nilai yang dipilih dari data-selected
//     var selectedLokasi = $('#lokasi_asset').data('selected');
//     // console.log('Selected Lokasi:', selectedLokasi); // Debug nilai terpilih

//     // Ambil kode barang otomatis saat halaman dimuat
//     var kodeBarang = $("#kode_barang").val();
//     // console.log('Kode Barang:', kodeBarang); // Debug kode_barang

//     // Panggil AJAX untuk mengambil lokasi berdasarkan kode_barang
//     $.ajax({
//         url: '/public/get-barang-lokasi',
//         type: 'GET',
//         data: { kode_barang: kodeBarang },
//         success: function (data) {
//             // console.log('Lokasi Data:', data); // Debug data dari server
            
//             // Kosongkan dropdown lokasi_asset
//             $('#lokasi_asset').empty();
//             $('#lokasi_asset').append('<option value="">Pilih Lokasi</option>');

//             // Tambahkan lokasi ke dropdown
//             data.lokasis.forEach(function (lokasi_asset) {
//                 $('#lokasi_asset').append(
//                     `<option value="${lokasi_asset}">${lokasi_asset}</option>`
//                 );
//             });

//             // Set nilai yang dipilih jika ada
//             if (selectedLokasi) {
//                 $('#lokasi_asset').val(selectedLokasi); // Tetapkan nilai
//                 $('#lokasi_asset').trigger('change'); // Trigger jika pakai Select2
//             }
//         },
//         error: function () {
//             alert('Gagal mengambil data Lokasi Asset.');
//         }
//     });
// });


//     //Detail Lokasi select
//     $(document).ready(function () {
//     // Ambil nilai yang dipilih dari data-selected
//     var selecteddLokasi = $('#detail_lokasi_asset').data('selected');
//     // console.log('Selected DLokasi:', selecteddLokasi); // Debug nilai terpilih

//     // Ambil kode barang otomatis saat halaman dimuat
//     var kodeBarang = $("#kode_barang").val();
//     // console.log('Kode Barang:', kodeBarang); // Debug kode_barang

//     // Panggil AJAX untuk mengambil lokasi berdasarkan kode_barang
//     $.ajax({
//         url: '/public/get-barang-dlokasi',
//         type: 'GET',
//         data: { kode_barang: kodeBarang },
//         success: function (data) {
//             // console.log('DLokasi Data:', data); // Debug data dari server
            
//             // Kosongkan dropdown lokasi_asset
//             $('#detail_lokasi_asset').empty();
//             $('#detail_lokasi_asset').append('<option value="">Pilih Lokasi</option>');

//             // Tambahkan lokasi ke dropdown
//             data.detaillokasis.forEach(function (detail_lokasi_asset) {
//                 $('#detail_lokasi_asset').append(
//                     `<option value="${detail_lokasi_asset}">${detail_lokasi_asset}</option>`
//                 );
//             });

//             // Set nilai yang dipilih jika ada
//             if (selecteddLokasi) {
//                 $('#detail_lokasi_asset').val(selecteddLokasi); // Tetapkan nilai
//                 $('#detail_lokasi_asset').trigger('change'); // Trigger jika pakai Select2
//             }
//         },
//         error: function () {
//             alert('Gagal mengambil detail Lokasi Asset.');
//         }
//     });
// });

    
    
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
    // Keterangan
    $(document).ready(function () {
        // Toggle input status baru
        $('#tambahKeterangan').on('click', function () {
            $('#inputBaruWrapperKeterangan').slideToggle();
        });

        // Simpan status baru
        $('#simpanketeranganbaru').on('click', function () {
            let listketerangan = $('#keteranganbaru').val().trim();

            if (listketerangan === '') {
                $('#error_keteranganbaru').show();
                return;
            } else {
                $('#error_keteranganbaru').hide();
            }

            $.ajax({
                url: '{{ route("keterangan.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    listketerangan: listketerangan,
                },
                success: function (response) {
                    // Tambahkan ke select box dan pilih otomatis
                    const option = new Option(response.listketerangan, response.id, true, true);
                    $('#listketerangan').append(option).trigger('change');

                    // Reset input
                    $('#keteranganbaru').val('');
                    $('#inputBaruWrapperKeterangan').slideUp();
                },
                error: function (xhr) {
                    let msg = 'Gagal menyimpan Keterangan.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    alert(msg);
                }
            });
        });

        // Hapus Keterangan terpilih
        $('#hapusKeterangan').on('click', function () {
            let selectedKeterangan = $('#listketerangan').val();

            if (!selectedKeterangan) {
                alert('Silakan pilih Keterangan yang ingin dihapus.');
                return;
            }

            if (!confirm('Apakah kamu yakin ingin menghapus keterangan ini?')) {return;}

            $.ajax({
                url: '{{ route("keterangan.destroy") }}',
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: selectedKeterangan
                },
                success: function () {
                    $('#listketerangan option[value="' + selectedKeterangan + '"]').remove();
                    if ($('#listketerangan option').length > 0) {
                        $('#listketerangan').prop('selectedIndex', 0).trigger('change');
                    } else {
                        // Jika tidak ada lagi option, kosongkan
                        $('#listketerangan').append('<option value="">(Tidak ada Keterangan)</option>').val('').trigger('change');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal menghapus Keterangan.');
                }
            });
        });
    });
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
  @stop
{{-- @section('moar_scripts')
  @include('partials/assets-assigned')
@stop --}}