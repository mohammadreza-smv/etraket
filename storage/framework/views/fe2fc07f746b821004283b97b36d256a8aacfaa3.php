<?php $__env->startSection('content'); ?>

    <div>

        <?php
             $array['users']= 'مدیریت کاربران';
             $array['sellers']= 'مدیریت فروشندگان';
        ?>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
             ['title'=>$array[$url_param],'url'=>url('admin/'.$url_param)],
             ['title'=>'مدیریت پیام ها','url'=>url('admin/'.$url_param.'/'.$user->id.'/messages')],
             ['title'=>'ارسال پیام جدید','url'=>url('admin/'.$url_param.'/'.$user->id.'/messages/create')],
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $attr=$types[$type]['attr'];
            $name=$user->$attr!='' ? $user->$attr : $user->mobile;
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

             <?php $__env->slot('header'); ?> 

                ارسال پیام به
                <?php echo e($name); ?>


             <?php $__env->endSlot(); ?>

            <?php
                $option=['url' =>'admin/'.$url_param.'/'.$user->id.'/messages'];
                $form=new \App\Lib\FormBuilder(null,$option, 'create',[]);
            ?>

            <?php $form->textInput('title','عنوان',['validate'=>'required','class'=>'total-width']); ?>

            <?php $form->textarea('content','محتوای پیام',['validate'=>'required','class'=>'total-width']); ?>

            <?php $form->fileInput('pic','انتخاب فایل',['class'=>'small']); ?>

            <?php $form->btn('ارسال پیام','edit'); ?>

            <?php echo Form::close(); ?>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/messages/resource/views/panel/add_message.blade.php ENDPATH**/ ?>