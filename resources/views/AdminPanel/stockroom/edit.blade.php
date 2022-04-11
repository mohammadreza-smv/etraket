@extends('backend-theme::layout')

@section('content')

    @include('include.breadcrumb',['data'=>[
         ['title'=>'مدیریت انبار ها','url'=>url('admin/stockrooms')],
         ['title'=>'ویرایش انبار','url'=>url('admin/stockrooms/'.$Stockroom->id.'/edit')]
    ]])

    <div class="panel">

        <div class="header">ویرایش انبار - {{ $Stockroom->name }}</div>

        <div class="panel_content">


            {!! Form::model($Stockroom,['url' => 'admin/stockrooms/'.$Stockroom->id]) !!}
            {!! method_field("PUT") !!}
            <div class="form-group">

                {{ Form::label('name','نام انبار : ') }}
                {{ Form::text('name',null,['class'=>'form-control']) }}
                @if($errors->has('name'))
                    <span class="has_error">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group textarea_feild">

                {{ Form::label('address','آدرس انبار : ') }}
                {{ Form::textarea('address',null,['class'=>'form-control']) }}
            </div>

            <button class="btn btn-primary">ویرایش </button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

