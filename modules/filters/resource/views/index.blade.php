@extends('backend-theme::layout')

@section('content')

    <div>

        @include('backend-theme::breadcrumb',['data'=>[
             ['title'=>'مدیریت دسته بندی ها','url'=>url('admin/category')],
             ['title'=>'مدیریت فیلتر ها','url'=>url('admin/category/'.$category->id.'/filters')]
        ]])

        <?php
             $args=[];
             $args['title']='مدیریت فیلتر های دسته '.e($category->name);
        ?>

        <x-panel-box :args="$args">
            <cat-filters :filters="{{ json_encode($filters) }}" cat_id="{{ $category->id }}">
                <template v-slot:before_filter_name="slotProps">
                      <?php run_action('add_filter_form',[]) ?>
                </template>
            </cat-filters>
        </x-panel-box>

    </div>

@endsection


