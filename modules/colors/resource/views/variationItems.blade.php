@if(!isset($type) || $type=='select')
    <?php $array=[]; ?>

    
   <?php
      
        $property='param'.$num.'_id';
        $relation='param'.$num;
        $param_key='param'.$num.'_type';
        $p_id=$num==1 ? $param1_id : $param2_id;
        if(!function_exists('check')){
            function check($variation,$num,$param1_id){
              if($num==2){
                     return ($param1_id==$variation->param1_id);
              }
             else{
                 return true;
             }
        }
        }
        
    ?>
    
    
      @if($num==2)
        <p>انتخاب رنگ</p>
    @endif

    <ul class="color_ul">
        @foreach($product->PriceVariation as $key=>$variation)

            @if(!array_key_exists($variation->$property,$array) && check($variation,$num,$param1_id))

                   <?php $array[$variation->$property]=$variation->$property; ?>

                   @if($variation->$relation)
                            <li id="color_variation_{{ $key }}" class="color_li variation_item @if($p_id==$variation->$property) active @endif"
                                data-param-id="{{ $variation->$property }}"
                                data-param-type="{{ $variation->$param_key }}"
                                data-param-key="{{ $num }}"
                                onclick="vm.$root.$emit('update_variation','color_variation_{{ $key }}')"
                            >
                                <label style="display: flex">
                                    <div class="ui_variant_shape" style="background:#{{ $variation->$relation->code }}"></div>
                                    <span class="color_name">{{ $variation->$relation->name }}</span>
                                </label>
                            </li>
                   @endif

            @endif

        @endforeach
    </ul>

@endif

