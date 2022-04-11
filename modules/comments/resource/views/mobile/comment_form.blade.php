@extends('front-theme::layouts.mobile-app')

@section('content')
    <mobile-comment-form :product="{{ json_encode($product) }}"></mobile-comment-form>
@endsection
