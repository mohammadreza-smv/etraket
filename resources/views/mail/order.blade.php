<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .content{
            width: 100%;
            direction: rtl;
            text-align: right;
            font-family:Tahoma;
        }
        .content_box{
            width: 90%;
            margin: 20px auto;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .order_table_info tr td span {
            color: black !important;
            width: 100%;
            display: block;
        }
        .order_table_info tr td {
            color: #bababa;
            width: 50%;
            font-family:Tahoma;
            font-size: 15px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
        }
        .product_list_data tr td{
            color: black;
            font-family:Tahoma;
            font-size: 15px;
        }
        .product_list_data tr td {
           border-left: 1px solid #e7e7e7;
           text-align: center;
           vertical-align: middle;
        }
        .product_list_data tr td ul{
            text-align:  right !important;
            padding-right: 5px !important
        }
        .product_list_data tr td ul li{
            list-style: none;
        }
        .header{
            width: 100%;
            padding-top: 30px;
            padding-bottom:30px;
            text-align: center;
            background-color:#f9f9f9;
            font-size: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
      <div class="content">
          
            <div class="content_box">

                <div class="header">
                    <h5>{{ env('SHOP_NAME','') }}</h5>
                </div>

                <table class="table table-bordered order_table_info">

                    <tr>
                        <td>
                            تحویل گیرنده:
                            <span>{{ $order->getAddress->name }}</span>
                        </td>
                        <td>
                            شماره تماس تحویل گیرنده:
                            <span>{{ replace_number($order->getAddress->mobile ) }}</span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            آدرس تحویل گیرنده:
                            <span>{{ $order->getAddress->getProvince->name.' '. $order->getAddress->getCity->name.' '. $order->getAddress->address }}</span>
                        </td>
                        <td>
                            تعداد مرسوله:
                            <span>{{ replace_number(sizeof($order->getOrderInfo)) }}</span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            مبلغ قابل پرداخت:
                            <span>{{ replace_number(number_format($order->price)) }} تومان</span>
                        </td>
                        <td>
                            مبلغ کل :
                            <span>{{ replace_number(number_format($order->total_price)) }} تومان</span>
                        </td>
                    </tr>

                    @if(!empty($order->gift_value) && $order->gift_value>0)
                        <tr>
                            <td>
                                مبلغ کارت هدیه:
                                <span>{{ replace_number(number_format($order->gift_value)) }} تومان</span>
                            </td>
                            <td>
                                کد کارت هدیه:
                                <span>{{ $order->getGiftCart->code }} </span>
                            </td>
                        </tr>
                    @endif

                    @if(!empty($order->discount_value) && $order->discount_value>0)
                        <tr>
                            <td>
                                مبلغ کد تخفیف:
                                <span>{{ replace_number(number_format($order->discount_value)) }} تومان</span>
                            </td>
                            <td>
                                کد تخفیف:
                                <span>{{ $order->discount_code }} </span>
                            </td>
                        </tr>
                    @endif
                </table>

                <h4>محصولات</h4>

                <table class="table table-bordered product_list_data">
                    <tr>
                        <th>نام محصول</th>
                        <th>تعداد</th>
                        <th>قیمت واحد</th>
                        <th>قیمت کل</th>
                        <th>تخفیف</th>
                        <th>قیمت نهایی</th>
                    </tr>

                    @foreach($order->getOrderInfo as $key=>$value)
                        @foreach($order_data['row_data'][$value->id] as $product)

                            <tr>
                               <td class="product__info">
                                     <div>
                                        <ul>
                                            <li class="title">
                                                {{ $product['title'] }}
                                             </li>
                                             @if($product['color_id']>0)
                                                <li>
                                                            <span> رنگ :‌</span>
                                                            <span>{{ $product['color_name'] }}</span>
                                                </li>
                                             @endif
                                              <li>
                                                 <span>گارانتی :‌ ‌</span>
                                                 <span>{{ $product['warranty_name'] }}</span>
                                              </li>
                                        </ul>
                                     </div>
                                </td>
                                <td>
                                    {{ replace_number($product['product_count']) }}
                                </td>
                                <td>
                                    {{ replace_number(number_format($product['product_price1'])) }} تومان
                                </td>
                                <td>
                                    {{ replace_number(number_format($product['product_price1']*$product['product_count'])) }} تومان
                                </td>
                                <td>
                                    <?php
                                    $discount=(($product['product_price1']*$product['product_count'])-($product['product_price2']*$product['product_count']));
                                    ?>
                                    {{ replace_number(number_format($discount)) }} تومان
                                </td>
                                <td>
                                     {{ replace_number(number_format($product['product_price2']*$product['product_count'])) }} تومان
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
                
                <a href="{{ url('user/profile/orders/'.$order->id) }}">
                    {{ url('user/profile/orders/'.$order->id) }}
                </a>
            </div>

      </div>
</body>
</html>