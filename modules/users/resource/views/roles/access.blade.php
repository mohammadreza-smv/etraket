@extends('backend-theme::layout')

@section('content')

   <div>
       @include('backend-theme::breadcrumb',['data'=>[
        ['title'=>'مدیریت نقش های کاربری','url'=>url('admin/userRole')],
        ['title'=>'تعیین دسترسی های نقش : '.$role->name,'url'=>url('admin/userRole/access/'.$role->id)]
   ]])

       @php
           $AccessList=\Modules\users\Models\User::AccessList();
       @endphp
       <?php
          $args=['title'=>'تعیین دسترسی های نقش : '.e($role->name)];
       ?>
       <x-panel-box :args="$args">
           <?php $form=new \App\Lib\FormBuilder(null,
               ['url'=>url('admin/userRole/access/'.$role->id)],'create',[]) ?>

           <ul class="access">
               @foreach ($AccessList as $key=>$item)
                   <li style="margin-bottom:20px;padding: 15px;background: #f8fafc;">
                       <span>{{ $item['label'] }}</span>
                       <ul>
                           @foreach ($item['access'] as $key2=>$value2)
                               <li>
                                   <?php
                                       $name='access['.$key.']['.$key2.']';
                                       $value=checkAccess($role_accesses,$key,$key2) ? "true" : 0;
                                   ?>
                                   <?php $form->checkbox($name,$value2['label'],$value); ?>
                               </li>
                           @endforeach
                       </ul>
                   </li>
               @endforeach
           </ul>
           <?php $form->btn('ثبت','create'); ?>
           <?php $form->close(); ?>

       </x-panel-box>


   </div>

@endsection
