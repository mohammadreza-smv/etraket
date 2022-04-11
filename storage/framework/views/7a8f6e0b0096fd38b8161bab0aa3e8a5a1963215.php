<?php $__env->startSection('panel-content'); ?>
    <?php $args=['title'=>'پیام ها']; ?>
    <?php use App\Lib\Jdf; ?>
    <?php if (isset($component)) { $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\UserPanelBox::class, ['args' => $args]); ?>
<?php $component->withName('user-panel-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>



        <div class="row">


            <div class="messageList" style="width:100%">

                <?php if(Session::has('add-message')): ?>
                    <v-alert type="success" dismissible>
                        <?php echo e(Session::get('add-message')); ?>

                    </v-alert>
                <?php endif; ?>

                <?php if ($__env->exists('messages::userPanel._searchForm')) echo $__env->make('messages::userPanel._searchForm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <a href="<?php echo e(url('user/profile/messages/create')); ?>" class="router-link" style="margin-bottom:20px;display: block">
                    <v-btn color="success">
                        <span>ارسال پیام جدید</span>
                    </v-btn>
                </a>

                <?php
                \App\Lib\GridView::showTable([
                    'dataProvider'=>$messages,
                    'columns'=>[
                        ['label'=>'عنوان','attr'=>'title'],
                        ['label'=>'ارسال کننده','attr'=>function($model){
                            if($model->from_id==$model->user_id){
                                return '<span class="form_link">'. e($model->from->name).'</span>';
                            }
                            else{
                                return '<span class="form_link">'.e(config('shop-info.shop_name')).'</span>';
                            }
                        },'html'=>true],
                        ['label'=>'دریافت کننده','attr'=>function($model){
                            if($model->to){
                                return '<span class="to_link">'.e($model->to->name).'</span>';
                            }
                            else{
                                return '<span class="to_link">'.e(config('shop-info.shop_name')).'</span>';
                            }
                        },'html'=>true],
                        ['label'=>'زمان ارسال','attr'=>function($model){
                            $jdf=new Jdf();
                            return e($jdf->jdate('H:i:s',$model->time).' / '.$jdf->jdate('Y-n-j',$model->time));
                        }],
                    ],
                    'actions'=>[
                        function($model){
                            $url=url('user/profile/messages/'.$model->id);
                            $style=($model->status==-1) ? 'style="color:red"' : "";
                            return '<a href="'.$url.'" class="router-link"><v-icon>mdi-eye</v-icon></a> ';
                        }
                    ],
                    'tableCssClass'=>'message_table'
                ],true,true);
                ?>

                <?php echo e($messages->links()); ?>


            </div>

        </div>

     <?php if (isset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950)): ?>
<?php $component = $__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950; ?>
<?php unset($__componentOriginald2e2ec7e85d8e4afc2e3afc56e839cd1f1c2c950); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-theme::layouts.user-panel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/teraketc/AppCode/modules/messages/resource/views/userPanel/messages.blade.php ENDPATH**/ ?>