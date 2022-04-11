<?php
$key=$args['id'];
?>
@if(array_key_exists('img',$tags))

    @if(array_key_exists($key,$tags['ul']))

        <?php
            $items=$tags['ul'][$key]['items'];
            $title=$tags['ul'][$key]['title'];
        ?>


        <theme-ul
            id="{{ $key }}"
            tag_id="{{ $key }}"
         >
            <span class="ul-title">
                {{ $title }}
            </span>

            <ul>

                @foreach($items as $item)
                    @if(!empty($item['title'] ))
                        <li>
                            <a @if(!empty($item['link'])) href="{{ $item['link'] }}" @endif>
                                {{ $item['title'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>

        </theme-ul>

    @endif

@endif
