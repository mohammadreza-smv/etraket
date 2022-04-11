@extends('front-theme::layouts.user-panel')

@section('panel-content')
    <?php $args=['title'=>'نظرات  شما']; ?>
    <x-user-panel-box :args="$args">
        <panel-comment-list
            :comments="{{ json_encode($comments) }}"
        ></panel-comment-list>

        {{ $comments->links() }}
    </x-user-panel-box>
@endsection
