<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>فاکتور فروش</title>
    <link href="{{ url('modules/factor.css?id=dsbhjhgddda') }}" rel="stylesheet">
</head>
<body>

<div class="container" style="display: flex;justify-content: center;margin-top: 20px" id="print_div">

    <button onclick="printFactor()" class="btn btn-danger factor_btn">پرینت فاکتور</button>

</div>

<div class="page">

    <h1 style="text-align: center">
        صورتحسـاب     نيابتـي فـروش كـالا و ارائه خدمت
    </h1>

    <table style="width: 100%">
        <tbody>
           <tr>

               <td style="width: 1.8cm;height: 2.5cm;">
                   <div class="header-item-wrapper">
                       <div class="portait">حق‌العمل کار</div>
                   </div>
               </td>

               <td style="height: 2.5cm;">
                   <div class="info-box">
                       @includeIf('orders::factor.shop-info')
                   </div>
               </td>

               <td style="height: 2.5cm;width: 4.5cm">
                   <div class="info-box">
                       <div style="padding: 10px">
                           <?php $order_id=$order->order_id; ?>
                           <p style="text-align: center">
                               <span>شماره فاکتور : </span>
                               <span>{{ replace_number($order_id) }}</span>
                           </p>
                           <?php echo DNS1D::getBarcodeHTML($order_id, 'C128'); ?>
                       </div>
                   </div>
               </td>

           </tr>
           <tr>
               <td style="width: 1.8cm;height: 2.5cm;">
                   <div class="header-item-wrapper">
                       <div class="portait">خریدار</div>
                   </div>
               </td>

               <td style="min-height: 2.5cm;height: auto;" colspan="2">

                   <div class="info-box">
                       @includeIf('orders::factor.user-detail')
                   </div>

               </td>

           </tr>
        </tbody>
    </table>

    @include('orders::factor.products_table')

    <div class="factor_footer">
        <div>
            مهر و امضای تحویل گیرنده
        </div>

        <div>
            مهر و امضای تحویل دهنده
        </div>

    </div>

</div>

<script>
    printFactor=function () {
        document.getElementById('print_div').style.display='none';
        window.print();
    }
    window.onafterprint = function() {
        document.getElementById('print_div').style.display='flex';
    };
</script>
</body>
</html>
