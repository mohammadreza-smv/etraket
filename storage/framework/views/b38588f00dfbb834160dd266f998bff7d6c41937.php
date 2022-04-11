<?php $__env->startSection('content'); ?>

    <seller-register shop_name="<?php echo e(config('shop-info.shop_name')); ?>">

        <template slot="register-1">
            <?php echo $__env->make('sellers::auth.register.step1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <p style="margin-top:50px;text-align:center">
                <span>قبلاً ثبت نام کرده‌ام.</span>
                <a href="<?php echo e(url('sellers/login')); ?>" class="router-link c-link">
                    ورود
                </a>
            </p>

            <v-alert type="error" border="left"  colored-border>

                توجه: در صورتی که مراحل ثبت نام را نیمه تمام گذاشته اید، می توانید با همان شماره موبایل ثبت نام خود را ادامه دهید.

            </v-alert>


        </template>

        <template v-slot:register-2="{mobile}">
            <?php echo $__env->make('sellers::auth.register.step2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </template>

        <template v-slot:register-3="{mobile}">
            <register-active-code :mobile="mobile"></register-active-code>
        </template>

        <template v-slot:upload-file-1="{mobile}">
            <?php echo $__env->make('sellers::auth.register.step4_1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </template>

        <template v-slot:upload-file-2="{mobile}">
            <?php echo $__env->make('sellers::auth.register.step4_2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </template>

    </seller-register>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sellers::layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/auth/register_form.blade.php ENDPATH**/ ?>