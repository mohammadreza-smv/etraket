@extends('front-theme::layouts.app')

@section('content')
    <comment-form :product="{{ json_encode($product) }}"></comment-form>
@endsection
