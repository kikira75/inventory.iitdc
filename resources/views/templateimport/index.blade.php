@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('List Detail Asset') }}
@parent
@stop


{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">

          <table
              data-columns="{{ \App\Presenters\ListAllPresenter::dataTableLayout() }}"
              data-cookie-id-table="ListallTable"
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
              id="ListallTable"
              class="table table-striped snipe-table"
              data-url="{{ route('api.pemasukan.index') }}"
              data-export-options='{ "fileName": "export-listall-{{ date('Y-m-d') }}" }',"ignoreColumn": ["actions"]>
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

@stop
