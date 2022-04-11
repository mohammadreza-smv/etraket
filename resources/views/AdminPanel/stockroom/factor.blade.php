<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>فاکتور</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('head')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <style>
        body{
            background-color: white !important;
        }
    </style>
</head>
<body>
    @php
       $Jdf=new \App\Lib\Jdf();
       $count=8;
       $size=sizeof($input['stockroom_products']);
       $n=ceil(( $size/$count));

    @endphp
    <div
        class="container"
        style="display:flex;justify-content: center;margin-top:20px"
        id="prind_div"
      >
        <button onclick="printFactor()" class="btn btn-danger factor_btn">پرینت فاکتور</button>
      </div>
    @for ($i = 0; $i < $n; $i++)
      <div class="container factor print_page">
        <div class="line"></div>
        <div class="header_factor">
            @php
                $p=$i+1;
            @endphp
            <div>
                <p>
                    <span>تاریخ : {{ $Jdf->jdate('H:i:s',$input['stockroomEvent']->time) }} / {{ $Jdf->jdate('d-m-Y',$input['stockroomEvent']->time) }}
                    </span>
                    <span>
                        شماره فاکتور : {{ replace_number($input['stockroomEvent']->id) }}
                    </span>
                    <span>
                        تعداد محصول : {{ replace_number(sizeof($input['stockroom_products'])) }}
                    </span>
                    @if ($n>1)
                    <span>
                        برگه {{ replace_number($p) }} از {{ replace_number($n) }}
                    </span>
                    @endif
                </p>
            </div>
            <div class="title">
                @if ($type=="input")
                   ورود کالا به انبار
                @else
                    خروج کالا از انبار
                @endif
            </div>
            <div>
                <img src="{{ asset(env("SHOP_LOGO",'files/images/shop_icon.jpg')) }}" class="shop_logo">
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>تصویر </th>
                    <th>عنوان محصول</th>
                    <th>فروشنده</th>
                    <th>گارانتی</th>
                    <th>رنگ</th>
                    <th>تعداد</th>
                </tr>
            </thead>
            <tbody>
               <?php $j=(($i-0)*$count) ; ?>
               @foreach ($input['stockroom_products'] as $key=>$value)
                   @if ($key>=$j && $key<$j+$count)
                   <tr>
                    <td>{{ replace_number(++$key) }}</td>
                    <td>
                      <img src="{{ url('files/thumbnails/'.$value->getProductWarranty->getProduct->image_url) }}" class="product_pic stockroom_product">
                    </td>
                    <td>{{ $value->getProductWarranty->getProduct->title }}</td>
                    <td>{{ $value->getProductWarranty->getSeller->brand_name }}</td>
                    <td>{{ $value->getProductWarranty->getWarranty->name }}</td>
                    <td style="width:150px">
                         @if($value->getProductWarranty->getColor->id>0)
                            @if($value->getProductWarranty->getColor->type==1)
                                <span style="background:#{{ $value->getProductWarranty->getColor->code }}" class="color_td">
                                       <span style="color:white">{{ $value->getProductWarranty->getColor->name }}</span>
                                   </span>
                            @else
                                <span>سایز : {{ $value->getProductWarranty->getColor->name }}</span>
                            @endif
                         @endif
                    </td>
                    <td>{{ replace_number($value->product_count) }}</td>
                </tr>
                   @endif
               @endforeach
            </tbody>
        </table>

         @if ($i==($n-1))
         <div class="factor_tozihat">
            <span>کالا های فوق توسط </span>
            {{ $input['stockroomEvent']->getUser->name }}
            <span>
                @if ($type=="input")
                  به  {{ $input['stockroomEvent']->getStockroom->name }} اضافه شده
                @else
                    از  {{ $input['stockroomEvent']->getStockroom->name }} خارج شده
                @endif
            </span>
        </div>

        <div class="factor_footer">
            <span>
                مهر و امضای تحویل گیرنده
            </span>

            <span>
                مهر و امضای تحویل دهنده
            </span>

        </div>
         @endif
    </div>
    @endfor

 <script>
    printFactor=function(){
        document.getElementById('prind_div').style.display='none';
        window.print();
    };
    window.onafterprint = function() {
       document.getElementById('prind_div').style.display='flex';
    };
</script>
</body>
</html>
