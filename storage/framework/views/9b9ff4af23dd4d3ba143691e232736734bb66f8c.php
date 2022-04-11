<mobile-theme-question-list
    product_id="<?php echo e($product->id); ?>"
    shop_name="<?php echo e(config('shop-info.shop_name')); ?>"
    auth="<?php echo e(Auth::check() ? 'ok' : 'no'); ?>"
></mobile-theme-question-list>
<?php /**PATH /home/teraketc/AppCode/modules/questions/resource/views/mobile/question_list.blade.php ENDPATH**/ ?>