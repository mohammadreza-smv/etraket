@extends('front-theme::layouts.user-panel')

@section('panel-content')

    <?php
         $args=['title'=>'لیست علاقه مندی ها'];
    ?>

    <x-user-panel-box :args="$args">

         <?php
              $shop_product_url=shop_product_url_theme();
         ?>
         <favorite-list
             shop_product_url="{{ $shop_product_url }}"
         >

         </favorite-list>

    </x-user-panel-box>

@endsection
