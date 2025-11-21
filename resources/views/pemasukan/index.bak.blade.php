@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Pemasukan') }}
@parent
@stop


@section('header_right')
{{--  @can('create', \App\Models\Pemasukan::class)
<a href="{{ route('pemasukan.create') }}" accesskey="n" class="btn btn-primary pull-right">
  {{ trans('general.create') }}76x
</a>
@endcan  --}}
@if (Auth::user()->isSuperUser() || Auth::user()->isAdmin())
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
        <img id="logo" src="http://localhost:8000/uploads/setting-logo-1-IYL9hAvqLd.png" crossorigin="anonymous" style="display:none;">
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
              id="PemasukanTable"
              class="table table-striped snipe-table"
              data-url="{{ route('api.pemasukan.index') }}"
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
function lampiranFormatter(value, row, index) {
    return value || '-';
}
</script>


@stop
