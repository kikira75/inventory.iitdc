@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Pemasukan') }}
@parent
@stop


@section('header_right')
{{--  @can('create', \App\Models\Pemasukan::class)
<a href="{{ route('pemasukan.create') }}" accesskey="n" class="btn btn-primary pull-right">
  {{ trans('general.create') }}99x
</a>
@endcan  --}}
@if (Auth::user()->isSuperUser() || Auth::user()->isAdmin())
@if(request('status') === 'Deleted')
    {{-- TAMPILKAN TOMBOL BACK --}}
    <a href="{{ route('pemasukan.index') }}" class="btn btn-primary pull-right">
        Pemasukan
    </a>
@else
    {{-- TAMPILKAN TOMBOL DELETED --}}
    <a href="?status=Deleted" class="btn btn-primary pull-right">
        Deleted
    </a>
@endif
<a href="{{ route('pemasukan/sendApiPem') }}" accesskey="n" class="btn btn-primary pull-right">
  {{ trans('Send APi') }}
</a>
@endif
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">
        <!-- Modal Filter -->
        <img id="logo" src="http://localhost:8000/uploads/setting-logo-1-IYL9hAvqLd.png" crossorigin="anonymous" style="display:none;">
        
        <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="modal_tanggal_mulai">Tanggal Mulai</label>
                  <input type="date" id="modal_tanggal_mulai" class="form-control">
                </div>
                <div class="form-group">
                  <label for="modal_tanggal_akhir">Tanggal Akhir</label>
                  <input type="date" id="modal_tanggal_akhir" class="form-control">
                </div>
                <div class="form-group">
                  <label for="modal_kode_barang">Kode Barang</label>
                  <input type="text" id="modal_kode_barang" class="form-control" placeholder="Masukkan kode barang">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="applyFilter">Terapkan Filter</button>
              </div>
            </div>
          </div>
        </div>
        <div class="row" style="margin-bottom: 15px;">
          <div class="col-md-2 d-flex align-items-center" style="gap: 10px;">
            @if(Request::get('status') !== 'Deleted')
                <button class="btn btn-info" data-toggle="modal" data-target="#filterModal" style="margin-bottom: 10px;">
                    Filter
                </button>
            @endif
            @include('partials.pemasukan-bulk-actions', ['status' => request('status')])
          </div>
        </div>

        <table
            data-columns="{{ \App\Presenters\PemasukanPresenter::dataTableLayout() }}"
            data-cookie-id-table="PemasukanTable"
            data-pagination="true"
            data-search="true"
            data-side-pagination="server"
            data-show-columns="true"
            data-show-fullscreen="false"
            data-show-export="true"
            data-show-footer="true"
            data-show-refresh="true"
            data-sort-order="true"
            data-sort-name="true"
            data-click-to-select="true"
            id="PemasukanTable"
            class="table table-striped snipe-table"
            data-url="{{ route('api.pemasukan.index', [
                'status' => Request::get('status')
            ]) }}"
            data-export-options='{
          "fileName": "export-pemasukan-{{ date('Y-m-d') }}",
          "ignoreColumn": ["actions"]
          }'>
        </table>

      </div><!-- /.box-body -->

      <div class="box-footer clearfix">
      </div>
    </div><!-- /.box -->
  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')
<script>
$(function() {
  $('#applyFilter').on('click', function() {
    var tanggal_mulai = $('#modal_tanggal_mulai').val();
    var tanggal_akhir = $('#modal_tanggal_akhir').val();
    var kode_barang = $('#modal_kode_barang').val();
    var $table = $('#PemasukanTable');
    $table.bootstrapTable('refresh', {
      query: {
        tanggal_mulai: tanggal_mulai,
        tanggal_akhir: tanggal_akhir,
        kode_barang: kode_barang
      }
    });
    var fileName = 'export-pemasukan';
    if (tanggal_mulai && tanggal_akhir) {
      fileName += '-' + tanggal_mulai + '-to-' + tanggal_akhir;
    } else if (tanggal_mulai) {
      fileName += '-from-' + tanggal_mulai;
    } else if (tanggal_akhir) {
      fileName += '-until-' + tanggal_akhir;
    }
    if (kode_barang) {
      fileName += '-' + kode_barang;
    }
    fileName += '-' + moment().format('YYYY-MM-DD');
    $table.bootstrapTable('refreshOptions', {
      exportOptions: {
        fileName: fileName,
        ignoreColumn: ['actions']
      }
    });
    $('#filterModal').modal('hide');
  });
});
</script>
<script>
function conditionalCheckboxFormatter(value, row, index) {
    if (row.status_sending === 'Belum Selesai') {
        return ''; // tampilkan checkbox bawaan (default)
    }

    // Untuk status selain 'Belum Selesai', disable checkbox bawaan
    return {
        disabled: true
    };
}
</script>


@stop
