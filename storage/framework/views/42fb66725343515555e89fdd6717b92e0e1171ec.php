<?php
  $var=$args['id'];
  $var=str_replace('-',"_",$var);
?>
<?php if(isset(${$var})): ?>
    <?php if(!array_key_exists('load_type',${$var}) || ${$var}['load_type']==0): ?>
        <?php if ($__env->exists('horizontal_product_list_view',[
           'title'=>${$var}['title'],
           'products'=>${$var}['products'],
           'args'=>$args
        ])) echo $__env->make('horizontal_product_list_view',[
           'title'=>${$var}['title'],
           'products'=>${$var}['products'],
           'args'=>$args
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php elseif(array_key_exists('load_type',${$var}) || ${$var}['load_type']==1): ?>
        <?php
            $shop_product_url=shop_product_url_theme();
        ?>
        <horizontal-product-list
            :args="<?php echo e(json_encode(${$var})); ?>"
            shop_product_url="<?php echo e($shop_product_url); ?>"
        ></horizontal-product-list>
    <?php endif; ?>

<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/themes/theme1/views/horizontal_product_list.blade.php ENDPATH**/ ?>