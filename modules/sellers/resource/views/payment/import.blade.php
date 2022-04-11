@extends('backend-theme::layout')

@section('content')

    <div>
        @include('backend-theme::breadcrumb',['data'=>[
            ['title'=>'مدیریت فروشندگان','url'=>url('admin/sellers/list')],
            ['title'=>'ثبت پرداخت ها','url'=>url('admin/sellers/pay/import')]
      ]])

        <?php $args=['title'=>'ثبت پرداخت ها'] ?>
        <x-panel-box :args="$args">
            @include('include.warring')
            @include('include.alert')

            {!! Form::open(['url' => 'admin/sellers/pay/import','files'=>true]) !!}

            <div class="form-group">
                <label for="payment_file">انتخاب فایل اکسل : </label>
                <input type="file" name="payment_file" id="payment_file"  style="direction:ltr">
                @if($errors->has('payment_file'))
                    <span class="has_error">{{ $errors->first('payment_file') }}</span>
                @endif
            </div>

            <button class="btn btn-success">ثبت </button>
            {!! Form::close() !!}

        </x-panel-box>

    </div>

@endsection
