<v-expansion-panels>

    <div class="shipping_data_box  payment-products">

        <?php $i=1;  ?>

        <?php $__currentLoopData = $send_order_data['product_with_sending_type'][1][$send_type]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2=>$value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if($key2=='product_key'): ?>

                        <v-expansion-panel :key="<?php echo e($i); ?>">
                            <?php if ($__env->exists('cart::shipping.order_products',['data'=>$value2,'submission_info'=>null,'sending_time'=>$key])) echo $__env->make('cart::shipping.order_products',['data'=>$value2,'submission_info'=>null,'sending_time'=>$key], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </v-expansion-panel>
                        <?php $i++ ?>
                    <?php else: ?>

                        <?php $__currentLoopData = $value2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key3=>$value3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php if($key3=='product_key'): ?>
                                <v-expansion-panel :key="<?php echo e($i); ?>">
                                    <?php if ($__env->exists('cart::shipping.order_products',[
                                      'data'=>$value3,
                                      'submission_info'=>$value2,
                                      'sending_time'=>$key,
                                      'sending_method'=>$key2
                                  ])) echo $__env->make('cart::shipping.order_products',[
                                      'data'=>$value3,
                                      'submission_info'=>$value2,
                                      'sending_time'=>$key,
                                      'sending_method'=>$key2
                                  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </v-expansion-panel>
                                <?php $i++ ?>
                            <?php endif; ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
</v-expansion-panels>


<?php /**PATH /home2/teraketc/AppCode/modules/cart/resource/views/checkout-products.blade.php ENDPATH**/ ?>