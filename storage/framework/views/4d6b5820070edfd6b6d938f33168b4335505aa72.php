<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
            ['title'=>'تنظیمات فروشگاه','url'=>url('admin/setting/shop')],
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $args['title']='تنظیمات فروشگاه';
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php
               $option=['url' => 'admin/setting/shop'];
               $form=new \App\Lib\FormBuilder($errors,$option);
            ?>

            <?php $form->textInput('shop_name','عنوان فروشگاه ',[],config('shop-info.shop_name')); ?>

            <?php $form->fileInput('shop_icon','ایکون فروشگاه  ',[]); ?>

            <?php $form->textInput('login_url','آدرس ورود به پنل مدیریت ',[],config('shop-info.login_url')); ?>

            <p class="message_text">برچسب ها با استفاده از (،) از هم جدا شود</p>

            <div style="padding-bottom:15px">
                <?php $form->tagBox('keywords','برچسب ها',[],config('shop-info.keywords')); ?>
            </div>

            <?php $form->textarea(
                'description','توضیحات مختصر در مورد فروشگاه (حداکثر 150 کاراکتر)',
                ['class'=>'total-width'],
                config('shop-info.description')
            ); ?>

            <?php $form->btn('ثبت اطلاعات', 'create'); ?>

            <?php $form->close(); ?>
         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/setting/resource/views/shop.blade.php ENDPATH**/ ?>