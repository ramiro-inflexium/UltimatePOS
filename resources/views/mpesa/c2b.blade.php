@extends('layouts.app')
@section('title', __( 'unit.units' ))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>C2B
        <small> Transactions</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">

        @can('unit.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="unit_table">
                    <thead>
                        <tr>
                            <th>@lang( 'unit.name' )</th>
                            <th>@lang( 'unit.short_name' )</th>
                            <th>@lang( 'unit.allow_decimal' ) @show_tooltip(__('tooltip.unit_allow_decimal'))</th>
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endcan

    <div class="modal fade unit_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
