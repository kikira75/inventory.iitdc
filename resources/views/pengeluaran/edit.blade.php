{{--  @extends('layouts/edit-form', [
    'createText' => trans('Tambah Data'),
    'updateText' => trans('Edit Data'),
    'topSubmit' => true,
    'formAction' => ($item->id) ? route('pemasukan.update', ['pemasukan' => $item->id]) : route('pemasukan.store'),
])  --}}

@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Edit Pengeluaran ') }}
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
      <form class="form-horizontal" method="post" action="{{ route('pengeluaran.update') }}" autocomplete="off" enctype="multipart/form-data">
        <div class="box-header with-border">
          <h2 class="box-title"> {{ trans('admin/hardware/form.tag') }} ( {{ $item->nama_barang }} )</h2>
        </div>
        <div class="box-body">
          {{csrf_field()}}
          
          <input type="hidden" name="id" value="{{$item->id}}">
          <div class="form-group {{ $errors->has('kode_barang') ? ' has-error' : '' }}">
            <label for="kode_barang" class="col-md-3 control-label">Kode Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="kode_barang" aria-label="kode_barang" id="kode_barang"
                value="{{ old('kode_barang', $item->kode_barang) }}" {!! (Helper::checkIfRequired($item, 'kode_barang' ))
                ? ' data-validation="required" required' : '' !!} readonly />
              {!! $errors->first('kode_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-3 control-label">Nama Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="name" aria-label="name" id="name"
                value="{{ old('name', $item->nama_barang) }}" {!! (Helper::checkIfRequired($item, 'name' ))
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
                <input class="form-control" type="hidden" name="nomor_kategori_barang" aria-label="nomor_kategori_barang"
                id="nomor_kategori_barang" value="{{ old('nomor_kategori_barang', $item->nomor_kategori_barang) }}" {!!
                (Helper::checkIfRequired($item, 'nomor_kategori_barang' )) ? ' data-validation="required" required' : '' !!}
                readonly />
              {!! $errors->first('kategori_barang', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                  aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('jumlah_barang') ? ' has-error' : '' }}">
            <label for="jumlah_barang_pengeluaran" class="col-md-3 control-label">Jumlah Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="jumlah_barang_pengeluaran" aria-label="jumlah_barang_pengeluaran"
                id="jumlah_barang_pengeluaran" value="{{ old('jumlah_barang_pengeluaran', !empty($item->jumlah_barang) ? $item->jumlah_barang : '') }}"  {!!
                (Helper::checkIfRequired($item, 'jumlah_barang' )) ? ' data-validation="required" required' : ''
                !!} />
                <input class="form-control" type="hidden" name="jumlah_barang_pengeluaran_seb" aria-label="jumlah_barang_pengeluaran_seb" id="jumlah_barang_pengeluaran_seb" value="{{ old('jumlah_barang_pengeluaran_seb', !empty($item->jumlah_barang) ? $item->jumlah_barang : '') }}" />

              {!! $errors->first('jumlah_barang', '<span class="alert-msg" aria-hidden="true"><i
                  class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group {{ $errors->has('satuan_barang') ? ' has-error' : '' }}">
            <label for="satuan_barang" class="col-md-3 control-label">Satuan Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="satuan_barang" aria-label="satuan_barang"
                id="satuan_barang" value="{{ old('satuan_barang', !empty($item->satuan_barang) ? $item->satuan_barang : '') }}"  {!!
                (Helper::checkIfRequired($item, 'satuan_barang' )) ? ' data-validation="required" required' : ''
                !!} readonly/>
              {!! $errors->first('satuan_barang', '<span class="alert-msg" aria-hidden="true"><i
                  class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>
          
          <div class="form-group {{ $errors->has('harga_satuan_barang') ? ' has-error' : '' }}">
            <label for="harga_satuan_barang" class="col-md-3 control-label">Harga Satuan Barang</label>
            <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="harga_satuan_barang" aria-label="harga_satuan_barang"
                id="harga_satuan_barang" value="{{ old('harga_satuan_barang', $item->harga_satuan_barang) }}" {!!
                (Helper::checkIfRequired($item, 'harga_satuan_barang' )) ? ' data-validation="required" required' : ''
                !!} readonly/>
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

          {{--  @include ('partials.forms.edit.keterangan')  --}}

          @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.user'), 'fieldname' => 'user_id', 'required'=>'true'])

        <div class="form-group {{ $errors->has('nama_jenis') ? ' has-error' : '' }}">
                        <label for="nama_jenis" class="col-md-3 control-label">Jenis Pengeluaran</label>
                        <div class="col-md-7 col-sm-11">

                            {{-- Select + Tombol Tambah & Hapus --}}
                            <div style="display: flex; gap: 5px; align-items: center;">
                                <div style="flex: 1;">
                                    {{ Form::select('nama_jenis', $editlistjenisPeng, old('nama_jenis', $item->jenis_pengeluaran ?? ''), [
                                        'class' => 'form-control select2',
                                        'style' => 'width:100%',
                                        'id' => 'nama_jenis',
                                    ]) }}
                                </div>

                                {{-- Tombol Tambah --}}
                                <button type="button" class="btn btn-primary" id="tambahJenis" title="Tambah Jenis Baru">
                                    <i class="fas fa-plus"></i>
                                </button>

                                {{-- Tombol Hapus --}}
                                <button type="button" class="btn btn-danger" id="hapusJenis" title="Hapus Jenis yang Dipilih">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                            

                            {{-- Input Jenis Baru --}}
                            <div id="inputBaruWrapperJenis" style="margin-top: 10px; display: none;">
                                <div style="display: flex; flex-direction: column; gap: 5px;">
                                    <input type="text" name="jenisBaru" id="jenisBaru" class="form-control" placeholder="Jenis (contoh: Dispose)">
                                    <small id="error_jenisBaru" class="text-danger" style="display:none;">Jenis tidak boleh kosong.</small>

                                    <div style="text-align: right;">
                                        <button type="button" class="btn btn-secondary" id="simpanjenisBaru">Simpan</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Error dari server untuk nama_jenis --}}
                            {!! $errors->first('nama_jenis', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
                        </div>
                    </div>

        <div class="form-group {{ $errors->has('nama_statusp') ? ' has-error' : '' }}">
                        <label for="nama_statusp" class="col-md-3 control-label">Status</label>
                        <div class="col-md-7 col-sm-11">

                            {{-- Select + Tombol Tambah & Hapus --}}
                            <div style="display: flex; gap: 5px; align-items: center;">
                                <div style="flex: 1;">
                                    {{ Form::select('nama_statusp', $editlistStatusp, old('nama_statusp', $item->statuspeng ?? ''), [
                                        'class' => 'form-control select2',
                                        'style' => 'width:100%',
                                        'id' => 'nama_statusp',
                                    ]) }}
                                </div>

                                {{-- Tombol Tambah --}}
                                <button type="button" class="btn btn-primary" id="tambahStatusp" title="Tambah Status Baru">
                                    <i class="fas fa-plus"></i>
                                </button>

                                {{-- Tombol Hapus --}}
                                <button type="button" class="btn btn-danger" id="hapusStatusp" title="Hapus Status yang Dipilih">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>

                            {{-- Input Status Baru --}}
                            <div id="inputBaruWrapper2" style="margin-top: 10px; display: none;">
                                <div style="display: flex; flex-direction: column; gap: 5px;">
                                    <input type="text" name="statusp_baru" id="statusp_baru" class="form-control" placeholder="Status (contoh: Pending)">
                                    <small id="error_statusp_baru" class="text-danger" style="display:none;">Status tidak boleh kosong.</small>

                                    <div style="text-align: right;">
                                        <button type="button" class="btn btn-secondary" id="simpanStatuspBaru">Simpan</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Error dari server untuk nama_statusp --}}
                            {!! $errors->first('nama_statusp', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('nomor_daftar') ? ' has-error' : '' }}">
          <label for="nomor_daftar" class="col-md-3 control-label">Nomor Daftar</label>
          <div class="col-md-7 col-sm-12">
              <input class="form-control" type="text" name="nomor_daftar" aria-label="nomor_daftar" id="nomor_daftar" {!!
                (Helper::checkIfRequired($item, 'nomor_daftar' )) ? ' data-validation="required" required' : ''
                !!} value="{{ old('name', !empty($item->nomor_daftar) ? $item->nomor_daftar : '') }}" />
              {!! $errors->first('nomor_daftar', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
          </div>
        </div>
    
        <div class="form-group {{ $errors->has('tanggal_daftar') ? ' has-error' : '' }}">
            <label for="tanggal_daftar" class="col-md-3 control-label">{{ trans('Tanggal Daftar') }}</label>
            <div class="col-md-8">
              <div class="input-group col-md-6">
                   <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                       <input type="text" class="form-control" placeholder="{{ trans('tanggal daftar') }}" name="tanggal_daftar" id="tanggal_daftar" readonly value="{{  old('tanggal_daftar', !empty($item->tanggal_daftar) ? $item->tanggal_daftar : '') }}" style="background-color:inherit">
                       <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                  </div>
                  {!! $errors->first('tanggal_daftar', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('nomor_pengeluaran') ? ' has-error' : '' }}">
            <label for="nomor_pengeluaran_barang" class="col-md-3 control-label">Nomor Bukti Pengeluaran Barang</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nomor_pengeluaran_barang" aria-label="nomor_pengeluaran_barang" id="nomor_pengeluaran_barang" value="{{ old('nomor_pengeluaran_barang', !empty($item->nomor_pengeluaran) ? $item->nomor_pengeluaran : '') }}" {!!  (Helper::checkIfRequired($item, 'nomor_pengeluaran')) ? ' data-validation="required" required' : '' !!}  />
                {!! $errors->first('nomor_pengeluaran', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('tanggal_pengeluaran') ? ' has-error' : '' }}">
            <label for="tanggal_pengeluaran_barang" class="col-md-3 control-label">{{ trans('Tanggal Penerimaan Barang') }}</label>
            <div class="col-md-8">
              <div class="input-group col-md-6">
                   <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                       <input type="text" class="form-control" placeholder="{{ trans('Tanggal Penerimaan Barang') }}" name="tanggal_pengeluaran_barang" id="tanggal_pengeluaran_barang" readonly value="{{  old('tanggal_pengeluaran_barang', !empty($item->tanggal_pengeluaran) ? $item->tanggal_pengeluaran : '') }}" style="background-color:inherit">
                       <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                  </div>
                  {!! $errors->first('tanggal_pengeluaran', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('nama_pengirim') ? ' has-error' : '' }}">
            <label for="nama_pengirim" class="col-md-3 control-label">Nama Pengirim Barang</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nama_pengirim" aria-label="nama_pengirim" id="nama_pengirim" value="{{ old('nama_pengirim', !empty($item->nama_pengirim) ? $item->nama_pengirim : '') }}" {!!  (Helper::checkIfRequired($item, 'nama_pengirim')) ? ' data-validation="required" required' : '' !!}  />
                {!! $errors->first('nama_pengirim', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('kode_dokumen_pabean') ? ' has-error' : '' }}">
            <label for="kode_dokumen" class="col-md-3 control-label">{{ trans('Kode Dokumen Pabean') }}</label>
            <div class="col-md-7 col-sm-11">
                {{ Form::select('kode_dokumen', $kodeDokumen , old('kode_dokumen', !empty($item->kode_dokumen_pabean) ? $item->kode_dokumen_pabean : ''), array('class'=>'select2
                kode_dokumen', 'style'=>'width:100%','id'=>'kode_dokumen', 'aria-label'=>'kode_dokumen')) }}
                {!! $errors->first('kode_dokumen_pabean', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                    aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('nomor_dokumen_pabean') ? ' has-error' : '' }}">
            <label for="nomor_dokumen" class="col-md-3 control-label">Nomor Dokumen Pabean</label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control" type="text" name="nomor_dokumen" aria-label="nomor_dokumen"
                id="nomor_dokumen" value="{{ old('name', !empty($item->nomor_dokumen_pabean) ? $item->nomor_dokumen_pabean : '') }}" {!!  (Helper::checkIfRequired($item, 'nomor_dokumen_pabean')) ? ' data-validation="required" required' : '' !!} />
                {!! $errors->first('nomor_dokumen_pabean', '<span class="alert-msg" aria-hidden="true"><i
                    class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>
    
        <div class="form-group {{ $errors->has('tanggal_dokumen_pabean') ? ' has-error' : '' }}">
            <label for="tanggal_dokumen" class="col-md-3 control-label">{{ trans('Tanggal Dokumen Pabean') }}</label>
            <div class="col-md-8">
              <div class="input-group col-md-6">
                   <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                       <input type="text" class="form-control" placeholder="{{ trans('Tanggal Dokumen') }}" name="tanggal_dokumen" id="tanggal_dokumen" readonly value="{{  old('tanggal_dokumen', !empty($item->tanggal_dokumen_pabean) ? $item->tanggal_dokumen_pabean : '') }}" style="background-color:inherit">
                       <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                  </div>
                  {!! $errors->first('tanggal_dokumen_pabean', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
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
                                  formaction="{{ route('pengeluaran.lampiran.delete', ['id' => $item->id, 'index' => $index]) }}"
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
    let jumlahBarang = $("#jumlah_barang_pengeluaran").val();
    let hargaBarang  = $(this).val();
    if(hargaBarang != ""){
        let totalHargaBarang = parseInt(jumlahBarang) * parseInt(hargaBarang);
        $("#harga_total_barang").val(totalHargaBarang).trigger("change");
    }
  })
  $(document).on("blur", "#jumlah_barang_pengeluaran", function(){
    let jumlahBarang = $(this).val();
    let hargaBarang  = $("#harga_satuan_barang").val();
    if(hargaBarang != ""){
      let totalHargaBarang = parseInt(jumlahBarang) * parseInt(hargaBarang);
      $("#harga_total_barang").val(totalHargaBarang).trigger("change");
      console.log(hargaBarang);
    }
  });  
    
</script>


<script>
    // Status Pengeluaran
$(document).ready(function () {
    $('#tambahStatusp').on('click', function () {
        $('#inputBaruWrapper2').slideToggle();
    });

    // Simpan status baru
    $('#simpanStatuspBaru').on('click', function () {
        let nama_status = $('#statusp_baru').val().trim();

        if (nama_status === '') {
            $('#error_statusp_baru').show();
            return;
        } else {
            $('#error_statusp_baru').hide();
        }

        $.ajax({
            url: '{{ route("nama_statusp.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                nama_status: nama_status,
            },
            success: function (response) {
                // Tambahkan ke select box dan pilih otomatis
                const option = new Option(response.nama_status, response.id, true, true);
                $('#nama_statusp').append(option).trigger('change');

                // Reset input
                $('#statusp_baru').val('');
                $('#inputBaruWrapper2').slideUp();
            },
            error: function (xhr) {
                let msg = 'Gagal menyimpan Status.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                alert(msg);
            }
        });
    });

    // Hapus status terpilih
    $('#hapusStatusp').on('click', function () {
        let selectedStatusp = $('#nama_statusp').val();

        if (!selectedStatusp) {
            alert('Silakan pilih status yang ingin dihapus.');
            return;
        }

        if (!confirm('Apakah kamu yakin ingin menghapus status ini?')) {return;}

        $.ajax({
            url: '{{ route("nama_statusp.destroy") }}',
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                id: selectedStatusp
            },
            success: function () {
                $('#nama_statusp option[value="' + selectedStatusp + '"]').remove();
                if ($('#nama_statusp option').length > 0) {
                    $('#nama_statusp').prop('selectedIndex', 0).trigger('change');
                } else {
                    // Jika tidak ada lagi option, kosongkan
                    $('#nama_statusp').append('<option value="">(Tidak ada status)</option>').val('').trigger('change');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Gagal menghapus Status.');
            }
        });
    });
});
</script>


<script>
    // Jenis Pengeluaran
    $(document).ready(function () {
        // Toggle input status baru
        $('#tambahJenis').on('click', function () {
            $('#inputBaruWrapperJenis').slideToggle();
        });

        // Simpan Jenis baru
        $('#simpanjenisBaru').on('click', function () {
            let nama_jenis = $('#jenisBaru').val().trim();

            if (nama_jenis === '') {
                $('#error_jenisBaru').show();
                return;
            } else {
                $('#error_jenisBaru').hide();
            }

            $.ajax({
                url: '{{ route("jenis_peng.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    nama_jenis: nama_jenis,
                },
                success: function (response) {
                    // Tambahkan ke select box dan pilih otomatis
                    const option = new Option(response.nama_jenis, response.id, true, true);
                    $('#nama_jenis').append(option).trigger('change');

                    // Reset input
                    $('#jenisBaru').val('');
                    $('#inputBaruWrapperJenis').slideUp();
                },
                error: function (xhr) {
                    let msg = 'Gagal menyimpan Jenis.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    alert(msg);
                }
            });
        });

        // Hapus jenis terpilih
        $('#hapusJenis').on('click', function () {
            let selectedJenisPeng = $('#nama_jenis').val();

            if (!selectedJenisPeng) {
                alert('Silakan pilih Jenis yang ingin dihapus.');
                return;
            }

            if (!confirm('Apakah kamu yakin ingin menghapus Jenis ini?')) {return;}

            $.ajax({
                url: '{{ route("jenis_peng.destroy") }}',
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: selectedJenisPeng
                },
                success: function () {
                    $('#nama_jenis option[value="' + selectedJenisPeng + '"]').remove();
                    if ($('#nama_jenis option').length > 0) {
                        $('#nama_jenis').prop('selectedIndex', 0).trigger('change');
                    } else {
                        // Jika tidak ada lagi option, kosongkan
                        $('#nama_jenis').append('<option value="">(Tidak ada Owner)</option>').val('').trigger('change');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal menghapus Jenis.');
                }
            });
        });
    });
</script>

  @stop
{{-- @section('moar_scripts')
  @include('partials/assets-assigned')
@stop --}}
