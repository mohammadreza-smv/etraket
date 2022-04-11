@if(array_key_exists($args['tag'],$tags))

   @if(array_key_exists($args['id'],$tags[$args['tag']]))

       @if(array_key_exists('view',$tags[$args['tag']][$args['id']]))

           @includeIf($tags[$args['tag']][$args['id']]['view'])
       @endif

   @endif

@endif
