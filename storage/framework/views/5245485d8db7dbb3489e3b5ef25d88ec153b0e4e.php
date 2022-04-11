<?php $__env->startSection('content'); ?>

    <div>
           <?php
                $array['users']= 'مدیریت کاربران';
                $array['sellers']= 'مدیریت فروشندگان';
           ?>

           <?php echo $__env->make('backend-theme::breadcrumb',['data'=>[
                ['title'=>$array[$url_param],'url'=>url('admin/'.$url_param)],
                ['title'=>'مدیریت پیام ها','url'=>url('admin/'.$url_param.'/'.$user->id.'/messages')],
            ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
           <?php
                $attr=$types[$type]['attr'];
                $args=[];
                $name=$user->$attr!='' ? $user->$attr : $user->mobile;
                $args['title']=' پیام های ارسالی و دریافتی از '.e($name)
            ?>

            <?php use App\Lib\Jdf;$jdf=new Jdf(); ?>
            <?php define('types',$types) ?>


           <?php echo $__env->make('messages::panel._search_form',['url'=>'admin/users/'.$user->id.'/messages'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

           <?php if (isset($component)) { $__componentOriginalf662e23fbe106d0d3d16aeb022f94f5d38e632aa = $component; } ?>
<?php $component = $__env->getContainer()->make(themes\AdminPanel\Components\PanelBox::class, ['args' => $args]); ?>
<?php $component->withName('panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                <panel-message>
                    <a href="<?php echo e(url('admin/'.$url_param.'/'.$user->id.'/messages/create')); ?>" class="router-link" >
                       <v-btn color="success" style="margin-bottom:20px">
                           <span>ارسال پیام به
                                <?php if($url_param=='users'): ?>
                                   کاربر
                               <?php else: ?>
                                   فروشنده
                               <?php endif; ?>
                           </span>
                       </v-btn>
                    </a>


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
                                    return '<a href="'.$url.'" target="_blank"><span class="form_link">'.e($model->from->$attr).'</span></a>';
                                }
                            },'html'=>true],
                            ['label'=>'دریافت کننده','attr'=>function($model){
                                $to_type=$model->to_type;
                                if($model->to && $to_type && array_key_exists($to_type,types)){
                                    $url_param=types[$to_type]['url_param'];
                                    $url=url('admin/'.$url_param.'/'.$model->to->id);
                                    $attr=types[$to_type]['attr'];
                                    return '<a href="'.$url.'" target="_blank"><span class="to_link">'.e($model->to->$attr).'</span></a>';
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

<?php echo $__env->make('backend-theme::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/messages/resource/views/panel/user_message_list.blade.php ENDPATH**/ ?>