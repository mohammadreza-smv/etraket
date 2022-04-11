<?php
    $args=['title'=>'اطلاعات حساب کاربری'];
    $j=0;
?>
<?php if (isset($component)) { $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\UserPanelBox::class, ['args' => $args]); ?>
<?php $component->withName('user-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

    <register-detail>

        <table class="table table-bordered user-detail-table">
            <?php for($i=0;$i<ceil(sizeof($personal_user_detail)/2);$i++): ?>
                <tr>
                    <td <?php if(!array_key_exists(($j+1),$personal_user_detail)): ?> colspan="2" style="text-align: center" <?php endif; ?>>

                        <?php
                            $editValue=$personal_user_detail[$j]['value'];
                            if(array_key_exists("value2",$personal_user_detail[$j]))
                            {
                                $editValue=$personal_user_detail[$j]['value2'];
                            }
                        ?>
                        <a>
                           <div>
                               <?php echo e($personal_user_detail[$j]['title']); ?>

                               <span> <?php echo e($personal_user_detail[$j]['value']); ?></span>
                           </div>
                           <div onclick="vm.$root.$emit('edit_user_<?php echo e($personal_user_detail[$j]['attr']); ?>',
                               '<?php echo e($editValue); ?>')">
                               <v-icon>mdi-circle-edit-outline</v-icon>
                           </div>
                       </a>
                    </td>
                    <?php $j++ ?>
                    <?php if(array_key_exists($j,$personal_user_detail)): ?>
                        <td>
                            <?php
                                 $editValue=$personal_user_detail[$j]['value'];
                                 if(array_key_exists("value2",$personal_user_detail[$j]))
                                 {
                                     $editValue=$personal_user_detail[$j]['value2'];
                                 }
                            ?>
                            <a>
                                <div>
                                    <?php echo e($personal_user_detail[$j]['title']); ?>

                                    <span> <?php echo e($personal_user_detail[$j]['value']); ?></span>
                                </div>
                                <div onclick="vm.$root.$emit('edit_user_<?php echo e($personal_user_detail[$j]['attr']); ?>','<?php echo e($editValue); ?>')">
                                   <v-icon>mdi-circle-edit-outline</v-icon>
                                </div>
                            </a>
                        </td>
                        <?php $j++ ?>
                    <?php endif; ?>

                </tr>
            <?php endfor; ?>

        </table>

    </register-detail>


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
<?php /**PATH /home2/teraketc/AppCode/modules/users/resource/views/user-panel/register-detail.blade.php ENDPATH**/ ?>