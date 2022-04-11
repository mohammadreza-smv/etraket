<div class="tab-content" id="orderTabContent">

    <?php $jdf=new \App\Lib\Jdf() ?>

    @foreach($orders as $order)
        <div class="order-item">

            <div class="list-item-detail">

                <div class="order-detail-header">

                    <div class="item-detail-row">
                        <div class="detail-item">{{ $jdf->jdate('j F Y',$order->created_at) }}</div>
                        <div class="detail-item">DKC-{{ replace_number($order->id) }}</div>
                    </div>

                    <div>
                        <a class="order-link" href="{{ url('user/profile/order/'.$order->id) }}">مشاهده سفارش</a>
                    </div>

                </div>

                <div class="item-detail-row">
                    <span>مبلغ کل : </span>
                    {{ get_price($order->price) }}
                </div>

            </div>

            <?php $i=1; ?>

            @foreach($order->submissions as $submission)
                <div class="submission">

                    <p>
                        <span>مرسوله </span>
                        <span>{{ replace_number($i) }} </span>
                        <span> از</span>
                        <span>{{ replace_number(sizeof($order->submissions)) }} </span>
                    </p>

                    <div class="products">
                        @foreach($submission->products as $row)
                            @if($row->product)
                                <a href="{{ shop_product_url($row->product) }}">
                                    <img src="{{ url('files/thumbnails/'.$row->product->image_url) }}" />
                                </a>
                            @endif
                        @endforeach
                    </div>

                </div>
                <?php $i++; ?>
            @endforeach

            @if($order->pay_status=='ok')
                <div class="factor_link">
                    <a class="order-link" href="{{ url('user/profile/order/'.$order->id.'/factor') }}">فاکتور سفارش</a>
                </div>
            @endif
        </div>
    @endforeach

    {{ $orders->links() }}

    @if(sizeof($orders)==0)
        <p class="not-found-order">سفارشی یافت نشد</p>
    @endif


</div>
