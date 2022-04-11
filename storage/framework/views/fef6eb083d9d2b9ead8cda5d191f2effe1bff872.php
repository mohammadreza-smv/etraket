<?php $__env->startSection('content'); ?>


    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت محصولات','url'=>url('admin/products')],
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('incredibleOffers::_search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
             $args=[];
             $args['title']='مدیریت پیشنهادات شگفت انگیز ';
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>


            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$list,
                'columns'=>[
                    ['label'=>'تصویر محصول','attr'=>function($model){
                        $src=url('files/thumbnails/'.$model->product->image_url);
                        return '<img src="'.$src.'" class="product_pic">';
                    },'html'=>true],
                    ['label'=>'عنوان','attr'=>function($model){
                        return e($model->product->title);
                    }],
                    ['label'=>'تاریخ شروع','attr'=>function($model){
                        return e(replace_number($model->offers_first_date));
                    }],
                    ['label'=>'تاریخ شروع','attr'=>function($model){
                        return e(replace_number($model->offers_last_date));
                    }],

                ],
                'actions'=>[
                    function($model){
                        $url=url('admin/product/price_variation/'.$model->id.'/edit?product_id='.$model->product_id);
                        return '<a href="'.$url.'" class="router-link"><v-icon>mdi-eye-outline</v-icon></a> ';
                    }
                ],
                'route_param'=>'incredible-offers',
                'tableLabel'=>'پیشنهاد شگفت انگیز'
            ],true);
            ?>
         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>


    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/incredibleOffers/resource/views/list.blade.php ENDPATH**/ ?>