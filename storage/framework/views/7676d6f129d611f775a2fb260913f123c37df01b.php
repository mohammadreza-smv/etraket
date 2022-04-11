<seller-page-info>
    <template v-slot:seller-page-info>

        <a href="<?php echo e(url('seller/'.$seller->id)); ?>" class="seller-brand">
            <?php echo e($seller->brand_name); ?>

        </a>

        <?php
            $jdf=new \App\Lib\Jdf();
            $lastDate=$seller->updated_at->getTimestamp();
        ?>

        <follow-btn follow="<?php echo e($follow); ?>"
                    seller_id="<?php echo e($seller->id); ?>"
                    device="<?php echo e(view_type); ?>"
                    followers_count="<?php echo e($followers_count); ?>"
                    last-date="<?php echo e(sellerLastTimeOnline($lastDate)); ?>"
        >
        </follow-btn>
    </template>
</seller-page-info>
<?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/site/shop-info.blade.php ENDPATH**/ ?>