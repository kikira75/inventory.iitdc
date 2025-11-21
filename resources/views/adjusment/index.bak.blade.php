@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Adjusment') }}
@parent
@stop


@section('header_right')
{{--  @can('create', \App\Models\Pemasukan::class)
<a href="{{ route('pemasukan.create') }}" accesskey="n" class="btn btn-primary pull-right">
  {{ trans('general.create') }}4xx
</a>
@endcan  --}}
@if (Auth::user()->isSuperUser() || Auth::user()->isAdmin())
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
              data-sort-name="false"
              id="AdjusmentTable"
              class="table table-striped snipe-table"
              data-url="{{ route('api.adjusment.index') }}"
              data-export-options='{
            "fileName": "export-licenses-{{ date('Y-m-d') }}",
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
