<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .title{
            text-align: center;
            border-bottom: 1px dashed #d5dadd;
            padding:20px;
            font-family: Tahoma;
            font-size: 20px;
            font-weight: bold;
        }
        .product_box{
            display: flex;
            border-top: 1px dashed #d5dadd;
            padding-top: 25px;
            width: 100%;
        }
        .product_box img{
            width: 200px;
            height: 200px;
            margin-left: 10px
        }
        .product_link{
            background-color: #00bfd6 !important;
            border:1px solid #00bfd6 !important;
            padding:10px;
            color: white !important;
            text-decoration: none !important;
        }
        .div{
            direction: rtl;
            text-align: right;
            font-size: 15px;
            font-family: Tahoma;
        }
    </style>
</head>
<body>
      <div style="width:95%;margin:auto;">
        <p class="title">
            پیشنهاد کالا
        </p>
        <div class="div">
            <p>سلام</p>
            <p>
              <span>{{ $user_name }}</span>  مشاهده و خرید این محصول را به شما پیشنهاد میکنید
            </p>
            <div class="product_box">
                <img src="{{ url('files/thumbnails/'.$product->image_url) }}" alt="{{ $product->title }}">
                <div>
                    <p>{{ $product->title }}</p>
                    <p style="padding-top:10px">
                        <span>هزینه محصول : </span>
                        {{ replace_number(number_format($product->price)) }} تومان
                    </p>
                </div>
            </div>

            <p style="text-align:center;margin-top:30px">
                <a href="{{ get_product_url($product) }}" class="product_link">
                    مشاهده و خرید محصول
                </a>
            </p>
        </div>
      </div>
</body>
</html>
