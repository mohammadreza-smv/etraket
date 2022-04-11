@if(isset($name))
    <?php $position_views=position_view($name) ?>

    @foreach($position_views as $view)
        <?php $a=isset($args) ? $args : [] ?>
        @includeIf($view['view'],$a)
    @endforeach
@endif
