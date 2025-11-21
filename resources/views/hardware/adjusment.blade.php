@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Adjusment') }}
@parent
@stop

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
      <form class="form-horizontal" method="post" action="" autocomplete="off" enctype="multipart/form-data">
        <div class="box-header with-border">
          <h2 class="box-title"> {{ trans('admin/hardware/form.tag') }} ( {{ $item->asset_tag }} )</h2>
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

          <div class="form-group {{ $errors->has('asset_tag') ? ' has-error' : '' }}">
            <label for="asset_tag" class="col-md-3 control-label">Kode Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="asset_tag" aria-label="asset_tag" id="asset_tag"
                value="{{ old('asset_tag', $item->asset_tag) }}" {!! (Helper::checkIfRequired($item, 'asset_tag' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('asset_tag', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-3 control-label">Namma Barang</label>
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
              <input class="form-control" type="text" name="departemen" aria-label="departemen" id="departemen"
                value="{{ old('departemen', $item->departemen) }}" {!! (Helper::checkIfRequired($item, 'departemen' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('departemen', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-3 control-label">Namma Barang</label>
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
                id="kategori_barang" value="{{ old('kategori_barang', $item->kategori_barang) }}" {!!
                (Helper::checkIfRequired($item, 'kategori_barang' )) ? ' data-validation="required" required' : '' !!}
                readonly />
                <input class="form-control" type="hidden" name="nomor_kategori_barang" aria-label="nomor_kategori_barang" id="nomor_kategori_barang" value="{{ old('nomor_kategori_barang', $item->nomor_kategori_barang) }}" {!! (Helper::checkIfRequired($item, 'nomor_kategori_barang' )) ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('kategori_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('jumlah_barang_seb') ? ' has-error' : '' }}">
            <label for="jumlah_barang" class="col-md-3 control-label">Jumlah Barang Sebelumnya</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="jumlah_barang" aria-label="jumlah_barang" id="jumlah_barang"
                value="{{ old('jumlah_barang', $item->jumlah_barang) }}" {!! (Helper::checkIfRequired($item, 'jumlah_barang_seb' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('jumlah_barang_seb', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('satuan_barang') ? ' has-error' : '' }}">
            <label for="satuan_barang" class="col-md-3 control-label">Satuan Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="satuan_barang" aria-label="satuan_barang" id="satuan_barang"
                value="{{ old('satuan_barang', $item->satuan_barang) }}" {!! (Helper::checkIfRequired($item, 'satuan_barang' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('satuan_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>
          

          <div class="form-group {{ $errors->has('saldo_awal') ? ' has-error' : '' }}">
            <label for="saldo_awal" class="col-md-3 control-label">Saldo Awal</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="saldo_awal" aria-label="saldo_awal" id="saldo_awal"
                value="{{ old('saldo_awal', $item->saldo_awal) }}" {!! (Helper::checkIfRequired($item, 'saldo_awal' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('saldo_awal', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('pemasukan') ? ' has-error' : '' }}">
            <label for="pemasukan" class="col-md-3 control-label">Jumlah Pemasukan</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="pemasukan" aria-label="pemasukan" id="pemasukan"
                value="{{ old('pemasukan', $item->pemasukan) }}" {!! (Helper::checkIfRequired($item, 'pemasukan' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('pemasukan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('pengeluaran') ? ' has-error' : '' }}">
            <label for="pengeluaran" class="col-md-3 control-label">Jumlah Pengeluaran</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="pengeluaran" aria-label="pengeluaran" id="pengeluaran"
                value="{{ old('pengeluaran', $item->pengeluaran) }}" {!! (Helper::checkIfRequired($item, 'pengeluaran' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('pengeluaran', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('saldo_buku') ? ' has-error' : '' }}">
            <label for="saldo_buku" class="col-md-3 control-label">Saldo Buku</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="saldo_buku" aria-label="saldo_buku" id="saldo_buku"
                value="{{ old('saldo_buku', $item->saldo_buku) }}" {!! (Helper::checkIfRequired($item, 'saldo_buku' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('saldo_buku', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>
          <div class="form-group {{ $errors->has('stock_opname') ? ' has-error' : '' }}">
            <label for="stock_opname" class="col-md-3 control-label">Stock Opname</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="stock_opname" aria-label="stock_opname" id="stock_opname"
                value="{{ old('stock_opname', $item->stock_opname) }}" {!! (Helper::checkIfRequired($item, 'stock_opname' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('stock_opname', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('selisih') ? ' has-error' : '' }}">
            <label for="selisih" class="col-md-3 control-label">Selisih</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="selisih" aria-label="selisih" id="selisih"
                value="{{ old('selisih', $item->selisih) }}" {!! (Helper::checkIfRequired($item, 'selisih' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('selisih', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>
          
          <div class="form-group {{ $errors->has('hasil_pencacahan') ? ' has-error' : '' }}">
            <label for="hasil_pencacahan" class="col-md-3 control-label">Hasil Pencacahan</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="hasil_pencacahan" aria-label="hasil_pencacahan" id="hasil_pencacahan"
                value="{{ old('hasil_pencacahan', $item->hasil_pencacahan) }}" {!! (Helper::checkIfRequired($item, 'hasil_pencacahan' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('hasil_pencacahan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('jumlah_selisih') ? ' has-error' : '' }}">
            <label for="jumlah_selisih" class="col-md-3 control-label">Jumlah Selisih</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="jumlah_selisih" aria-label="jumlah_selisih" id="jumlah_selisih"
                value="{{ old('jumlah_selisih', $item->jumlah_selisih) }}" {!! (Helper::checkIfRequired($item, 'jumlah_selisih' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('jumlah_selisih', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('nomor_dokumen_kegiatan') ? ' has-error' : '' }}">
            <label for="nomor_dokumen_kegiatan" class="col-md-3 control-label">Nomor Dokumen Kegiatan</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nomor_dokumen_kegiatan" aria-label="nomor_dokumen_kegiatan" id="nomor_dokumen_kegiatan" {!!
                  (Helper::checkIfRequired($item, 'nomor_dokumen_kegiatan' )) ? ' data-validation="required" required' : '' !!} value="{{ old('nomor_dokumen_kegiatan', !empty($item->Pemasukan->nomor_dokumen_kegiatan) ? $item->Pemasukan->nomor_dokumen_kegiatan : '') }}" required />
                {!! $errors->first('nomor_dokumen_kegiatan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('tanggal_pelaksanaan') ? ' has-error' : '' }}">
            {{ Form::label('tanggal_pelaksanaan', trans('Tanggal Pelaksanaan'), array('class' =>'col-md-3 control-label')) }}
            <div class="col-md-8">
                <div class="input-group date col-md-7" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-end-date="0d" data-date-clear-btn="true">
                    <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan', '') }}">
                    <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                </div>
                {!! $errors->first('tanggal_pelaksanaan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                        aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('nama_entitas_transaksi') ? ' has-error' : '' }}">
            <label for="nama_entitas_transaksi" class="col-md-3 control-label">Nama Entitas Transaksi</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nama_entitas_transaksi" aria-label="nama_entitas_transaksi" id="nama_entitas_transaksi" {!!
                  (Helper::checkIfRequired($item, 'nama_entitas_transaksi' )) ? ' data-validation="required" required' : ''
                  !!} value="{{ old('nama_entitas_transaksi', !empty($item->Pemasukan->nama_entitas_transaksi) ? $item->Pemasukan->nama_entitas_transaksi : '') }}" />
                {!! $errors->first('nama_entitas_transaksi', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('jumlah_barang') ? ' has-error' : '' }}">
            <label for="jumlah_barang_adjusment" class="col-md-3 control-label">Jumlah Barang Adjust</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="number" name="jumlah_barang_adjusment" aria-label="jumlah_barang_adjusment"
                id="jumlah_barang_adjusment" value="{{ old('jumlah_barang_adjusment', '') }}" {!!
                (Helper::checkIfRequired($item, 'jumlah_barang' )) ? ' data-validation="required" required' : ''
                !!} />
              {!! $errors->first('jumlah_barang', '<span class="alert-msg" aria-hidden="true"><i
                  class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('harga_satuan_barang') ? ' has-error' : '' }}">
            <label for="harga_satuan_barang" class="col-md-3 control-label">Harga Satuan Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="harga_satuan_barang" aria-label="harga_satuan_barang"
                id="harga_satuan_barang" value="{{ old('harga_satuan_barang', $item->harga_satuan_barang) }}" readonly/>
              {!! $errors->first('harga_satuan_barang', '<span class="alert-msg" aria-hidden="true"><i
                  class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>
          
          <div class="form-group {{ $errors->has('harga_total_barang') ? ' has-error' : '' }}">
            <label for="harga_total_barang" class="col-md-3 control-label">Harga Total Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="harga_total_barang" aria-label="harga_total_barang"
                id="harga_total_barang" value="{{ old('harga_total_barang', '') }}" {!!
                (Helper::checkIfRequired($item, 'harga_total_barang' )) ? ' data-validation="required" required' : ''
                !!} readonly />
              {!! $errors->first('harga_total_barang', '<span class="alert-msg" aria-hidden="true"><i
                  class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
            <label for="keterangan" class="col-md-3 control-label">{{ trans('Keterangan') }}</label>
            <div class="col-md-7 col-sm-12">
                <textarea class="col-md-6 form-control" id="keterangan" aria-label="keterangan" name="keterangan" style="min-width:100%;">{{ old('keterangan', '') }}</textarea>
                {!! $errors->first('keterangan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
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

          <div class="form-group {{ $errors->has('nomor_dokumen') ? ' has-error' : '' }}">
            <label for="nomor_dokumen" class="col-md-3 control-label">Nomor Dokumen Pabean (HS-Code)</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="nomor_dokumen" aria-label="nomor_dokumen"
                id="nomor_dokumen" value="{{ old('nomor_dokumen', '') }}" {!!
                (Helper::checkIfRequired($item, 'nomor_dokumen' )) ? ' data-validation="required" required'
                : '' !!} />
              {!! $errors->first('nomor_dokumen', '<span class="alert-msg" aria-hidden="true"><i
                  class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

            @include ('partials.forms.edit.tanggal_dokumen')
            
            @csrf
            <div class="form-group{{ $errors->has('lampiran') ? ' has-error' : '' }}">
                <label for="lampiran" class="col-md-3 control-label">Lampiran Dokumen</label>
                <div class="col-md-7 col-sm-12">
                    <input type="file" name="lampiran[]" id="lampiran" class="form-control" multiple accept=".pdf,.jpg,.jpeg,.png,.bmp" />
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
    let jumlahBarang = $("#jumlah_barang_adjusment").val();
    let hargaBarang  = $(this).val();
    if(hargaBarang != ""){
        let totalHargaBarang = parseInt(jumlahBarang) * parseInt(hargaBarang);
        $("#harga_total_barang").val(totalHargaBarang).trigger("change");
    }
  })
  $(document).on("blur", "#jumlah_barang_adjusment", function(){
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