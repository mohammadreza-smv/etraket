<?php $__env->startSection('panel-content'); ?>

    <?php
         $args=['title'=>'اطلاعات شخصی'];
    ?>
    <?php if (isset($component)) { $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\UserPanelBox::class, ['args' => $args]); ?>
<?php $component->withName('user-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

        <div class="profile_item_list" style="margin:0px 8px !important;">

            <?php $__currentLoopData = $personal_user_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                      $editValue=$detail['value'];
                      if(array_key_exists("value2",$detail))
                      {
                          $editValue=$detail['value2'];
                      }
                ?>
                <div>

                    <div class="profile_item_header">

                        <div>
                            <?php echo e($detail['title']); ?>

                            <span class="profile-detail-value"> <?php echo e($detail['value']); ?></span>
                        </div>
                        <div onclick="vm.$root.$emit('edit_user_<?php echo e($detail['attr']); ?>','<?php echo e($editValue); ?>')">                            <v-icon>mdi-chevron-left</v-icon>
                        </div>

                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </div>

        <user-edit-name></user-edit-name>

        <user-edit-mobile></user-edit-mobile>

        <user-edit-bank_card_number></user-edit-bank_card_number>

        <user-national_identity_number></user-national_identity_number>

        <user-edit-email></user-edit-email>

        <date-of-birth></date-of-birth>
     <?php if (isset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950)): ?>
<?php $component = $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950; ?>
<?php unset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.mobile.user-panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/users/resource/views/user-panel/mobile//additional-info.blade.php ENDPATH**/ ?>