<?php $__env->startSection('content'); ?>

    <div>

        <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت پیام ها','url'=>url('admin/messages')],
        ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <?php echo $__env->make('messages::panel._search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php
            $args=[];
            $args['title']='مدیریت پیام ها';
            $args['route']='admin/messages';
            $args['trashCount']=$trash_message_count;
            $args['routeParam']='پیام';
            $args['remove_new_record']=true;
        ?>
        <?php use App\Lib\Jdf; ?>

        <?php define('types',$types) ?>

        <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>

            <panel-message>

                <?php
                \App\Lib\GridView::showTable([
                    'dataProvider'=>$messages,
                    'columns'=>[
                        ['label'=>'عنوان','attr'=>'title'],
                        ['label'=>'ارسال کننده','attr'=>function($model){
                            $from_type=$model->from_type;
                            if($model->from && $from_type && array_key_exists($from_type,types)){
                                $url_param=types[$from_type]['url_param'];
                                $url=url('admin/'.$url_param.'/'.$model->from->id);
                                $attr=types[$from_type]['attr'];
                                return '<a href="'.$url.'" class="router-link"><span class="form_link">'.e($model->from->$attr).'</span></a>';
                            }
                        },'html'=>true],
                        ['label'=>'دریافت کننده','attr'=>function($model){
                            $to_type=$model->to_type;
                            if($model->to && $to_type && array_key_exists($to_type,types)){
                                $url_param=types[$to_type]['url_param'];
                                $url=url('admin/'.$url_param.'/'.$model->to->id);
                                $attr=types[$to_type]['attr'];
                                return '<a href="'.$url.'" class="router-link"><span class="to_link">'.e($model->to->$attr).'</span></a>';
                            }
                            else{
                                return '<span class="to_link">'.e(config('shop-info.shop_name')).'</span>';
                            }
                        },'html'=>true],
                        ['label'=>'زمان ارسال','attr'=>function($model){
                            $jdf=new Jdf();
                            return e($jdf->jdate('H:i:s',$model->time).' / '.$jdf->jdate('Y-n-j',$model->time));
                        }]
                    ],
                    'route_param'=>'messages',
                    'tableLabel'=>'پیام',
                    'actions'=>[
                        function($model){
                            $url=url('admin/messages/'.$model->id);
                            return view('messages::panel.show_icon',['data'=>$model,'url'=>$url])->render();
                        }
                    ]
                ],true);
                ?>
                <?php echo e($messages->links()); ?>


            </panel-message>


         <?php if (isset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa)): ?>
<?php $component = $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa; ?>
<?php unset($__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/teraketc/AppCode/modules/messages/resource/views/panel/index.blade.php ENDPATH**/ ?>