<?php
$mapLinks=[
    ['title'=>'محصولات فروشندگان دنبال شده','link'=>url('seller/followed/products')]
]
?>
<?php echo $__env->make('front-theme::views.cat_product',[
    'mapLinks'=>$mapLinks,
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/site/followed_products.blade.php ENDPATH**/ ?>