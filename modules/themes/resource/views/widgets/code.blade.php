<?php
    $key=$args['id'];
?>
@if(array_key_exists('code',$tags))

    @if(array_key_exists($key,$tags['code']))

        <?php
            $content=$tags['code'][$key]['content'];
        ?>

        <div id="{{ $key }}" >
            {!! $content !!}
        </div>

    @endif

@endif

