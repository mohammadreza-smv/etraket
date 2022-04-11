<?php
  $var=$args['id'];
  $var=str_replace('-',"_",$var);
?>
@if(isset(${$var}))
    @if(!array_key_exists('load_type',${$var}) || ${$var}['load_type']==0)
        @includeIf('horizontal_product_list_view',[
           'title'=>${$var}['title'],
           'products'=>${$var}['products'],
           'args'=>$args
        ])

    @elseif(array_key_exists('load_type',${$var}) || ${$var}['load_type']==1)
        <?php
            $shop_product_url=shop_product_url_theme();
        ?>
        <horizontal-product-list
            :args="{{ json_encode(${$var}) }}"
            shop_product_url="{{ $shop_product_url }}"
        ></horizontal-product-list>
    @endif

@endif
