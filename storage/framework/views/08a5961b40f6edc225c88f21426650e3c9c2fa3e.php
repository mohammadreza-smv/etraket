<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('sellers::panel.breadcrumb',['data'=>[
           ['title'=>'محصولات فروشگاه','url'=>url('sellers/panel/products/total/show')],
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if ($__env->exists('sellers::panel.products._search_form',['url'=>'sellers/panel/products/total/show'])) echo $__env->make('sellers::panel.products._search_form',['url'=>'sellers/panel/products/total/show'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php $args=['title'=>'محصولات فروشگاه'] ?>

        <?php if (isset($component)) { $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde = $component; } ?>
<?php $component = $__env->getContainer()->make(Modules\sellers\components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('seller-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php
                $status=\Modules\products\Models\Product::ProductStatus();
                define('status',$status);
            ?>
            <?php
            \App\Lib\GridView::showTable([
                'dataProvider'=>$products,
                'columns'=>[
                    ['label'=>'تصویر محصول','attr'=>function($model){
                        $src=url('files/thumbnails/'.$model->image_url);
                        return '<img src="'.$src.'" class="product_pic" style="margin:20px;width:100px">';
                    },'html'=>true],
                    ['label'=>'عنوان','attr'=>'title'],
                    ['label'=>'حداقل قیمت فروش','attr'=>function($model){
                        return get_price($model->price);
                    }],
                    ['label'=>'وضعیت محصول','attr'=>function($model){
                        if(array_key_exists($model->status,status)){
                            $class=($model->status==1)  ? "alert-success" : 'alert-warning';
                            return '<span class="'.$class.'" style="font-size:13px;padding:5px 7px;width:80px;display: block;">'.status[$model->status] .'</span>';
                        }
                    },'html'=>true]
                ],
                'actions'=>[
                     function($model){
                         $url=url('sellers/panel/product/price_variation?product_id='.$model->id);
                         return '<a href="'.$url.'" class="router-link"><v-btn color="error">من هم میفروشم</v-btn></a>';
                      }
                ],
                'route_param'=>'sellers/panel/products',
                'tableLabel'=>'محصول',
                'viewComponent'=>'seller-product-list',
            ],true,true);
            ?>
            <?php echo e($products->links()); ?>


         <?php if (isset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde)): ?>
<?php $component = $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde; ?>
<?php unset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sellers::layouts.panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/panel/products/total.blade.php ENDPATH**/ ?>