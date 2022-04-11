<?php

use App\Lib\Jdf;

$Jdf=new Jdf();
?>
<div class="breadcrumb">

    <ul class="list-inline">
        <li>
            <a href="<?php echo e(url('admin')); ?>" class="router-link">
                <span class="fa fa-home"></span>
                <span>پیشخوان</span>
                <?php if(isset($data)): ?>
                    <v-icon>mdi-chevron-left</v-icon>
                <?php endif; ?>
            </a>
        </li>
        <?php if(isset($data) && is_array($data)): ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e($value['url']); ?>" class="router-link">
                        <span><?php echo e($value['title']); ?></span>
                        <?php if($key!=(sizeof($data)-1) || isset($_GET['trashed'])): ?>
                            <v-icon>mdi-chevron-left</v-icon>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <?php if(isset($_GET['trashed'])): ?>
            <li>
                <a>
                    <span>سطل زباله</span>
                </a>
            </li>
        <?php endif; ?>


        <li class="date_li">
            <v-icon color="white">mdi-calendar</v-icon>
            <span>امروز </span>
            <span><?php echo e($Jdf->jdate('l')); ?></span>
            <span><?php echo e($Jdf->jdate('j')); ?></span>
            <span><?php echo e($Jdf->jdate('F')); ?></span>
            <span><?php echo e($Jdf->jdate('Y')); ?></span>
        </li>
    </ul>
</div>
<?php /**PATH /home2/teraketc/AppCode/themes/AdminPanel/breadcrumb.blade.php ENDPATH**/ ?>