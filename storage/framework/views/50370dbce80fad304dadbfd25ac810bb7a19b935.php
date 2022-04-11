<?php
    $var=$args['id'];
    $var=str_replace('-',"_",$var);
    $jdf=new \App\Lib\Jdf();
?>
<?php if(isset(${$var})): ?>
   <?php $data=${$var} ?>
   <div class="post-box">
       <div class="box-title">
           <h4><?php echo e($data['title']); ?></h4>
           <div class="post-box-line"></div>
       </div>

       <?php if(!$data['show_content']): ?>
           <div class="post-list1">
               <?php $__currentLoopData = $data['posts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <div class="post-view">
                       <a href="<?php echo e(route('blog.show.post',['url'=>$post->url])); ?>">
                           <v-img
                               max-width="100%"
                               src="<?php echo e(url('files/posts/'.$post->pic)); ?>"
                           ></v-img>
                       </a>
                       <a href="<?php echo e(route('blog.show.post',['url'=>$post->url])); ?>" class="post-title">
                           <?php echo e($post->title); ?>

                       </a>
                       <div class="post-detail">
                           <div>
                               <?php echo e($jdf->jdate(' d F Y',$post->created_at->timestamp)); ?>

                           </div>
                           <div>
                               <span><?php echo e(replace_number($post->view)); ?></span>
                               <v-icon size="16">
                                   mdi-eye
                               </v-icon>
                           </div>
                       </div>
                   </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           </div>
       <?php else: ?>
           <div class="post-list2">

               <?php $__currentLoopData = $data['posts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <div class="post-view">
                       <div class="image-box">
                           <a href="<?php echo e(route('blog.show.post',['url'=>$post->url])); ?>">
                               <v-img
                                   max-width="100%"
                                   src="<?php echo e(url('files/posts/'.$post->pic)); ?>"
                               ></v-img>
                           </a>
                       </div>
                       <div>
                           <a href="<?php echo e(route('blog.show.post',['url'=>$post->url])); ?>" class="post-title">
                               <?php echo e($post->title); ?>

                           </a>
                           <div class="post-detail">
                               <div>
                                   <?php echo e($jdf->jdate(' d F Y',$post->created_at->timestamp)); ?>

                               </div>
                               <div>
                                   <span><?php echo e(replace_number($post->view)); ?></span>
                                   <v-icon size="16">
                                       mdi-eye
                                   </v-icon>
                               </div>
                           </div>
                           <div class="content">
                               <?php if(strlen(strip_tags($post->content))>200): ?>
                                   <?php echo mb_substr(strip_tags($post->content),0,200).'...'; ?>

                               <?php else: ?>
                                   <?php echo $post->content; ?>

                               <?php endif; ?>

                           </div>
                       </div>
                   </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

           </div>
       <?php endif; ?>
   </div>
<?php endif; ?>
<?php /**PATH /home2/teraketc/AppCode/modules/blog/resource/views/widgets/posts.blade.php ENDPATH**/ ?>