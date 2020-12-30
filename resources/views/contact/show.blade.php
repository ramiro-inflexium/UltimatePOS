@extends('layouts.app')
@section('title', __('contact.view_contact'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>{{ __('contact.view_contact') }}</h1>
</section>

<!-- Main content -->
<section class="content no-print">
    <div class="hide print_table_part">
        <style type="text/css">
            .info_col {
                width: 25%;
                float: left;
                padding-left: 10px;
                padding-right: 10px;
            }
        </style>
        <div style="width: 100%;">
            <div class="info_col">
                @include('contact.contact_basic_info')
            </div>
            <div class="info_col">
                @include('contact.contact_more_info')
            </div>
            @if( $contact->type != 'customer')
                <div class="info_col">
                    @include('contact.contact_tax_info')
                </div>
            @endif
            <div class="info_col">
                @include('contact.contact_payment_info')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            {!! Form::select('contact_id', $contact_dropdown, $contact->id , ['class' => 'form-control select2', 'id' => 'contact_id']); !!}

            <input type="hidden" id="sell_list_filter_customer_id" value="{{$contact->id}}">
            <input type="hidden" id="purchase_list_filter_supplier_id" value="{{$contact->id}}">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs nav-justified">
                    <li class="
                        @if(!empty($view_type) &&  $view_type == 'contact_info')
                            active
                        @else
                            ''
                        @endif">
                        <a href="#contact_info_tab" data-toggle="tab" aria-expanded="true"><i class="fas fa-user" aria-hidden="true"></i> @lang( 'contact.contact_info', ['contact' => __('contact.contact') ])</a>
                    </li>
                    <li class="
                            @if(!empty($view_type) &&  $view_type == 'ledger')
                                active
                            @else
                                ''
                            @endif">
                        <a href="#ledger_tab" data-toggle="tab" aria-expanded="true"><i class="fas fa-scroll" aria-hidden="true"></i> @lang('lang_v1.ledger')</a>
                    </li>
                    @if(in_array($contact->type, ['both', 'supplier']))
                        <li class="
                            @if(!empty($view_type) &&  $view_type == 'purchase')
                                active
                            @else
                                ''
                            @endif">
                            <a href="#purchases_tab" data-toggle="tab" aria-expanded="true"><i class="fas fa-arrow-circle-down" aria-hidden="true"></i> @lang( 'purchase.purchases')</a>
                        </li>
                        <li class="
                            @if(!empty($view_type) &&  $view_type == 'stock_report')
                                active
                            @else
                                ''
                            @endif">
                            <a href="#stock_report_tab" data-toggle="tab" aria-expanded="true"><i class="fas fa-hourglass-half" aria-hidden="true"></i> @lang( 'report.stock_report')</a>
                        </li>
                    @endif
                    @if(in_array($contact->type, ['both', 'customer']))
                        <li class="
                            @if(!empty($view_type) &&  $view_type == 'sales')
                                active
                            @else
                                ''
                            @endif">
                            <a href="#sales_tab" data-toggle="tab" aria-expanded="true"><i class="fas fa-arrow-circle-up" aria-hidden="true"></i> @lang( 'sale.sells')</a>
                        </li>
                    @endif
                    <li class="
                            @if(!empty($view_type) &&  $view_type == 'documents_and_notes')
                                active
                            @else
                                ''
                            @endif
                            ">
                        <a href="#documents_and_notes_tab" data-toggle="tab" aria-expanded="true"><i class="fas fa-paperclip" aria-hidden="true"></i> @lang('lang_v1.documents_and_notes')</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane
                            @if(!empty($view_type) &&  $view_type == 'contact_info')
                                active
                            @else
                                ''
                            @endif"
                            id="contact_info_tab">
                        @include('contact.partials.contact_info_tab')
                    </div>
                    <div class="tab-pane
                                @if(!empty($view_type) &&  $view_type == 'ledger')
                                    active
                                @else
                                    ''
                                @endif"
                            id="ledger_tab">
                        @include('contact.partials.ledger_tab')
                    </div>
                    @if(in_array($contact->type, ['both', 'supplier']))
                        <div class="tab-pane
                            @if(!empty($view_type) &&  $view_type == 'purchase')
                                active
                            @else
                                ''
                            @endif"
                        id="purchases_tab">
                            <div class="row">
                                <div class="col-md-12">
                                    @include('purchase.partials.purchase_table')
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane 
                            @if(!empty($view_type) &&  $view_type == 'stock_report')
                                active
                            @else
                                ''
                            @endif" id="stock_report_tab">
                            @include('contact.partials.stock_report_tab')
                        </div>
                    @endif
                    @if(in_array($contact->type, ['both', 'customer']))
                        <div class="tab-pane 
                            @if(!empty($view_type) &&  $view_type == 'sales')
                                active
                            @else
                                ''
                            @endif"
                        id="sales_tab">
                            <div class="row">
                                <div class="col-md-12">
                                    @include('sale_pos.partials.sales_table')
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="tab-pane
                            @if(!empty($view_type) &&  $view_type == 'documents_and_notes')
                                active
                            @else
                                ''
                            @endif"
                        id="documents_and_notes_tab">
                        @include('contact.partials.documents_and_notes_tab')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
<div class="modal fade payment_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade pay_contact_due_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel"></div>
@stop
@section('javascript')
<script type="text/javascript">
$(document).ready( function(){
    $('#ledger_date_range').daterangepicker(
        dateRangeSettings,
        function (start, end) {
            $('#ledger_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
        }
    );
    $('#ledger_date_range').change( function(){
        get_contact_ledger();
    });
    get_contact_ledger();

    rp_log_table = $('#rp_log_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'desc']],
        ajax: '/sells?customer_id={{ $contact->id }}&rewards_only=true',
        columns: [
            { data: 'transaction_date', name: 'transactions.transaction_date'  },
            { data: 'invoice_no', name: 'transactions.invoice_no'},
            { data: 'rp_earned', name: 'transactions.rp_earned'},
            { data: 'rp_redeemed', name: 'transactions.rp_redeemed'},
        ]
    });

    supplier_stock_report_table = $('#supplier_stock_report_table').DataTable({
        processing: true,
        serverSide: true,
        'ajax': {
            url: "{{action('ContactController@getSupplierStockReport', [$contact->id])}}",
            data: function (d) {
                d.location_id = $('#sr_location_id').val();
            }
        },
        columns: [
            { data: 'product_name', name: 'p.name'  },
            { data: 'sub_sku', name: 'v.sub_sku'  },
            { data: 'purchase_quantity', name: 'purchase_quantity', searchable: false},
            { data: 'total_quantity_sold', name: 'total_quantity_sold', searchable: false},
            { data: 'total_quantity_returned', name: 'total_quantity_returned', searchable: false},
            { data: 'current_stock', name: 'current_stock', searchable: false},
            { data: 'stock_price', name: 'stock_price', searchable: false}
        ],
        fnDrawCallback: function(oSettings) {
            __currency_convert_recursively($('#supplier_stock_report_table'));
        },
    });

    $('#sr_location_id').change( function() {
        supplier_stock_report_table.ajax.reload();
    });

    $('#contact_id').change( function() {
        if ($(this).val()) {
            window.location = "{{url('/contacts')}}/" + $(this).val();
        }
    });
});

$("input.transaction_types, input#show_payments").on('ifChanged', function (e) {
    get_contact_ledger();
});

function get_contact_ledger() {

    var start_date = '';
    var end_date = '';
    var transaction_types = $('input.transaction_types:checked').map(function(i, e) {return e.value}).toArray();
    var show_payments = $('input#show_payments').is(':checked');

    if($('#ledger_date_range').val()) {
        start_date = $('#ledger_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
        end_date = $('#ledger_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
    }
    $.ajax({
        url: '/contacts/ledger?contact_id={{$contact->id}}&start_date=' + start_date + '&transaction_types=' + transaction_types + '&show_payments=' + show_payments + '&end_date=' + end_date,
        dataType: 'html',
        success: function(result) {
            $('#contact_ledger_div')
                .html(result);
            __currency_convert_recursively($('#contact_ledger_div'));

            $('#ledger_table').DataTable({
                searching: false,
                ordering:false,
                paging:false,
                dom: 't'
            });
        },
    });
}

$(document).on('click', '#send_ledger', function() {
    var start_date = $('#ledger_date_range').data('daterangepicker').startDate._i;
    var end_date = $('#ledger_date_range').data('daterangepicker').endDate._i;

    var url = "{{action('NotificationController@getTemplate', [$contact->id, 'send_ledger'])}}" + '?start_date=' + start_date + '&end_date=' + end_date;

    $.ajax({
        url: url,
        dataType: 'html',
        success: function(result) {
            $('.view_modal')
                .html(result)
                .modal('show');
        },
    });
})

$(document).on('click', '#print_ledger_pdf', function() {
    var start_date = $('#ledger_date_range').data('daterangepicker').startDate._i;
    var end_date = $('#ledger_date_range').data('daterangepicker').endDate._i;

    var url = $(this).data('href') + '&start_date=' + start_date + '&end_date=' + end_date;
    window.location = url;
});
</script>
@include('sale_pos.partials.sale_table_javascript')
<script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
@if(in_array($contact->type, ['both', 'supplier']))
    <script src="{{ asset('js/purchase.js?v=' . $asset_v) }}"></script>
@endif

<!-- document & note.js -->
@include('documents_and_notes.document_and_note_js')
@endsection
