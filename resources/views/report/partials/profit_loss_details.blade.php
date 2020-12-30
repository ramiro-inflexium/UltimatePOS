<div class="col-xs-6">
    @component('components.widget')
        <table class="table table-striped">
            <tr>
                <th>{{ __('report.opening_stock') }}:</th>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{$data['opening_stock']}}</span>
                </td>
            </tr>
            <tr>
                <th>{{ __('home.total_purchase') }}:<br><small class="text-muted">(@lang('product.exc_of_tax'), @lang('sale.discount'))</small></th>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_purchase']}}</span>
                </td>
            </tr>
            <tr>
                <th>{{ __('report.total_stock_adjustment') }}:</th>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_adjustment']}}</span>
                </td>
            </tr> 
            <tr>
                <th>{{ __('report.total_expense') }}:</th>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_expense']}}</span>
                </td>
            </tr>
            <tr>
                <th>{{ __('lang_v1.total_shipping_charges') }}:</th>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_transfer_shipping_charges']}}</span>
                </td>
            </tr>
            <tr>
                <th>{{ __('lang_v1.total_sell_discount') }}:</th>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_sell_discount']}}</span>
                </td>
            </tr>
            <tr>
                <th>{{ __('lang_v1.total_reward_amount') }}:</th>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_reward_amount']}}</span>
                </td>
            </tr>
            <tr>
                <th>{{ __('lang_v1.total_sell_return') }}:</th>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_sell_return']}}</span>
                </td>
            </tr>
            @foreach($data['left_side_module_data'] as $module_data)
                <tr>
                    <th>{{ $module_data['label'] }}:</th>
                    <td>
                        <span class="display_currency" data-currency_symbol="true">{{ $module_data['value'] }}</span>
                    </td>
                </tr>
            @endforeach
        </table>
    @endcomponent
</div>

<div class="col-xs-6">
    @component('components.widget')
        <table class="table table-striped">
            <tr>
                <th>{{ __('report.closing_stock') }}:</th>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{$data['closing_stock']}}</span>
                </td>
            </tr>
            <tr>
                <th>{{ __('home.total_sell') }}: <br>
                    <!-- sub type for total sales -->
                    <ul>
                        @foreach($data['total_sell_by_subtype'] as $sell)
                            @if($data['total_sell_by_subtype']->count() > 1)
                                <li>
                                    @if(!empty($sell->sub_type))
                                        {{ucfirst($sell->sub_type)}}
                                    @else
                                        {{'-'}}
                                    @endif &nbsp;: &nbsp;
                                    <span class="display_currency" data-currency_symbol="true">
                                        {{$sell->total_before_tax}}    
                                    </span>
                                </li>
                            @elseif($data['total_sell_by_subtype']->count() == 1 && !empty($sell->sub_type))
                                <li>
                                    @if(!empty($sell->sub_type))
                                        {{ucfirst($sell->sub_type)}}
                                    @endif &nbsp;: &nbsp;
                                    <span class="display_currency" data-currency_symbol="true">
                                        {{$sell->total_before_tax}}    
                                    </span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <small class="text-muted"> 
                        (@lang('product.exc_of_tax'), @lang('sale.discount'))
                    </small>
                </th>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_sell']}}</span>
                </td>
            </tr>
            <tr>
                <th>{{ __('report.total_stock_recovered') }}:</th>
                <td>
                     <span class="display_currency" data-currency_symbol="true">{{$data['total_recovered']}}</span>
                </td>
            </tr>
            <tr>
                <th>{{ __('lang_v1.total_purchase_return') }}:</th>
                <td>
                     <span class="display_currency" data-currency_symbol="true">{{$data['total_purchase_return']}}</span>
                </td>
            </tr>
            <tr>
                <th>{{ __('lang_v1.total_purchase_discount') }}:</th>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_purchase_discount']}}</span>
                </td>
            </tr>
            <tr>
                <th>{{ __('lang_v1.total_sell_round_off') }}:</th>
                <td>
                    <span class="display_currency" data-currency_symbol="true">{{$data['total_sell_round_off']}}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                &nbsp;
                </td>
            </tr>
            @foreach($data['right_side_module_data'] as $module_data)
                <tr>
                    <th>{{ $module_data['label'] }}:</th>
                    <td>
                        <span class="display_currency" data-currency_symbol="true">{{ $module_data['value'] }}</span>
                    </td>
                </tr>
            @endforeach
        </table>
    @endcomponent
</div>
<br>
<div class="col-xs-12">
    @component('components.widget')
        <h3 class="text-muted mb-0">
            {{ __('lang_v1.gross_profit') }}: 
            <span class="display_currency" data-currency_symbol="true">{{$data['gross_profit']}}</span>
        </h3>
        <small class="help-block">
            (@lang('lang_v1.total_sell_price') - @lang('lang_v1.total_purchase_price'))
            @if(!empty($data['gross_profit_label']))
                + {{$data['gross_profit_label']}}
            @endif
        </small>

        <h3 class="text-muted mb-0">
            {{ __('report.net_profit') }}: 
            <span class="display_currency" data-currency_symbol="true">{{$data['net_profit']}}</span>
        </h3>
        <small class="help-block">(@lang('report.closing_stock') + @lang('home.total_sell') + @lang('report.total_stock_recovered') + @lang('lang_v1.total_purchase_return') + @lang('lang_v1.total_purchase_discount') + @lang('lang_v1.total_sell_round_off') 
        @foreach($data['right_side_module_data'] as $module_data)
            @if(!empty($module_data['add_to_net_profit']))
                + {{$module_data['label']}} 
            @endif
        @endforeach
        ) <br> - (@lang('report.opening_stock') + @lang('home.total_purchase') + @lang('report.total_expense') + @lang('lang_v1.total_shipping_charges') + @lang('lang_v1.total_sell_discount') + @lang('lang_v1.total_reward_amount') 
        @foreach($data['left_side_module_data'] as $module_data)
            @if(!empty($module_data['add_to_net_profit']))
                + {{$module_data['label']}}
            @endif 
        @endforeach )</small>
    @endcomponent
</div>