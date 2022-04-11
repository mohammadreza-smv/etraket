<?php
   $cartCount=\Modules\cart\Models\Cart::get_product_count();
?>
<mobile-app-bar shop_name="<?php echo e(config('shop-info.shop_name')); ?>">

    <template v-slot:cat_list>
        <?php echo $__env->make('front-theme::views.mobile.catList', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </template>

    <template v-slot:items>

        <a href="<?php echo e(url('/Cart')); ?>" class="router-link">
            <v-badge
                content="<?php echo e($cartCount>0 ? replace_number($cartCount) : ''); ?>"
                value="<?php echo e($cartCount>0 ? replace_number($cartCount) : ''); ?>"
                overlap dark
                color="red"
            >
                <v-icon>
                    mdi-cart-outline
                </v-icon>
            </v-badge>
        </a>

        <a href="<?php echo e(url('/user/profile/')); ?>" class="router-link">
            <v-icon>
                mdi-account
            </v-icon>
        </a>

    </template>

</mobile-app-bar>

<header-search class="mobile-theme"></header-search>

<select-cites selected="<?php echo e(Cookie::get('selected_shop_cites')); ?>"></select-cites>
<?php /**PATH /home/teraketc/AppCode/themes/theme1/include/mobile-app-bar.blade.php ENDPATH**/ ?>