<li>
    <div>
        <span>مبلغ کل </span>
        <span>({{ replace_number(sizeof($send_order_data['products'][1])) }}) کالا</span>
    </div>
    <span class="left">{{ get_price($send_order_data['cart_price'][1]) }} </span>
</li>

<li>
    <span>هزینه ارسال</span>
    <span class="left" id="total_send_order_price">
               <?= get_send_order_amount($send_type,$send_order_data)  ?>
        </span>
</li>

@if(is_array($send_order_data['checkoutItems']))
    @foreach($send_order_data['checkoutItems'] as $item)
        <li class="{{ $item['name'] }}"  style="display: {{ $item['display'] }}">
            <span>{{ $item['title'] }}</span>
            <span class="left" id="{{ $item['name'] }}_value">
                         {{ $item['value'] }}
                    </span>
        </li>

    @endforeach
@endif
