<?php $__env->startSection('content'); ?>


    <div>

        <?php echo $__env->make('sellers::panel.breadcrumb',['data'=>[
              ['title'=>'مدیریت محصولات','url'=>url('sellers/panel/products')],
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php $args=['title'=>'مدیریت محصولات'] ?>


        <?php if ($__env->exists('sellers::panel.products._search_form')) echo $__env->make('sellers::panel.products._search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if (isset($component)) { $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde = $component; } ?>
<?php $component = $__env->getContainer()->make(Modules\sellers\components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('seller-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <?php
                 $status=\Modules\products\Models\Product::ProductStatus();
                 define('status',$status);
                 $seller_id=\Auth::guard('seller')->user()->id
           ?>

            <?php
               \App\Lib\GridView::showTable([
                'dataProvider'=>$product,
                'columns'=>[
                    ['label'=>'تصویر محصول','attr'=>function($model){
                        $src=url('files/thumbnails/'.$model->image_url);
                        return '<img src="'.$src.'" class="product_pic" style="margin:20px;width:100px">';
                    },'html'=>true],
                    ['label'=>'عنوان','attr'=>'title'],
                    ['label'=>'وضعیت محصول','attr'=>function($model){
                        if(array_key_exists($model->status,status)){
                            $class=($model->status==1)  ? "alert-success" : 'alert-warning';
                            return '<span class="'.$class.'" style="font-size:13px;padding:5px 7px;width:80px;display: block;">'.status[$model->status] .'</span>';
                        }
                    },'html'=>true]
                ],
                'actions'=>[
                    function($model){
                        if($model->status<-1){
                            $url=url('sellers/panel/products/'.$model->id);
                            return '<delete-link row-id="'.$model->id.'" sendTrash="yes" label="محصول" url="'.$url.'"></delete-link>';
                        }
                    },
                    function($model){
                        if($model->seller_id===get_seller_id()){
                            $url=url('sellers/panel/products/'.$model->id.'/edit');
                            return '<a class="router-link" href="'.$url.'"><v-icon color="primary">mdi-circle-edit-outline</v-icon></a>';
                        }
                    }
                ],
                'route_param'=>'sellers/panel/products',
                'tableLabel'=>'محصول',
                'viewComponent'=>'seller-product-list seller_id='.$seller_id.'',
                'props'=>['seller_id']
            ],true,true);
            ?>

            <?php echo e($product->links()); ?>


         <?php if (isset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde)): ?>
<?php $component = $__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde; ?>
<?php unset($__componentOriginalf8a2aa927d81b92524cab4c78b01059273b9cdde); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sellers::layouts.panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/sellers/resource/views/panel/products/index.blade.php ENDPATH**/ ?>