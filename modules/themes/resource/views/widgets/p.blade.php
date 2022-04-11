<?php
   $key=$args['id'];
?>
@if(array_key_exists('p',$tags))

    @if(array_key_exists($key,$tags['p']))

        <?php
            $content=$tags['p'][$key]['content'];
            $showMore=array_key_exists('showMore',$tags['p'][$key]) ? $tags['p'][$key]['showMore'] : false
        ?>

        <div id="{{ $key }}" >
            @if($showMore) <more-content-box el_id="{{ $key }}"> @endif
               {!! $content !!}
           @if($showMore) </more-content-box> @endif
        </div>
    @endif

@endif

