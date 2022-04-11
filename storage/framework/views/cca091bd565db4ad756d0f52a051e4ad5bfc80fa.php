<?php $__env->startSection('content'); ?>

    <faq>

        <div class="content" style="margin: -15px">

            <div  style="background:linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)), url('<?= url('/modules/faq/9de6ef39.jpg') ?>') top no-repeat"  class="page_cover">

                <div class="page_cover_title">
                    <h3>پاسخ پرسش‌های پرتکرار</h3>
                </div>


                <div class="search_box">
                    <faq-search></faq-search>
                </div>

            </div>

            <?php if($request->get('q')!=''): ?>
                <div class="page faq_list" >

                    <h5>
                        جستجوی "<?php echo e($q); ?>"
                    </h5>
                    <div style="margin-top:30px">
                        <?php $__currentLoopData = $search_question; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="common_question">
                                <div class="common_question_header">
                                    <h5><?php echo e($value->title); ?></h5>
                                    <v-icon>mdi-chevron-down</v-icon>
                                </div>
                                <div class="small_answer">
                                    <?php echo strip_tags($value->small_answer,'<ul><li><a><p><br>'); ?>


                                    <?php if(!empty($value->answer)): ?>
                                        <div class="more_data">
                                            <a href="<?php echo e(url('faq/question/'.$value->id)); ?>" class="router-link data_link">مشاهده توضیحات تکمیلی</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if(sizeof($search_question)==0): ?>
                            <p>موردی یافت نشد </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="page faq_list <?php if($request->get('q')!=''): ?> common_question_list <?php endif; ?>">

                <h5>دسته‌بندی پرسش‌ها</h5>
                <div class="feq_cat_list">
                    <?php $__currentLoopData = $cat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(url('faq/category/'.$value->id)); ?>" class="router-link">
                            <div class="feq_cat <?php if(($key+1)%3!=0): ?> cat_list_border_left <?php endif; ?>">
                                <?php if(!empty($value->icon)): ?>
                                    <div class="faq_cat_icon">
                                        <img src="<?php echo e(url('files/upload/'.$value->icon)); ?>" >
                                    </div>
                                <?php endif; ?>
                                <span><?php echo e($value->title); ?></span>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="page faq_list common_question_list" >

                <h5>پرتکرارترین پرسش‌ها</h5>
                <div style="margin-top:30px">
                    <?php $__currentLoopData = $question; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="common_question">
                            <div class="common_question_header">
                                <h5><?php echo e($value->title); ?></h5>
                                <v-icon>mdi-chevron-down</v-icon>
                            </div>
                            <div class="small_answer">
                                <?php echo strip_tags($value->small_answer,'<ul><li><a><p><br>'); ?>


                                <?php if(!empty($value->answer)): ?>
                                    <div class="more_data">
                                        <a href="<?php echo e(url('faq/question/'.$value->id)); ?>" class="router-link data_link">مشاهده توضیحات تکمیلی</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

    </faq>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/faq/resource/views/faq.blade.php ENDPATH**/ ?>