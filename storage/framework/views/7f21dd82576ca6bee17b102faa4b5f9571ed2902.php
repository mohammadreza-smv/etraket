<?php if(isset($design_config)): ?>

    <?php
        if(defined('locationParam')){
            $location=str_replace(':widgetParam',locationParam,$location);
        }
        else{
            $location=str_replace(':widgetParam','',$location);
        }
        if(array_key_exists($location,$design_config)){
            $rows=$design_config[$location]['rows'];
            $tags=$design_config[$location]['tags'];
        }
    ?>

    <?php if(array_key_exists($location,$design_config)): ?>

        <div id="<?php echo e($location); ?>">
            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div id="<?php echo e($row['id']); ?>">

                    <?php if(array_key_exists('child',$row)): ?>
                        <?php $__currentLoopData = $row['child']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php if($value['type']=='html'): ?>
                                <?php if ($__env->exists('themes::widgets.'.$value['tag'],['args'=>$value])) echo $__env->make('themes::widgets.'.$value['tag'],['args'=>$value], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>

                            <?php if($value['type']=='widget'): ?>

                                <?php if ($__env->exists('themes::widgets.widget-view',['args'=>$value,'row'=>$row])) echo $__env->make('themes::widgets.widget-view',['args'=>$value,'row'=>$row], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>

                            <?php if($value['type']=='box'): ?>
                                <div id="<?php echo e($value['id']); ?>">
                                    <?php $__currentLoopData = $value['child']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2=>$value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value2['type']=='html'): ?>
                                            <?php if ($__env->exists('themes::widgets.'.$value2['tag'],['args'=>$value2])) echo $__env->make('themes::widgets.'.$value2['tag'],['args'=>$value2], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endif; ?>

                                        <?php if($value2['type']=='widget'): ?>
                                            <?php if ($__env->exists('themes::widgets.widget-view',['args'=>$value2,'row'=>$row])) echo $__env->make('themes::widgets.widget-view',['args'=>$value2,'row'=>$row], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endif; ?>

                                        <?php if($value2['type']=='box'): ?>
                                             <div id="<?php echo e($value2['id']); ?>">

                                                 <?php $__currentLoopData = $value2['child']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key3=>$value3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                     <?php if($value3['type']=='html'): ?>
                                                         <?php if ($__env->exists('themes::widgets.'.$value3['tag'],['args'=>$value3])) echo $__env->make('themes::widgets.'.$value3['tag'],['args'=>$value3], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                     <?php endif; ?>

                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                             </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

<?php else: ?>

<?php endif; ?>

<?php /**PATH /home2/teraketc/AppCode/modules/themes/resource/views/widgets/view.blade.php ENDPATH**/ ?>