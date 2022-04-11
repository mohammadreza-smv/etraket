@if(isset($design_config))

    <?php
        if(defined('locationParam')){
            $location=str_replace(':widgetParam',locationParam,$location);
        }
        else{
            $location=str_replace(':widgetParam','',$location);
        }
        if(array_key_exists($location,$design_config)){
            $rows=$design_config[$location]['rows'];
            $tags=$design_config[$location]['tags'];
        }
    ?>

    @if(array_key_exists($location,$design_config))

        <div id="{{ $location }}">
            @foreach($rows as $row)
                <div id="{{ $row['id'] }}">

                    @if(array_key_exists('child',$row))
                        @foreach($row['child'] as $key=>$value)

                            @if($value['type']=='html')
                                @includeIf('themes::widgets.'.$value['tag'],['args'=>$value])
                            @endif

                            @if($value['type']=='widget')

                                @includeIf('themes::widgets.widget-view',['args'=>$value,'row'=>$row])
                            @endif

                            @if($value['type']=='box')
                                <div id="{{ $value['id'] }}">
                                    @foreach($value['child'] as $key2=>$value2)
                                        @if($value2['type']=='html')
                                            @includeIf('themes::widgets.'.$value2['tag'],['args'=>$value2])
                                        @endif

                                        @if($value2['type']=='widget')
                                            @includeIf('themes::widgets.widget-view',['args'=>$value2,'row'=>$row])
                                        @endif

                                        @if($value2['type']=='box')
                                             <div id="{{ $value2['id'] }}">

                                                 @foreach($value2['child'] as $key3=>$value3)

                                                     @if($value3['type']=='html')
                                                         @includeIf('themes::widgets.'.$value3['tag'],['args'=>$value3])
                                                     @endif

                                                 @endforeach

                                             </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                        @endforeach
                    @endif

                </div>
            @endforeach
        </div>
    @endif

@else

@endif

