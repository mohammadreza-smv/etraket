<?php $__env->startSection('content'); ?>

    <faq>

        <div class="content" style="margin:-15px">

            <div  style="background:linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)), url('<?= url('/modules/faq/9de6ef39.jpg') ?>') top no-repeat"  class="page_cover">

                <div class="page_cover_title">
                    <h3>پاسخ پرسش‌های پرتکرار</h3>
                </div>

                <div class="search_box">
                    <faq-search></faq-search>
                </div>

            </div>

            <div class="page faq_list" >

                <div  class="cat_info">
                    <h5><?php echo e($question->title); ?></h5>
                </div>
                <div class="answer">
                    <?php echo strip_tags($question->answer,'<p><ul><li><img><video><a><span><div>'); ?>

                </div>
            </div>
            <div class="page faq_list common_question_list" >

                <h5>پرتکرارترین پرسش‌ها</h5>
                <div style="margin-top:30px">
                    <?php $__currentLoopData = $pin_question; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('front-theme::layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/faq/resource/views/faq_question.blade.php ENDPATH**/ ?>