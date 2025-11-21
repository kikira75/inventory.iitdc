@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Edit Data Adjusment') }}
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
      <form class="form-horizontal" method="post" action="{{ route('adjusment/update') }}" autocomplete="off" enctype="multipart/form-data">
        <div class="box-header with-border">
          <h2 class="box-title"> {{ trans('admin/hardware/form.tag') }} ( {{ $item->asset_tag }} )</h2>
        </div>
        <div class="box-body">
          {{csrf_field()}}
          <input type="hidden" name="id" value="{{$item->id}}">
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

          <div class="form-group {{ $errors->has('kode_barang') ? ' has-error' : '' }}">
            <label for="kode_barang" class="col-md-3 control-label">Kode barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="kode_barang" aria-label="kode_barang" id="kode_barang"
                value="{{ old('kode_barang', $item->kode_barang) }}" {!! (Helper::checkIfRequired($item, 'kode_barang' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('kode_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('nama_barang') ? ' has-error' : '' }}">
            <label for="nama_barang" class="col-md-3 control-label">Nama Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="nama_barang" aria-label="nama_barang" id="nama_barang"
                value="{{ old('nama_barang', $item->nama_barang) }}" {!! (Helper::checkIfRequired($item, 'nama_barang' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('nama_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
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
                value="{{ old('pemasukan', $item->jumlah_pemasukan_barang) }}" {!! (Helper::checkIfRequired($item, 'pemasukan' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('pemasukan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('pengeluaran') ? ' has-error' : '' }}">
            <label for="pengeluaran" class="col-md-3 control-label">Jumlah Pengeluaran</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="pengeluaran" aria-label="pengeluaran" id="pengeluaran"
                value="{{ old('pengeluaran', $item->jumlah_pengeluaran_barang) }}" {!! (Helper::checkIfRequired($item, 'pengeluaran' ))
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
                  (Helper::checkIfRequired($item, 'nomor_dokumen_kegiatan' )) ? ' data-validation="required" required' : ''
                  !!} value="{{ old('nomor_dokumen_kegiatan', !empty($item->nomor_dokumen_kegiatan) ? $item->nomor_dokumen_kegiatan : '') }}" />
                {!! $errors->first('nomor_dokumen_kegiatan', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('tanggal_pelaksanaan') ? ' has-error' : '' }}">
            {{ Form::label('tanggal_pelaksanaan', trans('Tanggal Pelaksanaan'), array('class' =>'col-md-3 control-label')) }}
            <div class="col-md-8">
                <div class="input-group date col-md-7" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-end-date="0d" data-date-clear-btn="true">
                    <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan', $item->tanggal_pelaksanaan) }}">
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
                  !!} value="{{ old('nama_entitas_transaksi', !empty($item->nama_entitas_transaksi) ? $item->nama_entitas_transaksi : '') }}" />
                {!! $errors->first('nama_entitas_transaksi', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('jumlah_barang_adjusment') ? ' has-error' : '' }}">
            <label for="jumlah_barang_adjusment" class="col-md-3 control-label">Jumlah Barang Adjust</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="jumlah_barang_adjusment" aria-label="jumlah_barang_adjusment"
                id="jumlah_barang_adjusment" value="{{ old('jumlah_barang_adjusment', $item->penyesuaian) }}" {!!
                (Helper::checkIfRequired($item, 'jumlah_barang_adjusment' )) ? ' data-validation="required" required' : ''
                !!} />
              {!! $errors->first('jumlah_barang_adjusment', '<span class="alert-msg" aria-hidden="true"><i
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
                id="harga_total_barang" value="{{ old('harga_total_barang', $item->harga_total_barang) }}" {!!
                (Helper::checkIfRequired($item, 'harga_total_barang' )) ? ' data-validation="required" required' : ''
                !!} readonly />
              {!! $errors->first('harga_total_barang', '<span class="alert-msg" aria-hidden="true"><i
                  class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          @include ('partials.forms.edit.keterangan')

          <div class="form-group {{ $errors->has('kode_dokumen') ? ' has-error' : '' }}">
            <label for="kode_dokumen" class="col-md-3 control-label">{{ trans('Kode Dokumen') }}</label>
            <div class="col-md-7 col-sm-11">
              {{ Form::select('kode_dokumen', $kodeDokumen , old('kode_dokumen', $item->kode_dokumen), array('class'=>'select2
              kode_dokumen', 'style'=>'width:100%','id'=>'status_select_id', 'aria-label'=>'kode_dokumen',
              'data-validation' => "required")) }}
              {!! $errors->first('kode_dokumen', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('nomor_dokumen') ? ' has-error' : '' }}">
            <label for="nomor_dokumen" class="col-md-3 control-label">Nomor Dokumen</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="nomor_dokumen" aria-label="nomor_dokumen"
                id="nomor_dokumen" value="{{ old('name', $item->nomor_dokumen) }}" {!!
                (Helper::checkIfRequired($item, 'nomor_dokumen' )) ? ' data-validation="required" required'
                : '' !!} />
              {!! $errors->first('nomor_dokumen', '<span class="alert-msg" aria-hidden="true"><i
                  class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <!-- Purchase Date -->
        <div class="form-group {{ $errors->has('tanggal_dokumen') ? ' has-error' : '' }}">
            {{ Form::label('tanggal_dokumen', trans('Tanggal Dokumen'), array('class' =>'col-md-3 control-label')) }}
            <div class="col-md-8">
                <div class="input-group date col-md-7" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-end-date="0d" data-date-clear-btn="true">
                    <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="tanggal_dokumen" id="tanggal_dokumen" value="{{ old('tanggal_dokumen', $item->tanggal_dokumen) }}">
                    <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                </div>
                {!! $errors->first('tanggal_dokumen', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                        aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
        
        <div class="form-group">
                <label for="lampiran" class="col-md-3 control-label">Lampiran saat ini</label>
                <div class="col-md-7 col-sm-12">
                  @php
                      $lampiranList = explode(',', $item->lampiran ?? '');
                  @endphp
                
                  @if(count($lampiranList))
                      @foreach($lampiranList as $index => $lampiran)
                          <div style="margin-bottom: 5px;">
                              <a href="{{ asset($lampiran) }}" target="_blank">{{ basename($lampiran) }}</a>
                              <button type="submit"
                                      formaction="{{ route('adjusment.lampiran.delete', ['id' => $item->id, 'index' => $index]) }}"
                                      formmethod="POST"
                                      onclick="return confirm('Yakin hapus file ini?')"
                                      style="color: red; border: none; background: transparent;">
                                  ❌
                              </button>
                          </div>
                      @endforeach
                  @else
                      <div class="text-muted">Tidak ada lampiran</div>
                  @endif  
                </div>
            </div>
              
            
            <div class="form-group{{ $errors->has('lampiran') ? ' has-error' : '' }}">
                <label for="lampiran" class="col-md-3 control-label">Tambah Lampiran</label>
                <div class="col-md-7 col-sm-12">
                    <input type="file" name="lampiran[]" id="lampiran" class="form-control" multiple
                        accept=".pdf,.jpg,.jpeg,.png,.bmp" />
                    {!! $errors->first('lampiran', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
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
  @stop