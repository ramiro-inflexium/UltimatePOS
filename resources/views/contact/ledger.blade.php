<!-- app css -->
@if(!empty($for_pdf))
	<link rel="stylesheet" href="{{ asset('css/app.css?v='.$asset_v) }}">
@endif
<div class="col-md-12 col-sm-12 @if(!empty($for_pdf)) width-100 align-right @endif">
        <p class="text-right align-right"><strong>{{$contact->business->name}}</strong><br>{!! $contact->business->business_address !!}</p>
    <hr>
</div>
<div class="col-md-6 col-sm-6 col-xs-6 @if(!empty($for_pdf)) width-50 f-left @endif">
	<p>@lang('lang_v1.to'):</p>
	<p><strong>{{$contact->name}}</strong><br> {!! $contact->contact_address !!} @if(!empty($contact->email)) <br>@lang('business.email'): {{$contact->email}} @endif
	<br>@lang('contact.mobile'): {{$contact->mobile}}
	@if(!empty($contact->tax_number)) <br>@lang('contact.tax_no'): {{$contact->tax_number}} @endif
</p>
</div>
<div class="col-md-6 col-sm-6 col-xs-6 text-right align-right @if(!empty($for_pdf)) width-50 f-left @endif">
	<h3 class="mb-0">@lang('lang_v1.account_summary')</h3>
	<small>{{$ledger_details['start_date']}} - {{$ledger_details['end_date']}}</small>
	<hr>
	<table class="table table-condensed text-left align-left no-border @if(!empty($for_pdf)) table-pdf @endif">
		<tr>
			<td>@lang('lang_v1.beginning_balance')</td>
			<td>@format_currency($ledger_details['beginning_balance'])</td>
		</tr>
	@if( $contact->type == 'supplier' || $contact->type == 'both')
		<tr>
			<td>@lang('report.total_purchase')</td>
			<td>@format_currency($ledger_details['total_purchase'])</td>
		</tr>
	@endif
	@if( $contact->type == 'customer' || $contact->type == 'both')
		<tr>
			<td>@lang('lang_v1.total_invoice')</td>
			<td>@format_currency($ledger_details['total_invoice'])</td>
		</tr>
	@endif
	<tr>
		<td>@lang('sale.total_paid')</td>
		<td>@format_currency($ledger_details['total_paid'])</td>
	</tr>
	<tr>
		<td><strong>@lang('lang_v1.balance_due')</strong></td>
		<td>@format_currency($ledger_details['balance_due'])</td>
	</tr>
	</table>
</div>
<div class="col-md-12 col-sm-12 @if(!empty($for_pdf)) width-100 @endif">
	<p class="text-center" style="text-align: center;"><strong>@lang('lang_v1.ledger_table_heading', ['start_date' => $ledger_details['start_date'], 'end_date' => $ledger_details['end_date']])</strong></p>
	<table class="table table-striped @if(!empty($for_pdf)) table-pdf td-border @endif" id="ledger_table">
		<thead>
			<tr class="row-border">
				<th>@lang('lang_v1.date')</th>
				<th>@lang('purchase.ref_no')</th>
				<th>@lang('lang_v1.type')</th>
				<th>@lang('sale.location')</th>
				<th>@lang('sale.payment_status')</th>
				<th>@lang('sale.total')</th>
				<th>@lang('account.debit')</th>
				<th>@lang('account.credit')</th>
				<th>@lang('lang_v1.payment_method')</th>
				<th>@lang('report.others')</th>
			</tr>
		</thead>
		<tbody>
			@foreach($ledger_details['ledger'] as $data)
				<tr>
					<td class="row-border">{{@format_datetime($data['date'])}}</td>
					<td>{{$data['ref_no']}}</td>
					<td>{{$data['type']}}</td>
					<td>{{$data['location']}}</td>
					<td>{{$data['payment_status']}}</td>
					<td class="ws-nowrap">@if(!empty($data['total'])) @format_currency($data['total']) @else @format_currency(0) @endif</td>
					<td class="ws-nowrap">@if($data['debit'] != '') @format_currency($data['debit']) @endif</td>
					<td class="ws-nowrap">@if($data['credit'] != '') @format_currency($data['credit']) @endif</td>
					<td>{{$data['payment_method']}}</td>
					<td>{!! $data['others'] !!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>