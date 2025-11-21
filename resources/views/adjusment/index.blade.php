@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Adjusment') }}
@parent
@stop


@section('header_right')
{{--  @can('create', \App\Models\Pemasukan::class)
<a href="{{ route('pemasukan.create') }}" accesskey="n" class="btn btn-primary pull-right">
  {{ trans('general.create') }}
</a>
@endcan  --}}
@if (Auth::user()->isSuperUser() || Auth::user()->isAdmin())
@if(request('status') === 'Deleted')
    {{-- TAMPILKAN TOMBOL BACK --}}
    <a href="{{ route('adjusment.index') }}" class="btn btn-primary pull-right">
        Adjusment
    </a>
@else
    {{-- TAMPILKAN TOMBOL DELETED --}}
    <a href="?status=Deleted" class="btn btn-primary pull-right">
        Deleted
    </a>
@endif
  <a href="{{ route('adjusment/sendApiAdjust') }}" accesskey="n" class="btn btn-primary pull-right">
    {{ trans('Send APi') }}
@endif

</a>
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">
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
          <div class="col-md-2">
            @if(Request::get('status') !== 'Deleted')
                <button class="btn btn-info" data-toggle="modal" data-target="#filterModal" style="margin-bottom: 10px;">
                    Filter
                </button>
            @endif
            @include('partials.adjusment-bulk-actions', ['status' => request('status')])
          </div>
        </div>
        <table
              data-columns="{{ \App\Presenters\AdjusmentPresenter::dataTableLayout() }}"
              data-cookie-id-table="AdjusmentTable"
              data-pagination="true"
              data-search="true"
              data-side-pagination="server"
              data-show-columns="true"
              data-show-fullscreen="false"
              data-show-export="true"
              data-show-footer="true"
              data-show-refresh="true"
              data-sort-order="false"
              data-click-to-select="true"
              data-sort-name="false"
              id="AdjusmentTable"
              class="table table-striped snipe-table"
              data-url="{{ route('api.adjusment.index', [
                'status' => Request::get('status')
            ]) }}"
              data-export-options='{
            "fileName": "export-adjusment-{{ date('Y-m-d') }}",
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
function lampiranFormatter(value, row, index) {
    return value || '-';
}
$(function() {
  $('#applyFilter').on('click', function() {
    var tanggal_mulai = $('#modal_tanggal_mulai').val();
    var tanggal_akhir = $('#modal_tanggal_akhir').val();
    var kode_barang = $('#modal_kode_barang').val();
    var $table = $('#AdjusmentTable');
    $table.bootstrapTable('refresh', {
      query: {
        tanggal_mulai: tanggal_mulai,
        tanggal_akhir: tanggal_akhir,
        kode_barang: kode_barang
      }
    });
    var fileName = 'export-adjusment';
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
function lampiranFormatter(value, row, index) {
    return value || '-';
}
</script>

<script>
function conditionalCheckboxFormatter(value, row, index) {
    if (row.status_sending === 'B') {
        return ''; // tampilkan checkbox bawaan (default)
    }

    // Untuk status selain 'Belum Selesai', disable checkbox bawaan
    return {
        disabled: true
    };
}
</script>

@stop
