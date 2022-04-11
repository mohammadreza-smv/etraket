<?php
  $var=$args['id'];
  $var=str_replace('-',"_",$var);
  $products=${$var}['products'];
?>

<div class="incredible-product-list incredible_products">

    <v-slide-group
        show-arrows
    >

        @foreach($products as $key=>$value)
            <?php
            $a=($value->price2/$value->price1)*100;
            $a=100-$a;
            $a=round($a);
            ?>
            <v-slide-item  :key="{{ $key }}">

                    <div class="product">
                        <a class="router-link" data-component="product-page-skeleton" href="{{ shop_product_url($value->product) }}">
                            <div class="product_img_div">
                                <img  src="{{ url('files/thumbnails/'.$value->product->image_url) }}">
                            </div>

                            <p class="title">
                                @php $title=$value->product->title @endphp
                                @if(strlen($title)>33)
                                    {{ mb_substr($title,0,33).' ... ' }}
                                @else
                                    {{ $title  }}
                                @endif
                            </p>

                            <div class="price">
                                <div class="discount_div">
                                    <div>
                                        <del>
                                            {{ replace_number(number_format($value->price1)) }}
                                        </del>
                                        @if($a>0)
                                            <span class="discount-badge">
                                          {{ '٪'.replace_number($a) }}
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <span>{{ replace_number(number_format($value->price2)) }} تومان</span>
                            </div>
                        </a>

                        @if($value->product_number>0)
                            <time-counter second="<?= $value->offers_last_time-time() ?>"></time-counter>
                        @endif
                    </div>
                </a>
            </v-slide-item>
        @endforeach

    </v-slide-group>

</div>
