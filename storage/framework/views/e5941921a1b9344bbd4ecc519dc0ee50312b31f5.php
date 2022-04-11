<?php $name='params[Modules\colors\Models\Color]'; ?>
<color-combobox label="انتخاب رنگ"
                :items="<?php echo e(json_encode($colors)); ?>"
                default="<?php echo e($color_id); ?>"
                name="<?php echo e($name); ?>"
>

</color-combobox>
<?php /**PATH /home/teraketc/AppCode/modules/colors/resource/views/selectField.blade.php ENDPATH**/ ?>