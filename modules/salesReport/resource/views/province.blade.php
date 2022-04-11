@extends('backend-theme::layout')

@section('content')

    <div>


        @include('backend-theme::breadcrumb',
           ['data'=>[
                ['title'=>'تعداد سفارشات به تفکیک هر استان','url'=>url('admin/sales/province')]
           ]])

        <?php
             $args=[];
             $args['title']='تعداد سفارشات به تفکیک هر استان';
        ?>

        <x-panel-box :args="$args">
            <province-sale></province-sale>
        </x-panel-box>

    </div>

@endsection
