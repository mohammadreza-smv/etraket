<?php

$OrderStatus=\Modules\orders\Models\Orders::OrderStatus();
$args=['title'=>'جزییات سفارش']

?>

<x-user-panel-box :args="$args">
    @includeIf('orders::userpanel.order-global-info')
</x-user-panel-box>

<?php $i=1; ?>

@foreach($order->submissions as $key=>$value)

    <?php

    $args=[];
    if(view_type!='mobile'){
        $args['title']='مرسوله '.replace_number($i).' از '.replace_number(sizeof($order->submissions)).'';
    }
    ?>

    <x-user-panel-box :args="$args">

        <x-slot name="header">
            <span>مرسوله </span>
            <span>{{ replace_number($i) }} </span>
            از
            <span>{{ replace_number(sizeof($order->submissions))  }}</span>

            <span style="color:<?= $value['send_status']>0 ? 'green' : 'red' ?>">
                      ({{ getOrderStatus([$value['send_status']]) }})
                </span>

        </x-slot>
        <div style="margin: 20px">

            @includeIf('orders::submission.detail')

            @if(view_type!='mobile')
                <order-step
                    :steps="{{ json_encode($OrderStatus) }}"
                    :send_status="{{ $value['send_status'] }}"
                ></order-step>
            @endif

            @foreach($value->products as $row)
                @if($row->product)
                    <div class="product-detail-row">
                        <div class="img-box">
                            <a href="{{ shop_product_url($row->product) }}">
                                <img src="{{ url('files/thumbnails/'.$row->product->image_url) }}"/>
                            </a>
                        </div>

                        <div class="product-detail">
                            <div class="item">
                                {{ $row->product->title }}
                            </div>
                            <div class="item">
                                @if($row->param1_type=='Modules\\colors\\Models\\Color')
                                    <span class="color" style="background-color:#<?= $row->param1->code ?>"></span>
                                    {{ $row->param1->name }}

                                @elseif($row->param1_type=='Modules\\warranty\\Models\\Warranty')
                                    {{ $row->param1->name }}
                                @elseif($row->param1_type=='Modules\\priceVariation\\Models\\PriceVariationItems')
                                    {{ $row->param1->variation_name }} : {{ $row->param1->variation_value }}
                                @endif
                            </div>

                            <div class="item">
                                @if($row->param2_type=='Modules\\colors\\Models\\Color')
                                    <span class="color" style="background-color:#<?= $row->param2->code ?>"></span>
                                    {{ $row->param2->name }}

                                @elseif($row->param2_type=='Modules\\warranty\\Models\\Warranty')
                                    {{ $row->param2->name }}
                                @elseif($row->param2_type=='Modules\\priceVariation\\Models\\PriceVariationItems')
                                    {{ $row->param2->variation_name }} : {{ $row->param2->variation_value }}
                                @endif
                            </div>

                            @if($row->seller)
                                <div class="item">
                                    <span>فروشنده : </span>
                                    <span>{{ $row->seller->brand_name }}</span>
                                </div>
                            @endif

                            <div class="item">
                                <span>تعداد : </span>
                                <span>{{ replace_number($row->product_count) }}</span>
                            </div>

                            <div class="item">
                                <span>قیمت واحد : </span>
                                <span>{{ get_price($row->product_price2) }}</span>
                            </div>

                        </div>
                    </div>
                @endif
            @endforeach

        </div>
    </x-user-panel-box>

    <?php $i++; ?>
@endforeach
