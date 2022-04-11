<?php
    $mapLinks=[
        ['title'=>$brand->brand_name,'link'=>url('brand/'.$brand->brand_ename)]
    ]
?>
<?php echo $__env->make('front-theme::views.cat_product',[
    'before_filter'=>'brands::shop.brand-info',
    'mapLinks'=>$mapLinks
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/teraketc/AppCode/modules/brands/resource/views/shop/products.blade.php ENDPATH**/ ?>