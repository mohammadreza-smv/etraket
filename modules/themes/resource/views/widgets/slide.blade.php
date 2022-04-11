<?php
$key=$args['id'];
?>
@if(array_key_exists('slide',$tags))

    @if(array_key_exists($key,$tags['slide']))


        <?php
           $items=$tags['slide'][$key]['items'];

        ?>

        <div  id="{{ $key }}" >
            <theme-carousel>

                @foreach($items as $key=>$item)

                    <v-carousel-item
                        key="{{ $key }}"
                    >
                        <a href="{{ $item['link'] }}" class="router-link">
                            <img style="background-image:url('{{ $item['src'] }}')"/>
                        </a>

                    </v-carousel-item>

                @endforeach

            </theme-carousel>
        </div>

    @endif

@endif
