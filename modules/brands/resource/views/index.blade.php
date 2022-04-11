@extends('backend-theme::layout')

@section('content')

   <div>

       @include('backend-theme::breadcrumb',['data'=>[['title'=>'مدیریت برند ها','url'=>url('admin/brands')]]])

       @include('brands::_search_form')

       <?php
          $args=[];
          $args['title']=' مدیریت برند ها';
          $args['route']='admin/brands';
          $args['trashCount']=$trash_brand_count;
          $args['routeParam']='برند';
       ?>

       <x-panel-box :args="$args">

           <?php
           \App\Lib\GridView::showTable([
               'dataProvider'=>$brand,
               'columns'=>[
                   ['label'=>'ایکون','attr'=>function($model){
                       if(!empty($model->brand_icon)){
                           $src=url('files/upload/'.$model->brand_icon);
                           return ' <img src="'.$src.'" style="max-width:200px;margin:10px">';
                       }
                   },'html'=>true],
                   ['label'=>'نام برند','attr'=>'brand_name'],
                   ['label'=>'نام انگلیسی برند','attr'=>'brand_ename']
               ],
               'route_param'=>'brands',
               'tableLabel'=>'برند'
           ]);
           ?>

           {{ $brand->links() }}

       </x-panel-box>

   </div>

@endsection
