@extends('blog::layout')

@section('content')

    <div>
        @includeIf('themes::widgets.view',['location'=>'blog_index'])
    </div>
@endsection
