<table class="products">
    <thead>
    <tr>
        <th>ردیف</th>
        <th>شناسه کالا</th>
        <th>شرح کالا</th>
        <th>آمر</th>
        <th>تعداد</th>
        <th>مبلغ واحد (ریال)</th>
        <th>مبلغ کل (ریال)</th>
        <th>تخفیف (ریال)</th>
        <th>
            مبلغ کل پس از تخفیف (ریال)
        </th>
    </tr>
    </thead>

    <tbody>
       <?php $j=1;?>
        @foreach($order->submissions as $submission)

            @foreach($submission->products as $product)

                @if($product->product)
                    <tr>
                        <td>{{ replace_number($j) }}</td>
                        <td>{{ replace_number($product->product->id) }}</td>
                        <td>
                            {{ $product->product->title }} -
                            <?php
                               $variationDetail1=getVariationDetail($product,'param1');
                               $variationDetail2=getVariationDetail($product,'param2');
                            ?>
                            @if($variationDetail1)
                                <span>{{ $variationDetail1['label'] }} : {{ $variationDetail1['value'] }}</span>
                            @endif

                            @if($variationDetail2)
                                ,<span>{{ $variationDetail2['label'] }} : {{ $variationDetail2['value'] }}</span>
                            @endif

                        </td>
                        <td>
                            @if($product->seller)
                                {{  $product->seller->brand_name }}
                            @endif
                        </td>
                        <td>{{ replace_number($product->product_count) }}</td>
                        <td>{{ replace_number(number_format(($product->product_price1*10))) }}</td>
                        <td>{{ replace_number(number_format(($product->product_price1*10)*$product->product_count)) }}</td>
                        <td>
                            <?php
                              $discount=(($product->product_price1*10)*$product->product_count) - (($product->product_price2*10)*$product->product_count)
                            ?>
                            {{ replace_number(number_format($discount)) }}
                        </td>
                        <td>{{ replace_number(number_format(($product->product_price2*10)*$product->product_count)) }}</td>
                    </tr>
                @endif

                <?php $j++; ?>
            @endforeach

        @endforeach
    </tbody>
</table>
