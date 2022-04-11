<?php $__env->startSection('content'); ?>

    <div>

        <?php
            $args=['title'=>'ویرایش پروفایل'];
        ?>

        <?php if (isset($component)) { $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde = $component; } ?>
<?php $component = $__env->getContainer()->make(Modules\sellers\components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('seller-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
             <seller-profile>

                  <template v-slot:step1>

                      <?php
                             $option=['url' =>url('sellers/panel/profile')];
                             $form=new \App\Lib\FormBuilder(null,$option,'edit',$seller);
                      ?>

                      <?php $form->textInput('fname','نام',['validate'=>'required']);  ?>

                      <?php $form->textInput('lname','نام خانوادگی',['validate'=>'required']);  ?>

                      <?php $form->textInput('brand_name','نام فروشگاه',['validate'=>'required']);  ?>

                      <?php $form->textInput('email','ایمیل',['validate'=>'required']);  ?>

                      <?php $form->textInput('mobile','شماره موبایل',['validate'=>'required']);  ?>

                      <?php $form->textInput('password','کلمه عبور',['type'=>'password']);  ?>

                      <?php $form->textInput('shaba','شماره شبا',[]);  ?>

                      <div class="profile_location">
                          <register-location province_id="<?php echo e($seller->province_id); ?>"
                                             city_id="<?php echo e($seller->city_id); ?>"
                          ></register-location>
                      </div>

                      <?php if($seller->account_status==='reject'): ?>

                          <?php $form->imageInput('','اسکن صفحه اصلی شناسنامه',['validate'=>'required']);  ?>

                          <?php $form->imageInput('','اسکن کارت ملی',['validate'=>'required']);  ?>

                     <?php endif; ?>

                      <?php $form->textarea('description','توضیحات فروشگاه',['class'=>'total-width']);  ?>


                      <?php $form->btn('ثبت','edit');  ?>

                      <?php $form->close();  ?>

                  </template>

             </seller-profile>
         <?php if (isset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde)): ?>
<?php $component = $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde; ?>
<?php unset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sellers::layouts.panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/panel/profile.blade.php ENDPATH**/ ?>