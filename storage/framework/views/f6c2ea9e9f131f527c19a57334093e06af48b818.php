<?php $__env->startSection('content'); ?>

    <div>


        <?php echo $__env->make('sellers::panel.breadcrumb',['data'=>[
              ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
              ['title'=>'مدیریت تنوع های قیمت','url'=>url('sellers/panel/product/price_variation?product_id='.$product->id)],
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <?php
              $title='مدیریت تنوع های قیمت '.e( $product->title);
              $args=[];
              $args['title']=$title;
              $args['route']='sellers/panel/product/price_variation';
              $args['trashCount']=$trash_price_variation_count;
              $args['routeParam']='تنوع قیمت';
              $args['queryString']=['param'=>'product_id','value'=>$product->id];

             $deleteList=isset($_GET['trashed']) ? true : false;
        ?>

        <?php if (isset($component)) { $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde = $component; } ?>
<?php $component = $__env->getContainer()->make(Modules\sellers\components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('seller-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$price_variation,
                'columns'=>[
                    ['label'=>'قیمت محصول','attr'=>function($model){
                        $price=replace_number(number_format($model->price1)). 'تومان' ;
                        return '<div class="alert alert-success" style="padding:10px">'.Htmlspecialchars($price,ENT_QUOTES).'</div>';
                    },'html'=>true],

                    ['label'=>'قیمت محصول برای فروش','attr'=>function($model){
                        $price=replace_number(number_format($model->price2)). 'تومان' ;
                        return '<div class="alert alert-warning" style="padding:10px">'.Htmlspecialchars($price,ENT_QUOTES).'</div>';
                    },'html'=>true,'style'=>'min-width:160px'],

                    ['label'=>'تعداد موجودی محصول','attr'=>'product_number']
                ],

                'tableLabel'=>'تنوع قیمت',
                'route_param'=>'product/price_variation',
                'route_query_string'=>'?product_id='.$product->id,
                'actionRouteParam'=>'sellers/panel'
            ],false,$deleteList);
            ?>

            <?php echo e($price_variation->links()); ?>

         <?php if (isset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde)): ?>
<?php $component = $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde; ?>
<?php unset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sellers::layouts.panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/sellers/resource/views/panel/priceVariation/index.blade.php ENDPATH**/ ?>