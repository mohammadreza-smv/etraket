<?php if(!isset($type) || $type=='select'): ?>
    <?php $array=[]; ?>

    
   <?php
      
        $property='param'.$num.'_id';
        $relation='param'.$num;
        $param_key='param'.$num.'_type';
        $p_id=$num==1 ? $param1_id : $param2_id;
        if(!function_exists('check')){
            function check($variation,$num,$param1_id){
              if($num==2){
                     return ($param1_id==$variation->param1_id);
              }
             else{
                 return true;
             }
        }
        }
        
    ?>
    
    
      <?php if($num==2): ?>
        <p>انتخاب رنگ</p>
    <?php endif; ?>

    <ul class="color_ul">
        <?php $__currentLoopData = $product->PriceVariation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php if(!array_key_exists($variation->$property,$array) && check($variation,$num,$param1_id)): ?>

                   <?php $array[$variation->$property]=$variation->$property; ?>

                   <?php if($variation->$relation): ?>
                            <li id="color_variation_<?php echo e($key); ?>" class="color_li variation_item <?php if($p_id==$variation->$property): ?> active <?php endif; ?>"
                                data-param-id="<?php echo e($variation->$property); ?>"
                                data-param-type="<?php echo e($variation->$param_key); ?>"
                                data-param-key="<?php echo e($num); ?>"
                                onclick="vm.$root.$emit('update_variation','color_variation_<?php echo e($key); ?>')"
                            >
                                <label style="display: flex">
                                    <div class="ui_variant_shape" style="background:#<?php echo e($variation->$relation->code); ?>"></div>
                                    <span class="color_name"><?php echo e($variation->$relation->name); ?></span>
                                </label>
                            </li>
                   <?php endif; ?>

            <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

<?php endif; ?>

<?php /**PATH /home2/teraketc/AppCode/modules/colors/resource/views/variationItems.blade.php ENDPATH**/ ?>