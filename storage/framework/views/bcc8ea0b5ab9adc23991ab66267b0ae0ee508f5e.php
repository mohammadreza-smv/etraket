<?php if(isset($variation_param1) && sizeof($variation_param1)>0): ?>
    <?php

        $items=[];
        foreach ($variation_param1 as $param){
            $items[$param['id']]=$param['variation_value'];
        }
        $label='انتخاب '.e($variation_param1[0]->variation_name);
        $form->select($items,'params[Modules\priceVariation\Models\PriceVariationItems\param1]',$label,[],$param1_id);

    ?>
<?php endif; ?>

<?php if(isset($variation_param2) && sizeof($variation_param2)>0): ?>

    <?php
        $items=[];
        foreach ($variation_param2 as $param){
            $items[$param['id']]=$param['variation_value'];
        }
        $label='انتخاب '.e($variation_param2[0]->variation_name);
        $form->select($items,'params[Modules\priceVariation\Models\PriceVariationItems\param2]',$label,[],$param2_id);

    ?>

<?php endif; ?>
<?php /**PATH /home/teraketc/AppCode/modules/priceVariation/resource/views/panel/selectField.blade.php ENDPATH**/ ?>