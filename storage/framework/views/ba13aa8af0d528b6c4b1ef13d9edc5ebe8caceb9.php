<?php
    $mapLinks=[
        ['title'=>$seller->brand_name,'link'=>url('seller/'.$seller->id)]
    ]
?>
<?php echo $__env->make('front-theme::views.cat_product',[
    'before_filter'=>'sellers::site.shop-info',
    'mapLinks'=>$mapLinks,
    'before_products'=>'sellers::site.shop-description'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/site/products.blade.php ENDPATH**/ ?>