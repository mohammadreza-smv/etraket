<?php $__env->startSection('content'); ?>


    <seller-login>


        <template slot="login-right-box">

            <div>
                <img src="<?php echo e(url(config('shop-info.shop_icon'))); ?>">
                <h5>به مرکز فروشندگان <?php echo e(config('shop-info.shop_name')); ?> خوش آمدید</h5>
            </div>

        </template>

        <template slot="content">

            <?php $form1=new \App\Lib\FormBuilder(null,['url' => 'sellers/login'], 'create',null); ?>

            <?php $form1->textInput('mobile','شماره موبایل',['validate'=>'required','prepend_icon'=>'mdi-cellphone','dense'=>false]); ?>

            <?php $form1->textInput('password','کلمه عبور',['validate'=>'required','type'=>'password','prepend_icon'=>'mdi-lock','dense'=>false]); ?>

            <div style="text-align: right;">
                <a class="router-link forget-password-link" href="<?php echo e(url('sellers/password/reset')); ?>">بازیابی کلمه
                    عبور</a>
            </div>

            <?php $form1->btn('ورود به پنل فروشندگان','create'); ?>

            <?php $form1->close(); ?>
            <p style="margin-top:50px;text-align:center">
                 <span>هنوز ثبت نام نکرده اید؟</span>
                 <a href="<?php echo e(url('sellers/register')); ?>" class="router-link c-link">
                        همین حالا ثبت نام کنید
                 </a>
           </p>
        </template>

    </seller-login>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sellers::layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/auth/login_form.blade.php ENDPATH**/ ?>