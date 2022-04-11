<?php
    $key=$args['id'];
?>
@if(array_key_exists('img',$tags))

    @if(array_key_exists($key,$tags['img']))

        <?php
           $src=$tags['img'][$key]['src'];
           $link=$tags['img'][$key]['link'];
           $hoverSrc=array_key_exists('hoverSrc',$tags['img'][$key]) ? $tags['img'][$key]['hoverSrc'] : '';
        ?>
        <a @if(!empty($link)) href="{{ $link }}" @endif target="_blank">
            <img id="{{ $key }}" src="{{ $src }}" />
            @if(!empty($hoverSrc))
                <hover-image
                    src="{{ $hoverSrc }}"
                    id="{{ $key }}"
                ></hover-image>
            @endif
        </a>

    @endif

@endif
