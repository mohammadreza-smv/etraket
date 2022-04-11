@extends('backend-theme::layout')

@section('content')

    @include('include.breadcrumb',['data'=>[
         ['title'=>'مدیریت کمیسیون ها','url'=>url('admin/commissions')],
         ['title'=>'ویرایش کمیسیون','url'=>url('admin/commissions/'.$commission->id.'/edit')]
    ]])

    <div class="panel">

        <div class="header">ویرایش کمیسیون</div>

        <div class="panel_content">

            @include('include.warring')
            {!! Form::model($commission,['url' => 'admin/commissions/'.$commission->id]) !!}
            {{ method_field('PUT') }}
            <div class="form-group">
                {{ Form::label('cat_id','انتخاب دسته : ') }}
                {{ Form::select('cat_id',$category,null,['class'=>'selectpicker auto_width','data-live-search'=>'true']) }}
                @if($errors->has('cat_id'))
                   <span class="has_error">{{ $errors->first('cat_id') }}</span>
                @endif
            </div>

            <div class="form-group">
                {{ Form::label('brand_id','انتخاب برند : ') }}
                {{ Form::select('brand_id',$brand,null,['class'=>'selectpicker auto_width','data-live-search'=>'true']) }}
                @if($errors->has('brand_id'))
                  <span class="has_error">{{ $errors->first('brand_id') }}</span>
               @endif
            </div>

            <div class="form-group">

                {{ Form::label('percentage','درصد کمیسیون') }}
                {{ Form::text('percentage',null,['class'=>'form-control left']) }}
                @if($errors->has('percentage'))
                    <span class="has_error">{{ $errors->first('percentage') }}</span>
                @endif
            </div>

            <button class="btn btn-primary">ویرایش </button>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
