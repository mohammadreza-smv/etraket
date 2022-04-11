<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>
                 [['title'=>'مدیریت فروشندگان','url'=>url('admin/sellers/list')]]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
             $args=['remove_new_record'=>true];
             $args['title']='مدیریت فروشندگان';
             $args['route']='admin/sellers/list';
             $args['trashCount']=$trash_seller_count;
             $args['routeParam']='فروشنده';
             $args['items']= [
                  ['label'=>'دریافت خروجی پرداخت','url'=>url('admin/sellers/pay/export'),'icon'=>'mdi-file-excel',
                      'target'=>'_blank'],
                  ['label'=>'ثبت پرداخت ها','url'=>url('admin/sellers/pay/import'),'icon'=>'mdi-credit-card-outline']
             ];
        ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php

             \App\Lib\GridView::showTable([
                'dataProvider'=>$sellers,
                'columns'=>[
                    ['label'=>'نام فروشنده','attr'=>function($value){
                        return '<span>'.e($value->fname.' '.$value->lname).'</span>';
                    }],
                    ['label'=>'نام فروشگاه','attr'=>'brand_name'],
                    ['label'=>'شماره موبایل','attr'=>function($value){
                        return e(replace_number($value->mobile));
                    }],
                    ['label'=>'تعداد محصول','attr'=>function($value){
                        return e(replace_number($value->product_count));
                    }],
                    [
                        'label'=>'وضعیت','attr'=>function($value){
                        if ($value->account_status=='active'){
                            return '<div class="alert alert-success">فعال</div>';
                        }
                        elseif ($value->account_status=='Inactive'){
                            return  '<div class="alert alert-secondary">غیر فعال</div>';
                        }
                        elseif ($value->account_status=='reject'){
                            return  '<div class="alert alert-danger">رد شده</div>';
                        }
                        else{
                            return  '<div class="alert alert-warning">در انتظار تایید</div>';
                        }
                    },'html'=>true
                    ],
                    ['label'=>'کمیسون دریافت شده','attr'=>function($value){
                        return e(get_price($value->total_commission));
                    }],
                    ['label'=>'مبلغ قابل واریز','attr'=>function($value){
                        $price=$value->total_price - $value->total_commission - $value->paid_commission;
                        return e(get_price($price));
                    }],
                ],
                'route_param'=>'sellers/list',
                'tableLabel'=>'فروشنده',
                'actions'=>[
                    function($model){
                        $url=url('admin/sellers/list/'.$model->id);
                        return '<a style="padding-left:5px" href="'.$url.'" class="router-link"><v-icon>mdi-eye</v-icon></a>';
                    }
                ]
            ]);
            ?>

            <?php echo e($sellers->links()); ?>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/index.blade.php ENDPATH**/ ?>