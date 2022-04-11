<?php if($variation->offers_last_time>time() && $variation->offers==1): ?>
    <offer-time second="<?php echo e(($variation->offers_last_time-time())); ?>"></offer-time>
<?php endif; ?>


<?php /**PATH /home/teraketc/AppCode/modules/incredibleOffers/resource/views/product/page_counter.blade.php ENDPATH**/ ?>