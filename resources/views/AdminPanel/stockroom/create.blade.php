@extends('layouts.admin')

@section('content')

    @include('include.breadcrumb',['data'=>[
         ['title'=>'مدیریت انبار ها','url'=>url('admin/stockrooms')],
         ['title'=>'افزودن انبار جدید','url'=>url('admin/stockrooms/create')]
    ]])

    <div class="panel">

        <div class="header">افزودن انبار جدید</div>

        <div class="panel_content">


            {!! Form::open(['url' => 'admin/stockrooms']) !!}

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

            <button class="btn btn-success">ثبت </button>
            {!! Form::close() !!}
        </div>

    </div>
@endsection

