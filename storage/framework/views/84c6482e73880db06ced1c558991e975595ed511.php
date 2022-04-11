<?php if($product->PriceVariation && sizeof($product->PriceVariation)>0): ?>

    <?php
          $price_variation=isset($price_variation) ? $price_variation : $product->PriceVariation[0];
          $param1_id=$price_variation->param1_id;
          $param1_type=$price_variation->param1_type;
          $param2_id=$price_variation->param2_id;
          $param2_type=$price_variation->param2_type;
    ?>

    <?php if($param1_type): ?>
        <?php
            $file=explode('\\',$param1_type);
            $dir=$file[1];
            $includeFile=$dir.'::variationItems';
        ?>
        <?php if ($__env->exists($includeFile,['num'=>1,'type'=>'select'])) echo $__env->make($includeFile,['num'=>1,'type'=>'select'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if($param2_type): ?>
        <?php
        $file=explode('\\',$param2_type);
        $dir=$file[1];
        $includeFile=$dir.'::variationItems';
        ?>
        <?php if ($__env->exists($includeFile,['num'=>2,'type'=>'select'])) echo $__env->make($includeFile,['num'=>2,'type'=>'select'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

<?php endif; ?>
<?php /**PATH /home2/teraketc/AppCode/modules/priceVariation/resource/views/product/params-view.blade.php ENDPATH**/ ?>