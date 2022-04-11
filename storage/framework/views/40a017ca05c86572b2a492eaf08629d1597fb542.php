<?php $__env->startSection('panel-content'); ?>

    <?php $args=['title'=>'ارسال پیام جدید']; ?>



    <?php if (isset($component)) { $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\UserPanelBox::class, ['args' => $args]); ?>
<?php $component->withName('user-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

        <div class="message_form">
            <?php
            $option=['url' => 'user/profile/messages','files'=>true];
            $form=new \App\Lib\FormBuilder($errors,$option, 'create',[]);
            ?>

            <?php $form->textInput('title','عنوان',['validate'=>'required','class'=>'total-width']); ?>

            <?php $form->textarea('content','محتوای پیام',['validate'=>'required','class'=>'total-width']); ?>

            <?php $form->fileInput('pic','انتخاب فایل',['class'=>'small']); ?>

            <?php $form->btn('ارسال پیام', 'create'); ?>

            <?php $form->close(); ?>
        </div>

        <response-dialog></response-dialog>

     <?php if (isset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950)): ?>
<?php $component = $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950; ?>
<?php unset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.user-panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/messages/resource/views/userPanel/add_message.blade.php ENDPATH**/ ?>