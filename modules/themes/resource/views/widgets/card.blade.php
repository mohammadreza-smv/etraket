<?php
$key=$args['id'];
?>

@if(array_key_exists('card',$tags))

    @if(array_key_exists($key,$tags['card']))

        <?php
            $title=$tags['card'][$key]['title'];
            $content=$tags['card'][$key]['content'];
        ?>

        <a @if(!empty($link)) href="{{ $link }}" @endif target="_blank">
            <theme-card
                id="{{ $key }}"
                tag_id="{{ $key }}"
            >
                <template v-slot:title>
                    {{ $title }}
                </template>

                <template v-slot:content>
                    {{ $content }}
                </template>
            </theme-card>

        </a>

    @endif

@endif
