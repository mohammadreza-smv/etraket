<?php if($product->PriceVariation && sizeof($product->PriceVariation)>0): ?>

    <?php

    $price_variation=isset($price_variation) ? $price_variation : $product->PriceVariation[0];

    $param1_id=$price_variation->param1_id;
    $param1_type=$price_variation->param1_type;

    $param2_id=$price_variation->param2_id;
    $param2_type=$price_variation->param2_type;

    ?>
    <?php echo $__env->make('position_view',['name'=>'before_shop_variation_detail','args'=>['variation'=>$price_variation]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <variation-detail product_id="<?php echo e($product->id); ?>">

        <template v-slot:default>

            <input type="hidden" data-id="<?php echo e($param1_type); ?>" id="variation_param1" value="<?php echo e($param1_id); ?>">

            <input type="hidden" data-id="<?php echo e($param2_type); ?>" id="variation_param2" value="<?php echo e($param2_id); ?>">

            <?php echo $__env->make('position_view',['name'=>'before_variation_detail','type'=>'content'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php if($param1_type): ?>
                <?php
                $file=explode('\\',$param1_type);
                $dir=$file[1];
                $includeFile=$dir.'::variationItems';
                ?>
                <?php if ($__env->exists($includeFile,['num'=>1,'type'=>'item'])) echo $__env->make($includeFile,['num'=>1,'type'=>'item'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if($param2_type): ?>
                <?php
                $file=explode('\\',$param2_type);
                $dir=$file[1];
                $includeFile=$dir.'::variationItems';
                ?>
                <?php if ($__env->exists($includeFile,['num'=>2,'type'=>'item'])) echo $__env->make($includeFile,['num'=>2,'type'=>'item'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php
            $send_time=$price_variation->send_time;
            ?>
            <?php if($send_time>-1): ?>
                <div class="info_item_product">

                    <div>
                        <v-icon>mdi-bus-clock</v-icon>

                        <?php if($send_time==0): ?>
                            <span>آماده ارسال</span>
                        <?php else: ?>
                            <span>ارسال از <?php echo e(replace_number($send_time)); ?> روز کاری آینده </span>
                        <?php endif; ?>
                    </div>

                    <div>
                        <v-icon onclick="vm.$root.$emit('setSlot','senddetail',' جزئیات ارسال ');">mdi-chevron-left</v-icon>
                    </div>
                </div>
            <?php endif; ?>

            <?php echo $__env->make('position_view',['name'=>'after_variation_detail','type'=>'content'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php
            $product_price1=$price_variation->price1;
            $product_price2=$price_variation->price2;
            ?>

            <div class="discount_price">
                    <?php
                        $d=($product_price2/$product_price1)*100;
                        $d=100-$d;
                        $d=round($d);
                    ?>
                   <?php if($d>0): ?>
                        <span class="price-discount-badge">
                          <?php if($d>0): ?>
                              ٪<?php echo e(replace_number($d)); ?>

                          <?php endif; ?>
                        </span>

                   <?php else: ?>
                      <span></span>
                   <?php endif; ?>
                <div>
                    <?php if($d>0): ?>

                        <del>
                            <?php echo e(replace_number(number_format($product_price1))); ?>

                        </del>
                    <?php endif; ?>
                    <p class="price">
                        <?php echo e(replace_number(number_format($product_price2)).' تومان'); ?>

                    </p>
                </div>

            </div>

        </template>

        <template v-slot:senddetail>

            <p style="padding:15px">
                <?php if($send_time==0): ?>
                    این کالا در حال حاضر در انبار <?php echo e(config('shop-info.shop_name')); ?> موجود ، آماده پردازش و ارسال است
                <?php else: ?>
                    این کالا در انبار فروشنده موجود است، برای ارسال باید برای مدت زمان ذکر شده منتظر بمانید
                <?php endif; ?>
            </p>

        </template>

    </variation-detail>
<?php else: ?>

<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/modules/priceVariation/resource/views/product/detail-view.blade.php ENDPATH**/ ?>