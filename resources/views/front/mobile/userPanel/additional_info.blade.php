@extends('layouts.mobile')

@section('content')

    @if(Session::has('status'))
        <div class="alert alert-success custom-alert">{{ Session::get('status') }}</div>
    @endif
    <div class="profile_item additional_info_div">
        <div class="profile_menu profile_info">
            <form method="post" id="additional_info" action="{{ url('user/profile/additional-info') }}">
                @csrf

                <?php
                $personal_input=['first_name'=>'نام','last_name'=>'نام خانوادگی','national_identity_number'=>'کد ملی','mobile_phone'=>'شماره موبایل','email'=>'ایمیل','bank_card_number'=>'شماره کارت'];
                $Legal=['company_name'=>'نام شرکت','company_economic_number'=>'کد اقتصادی','company_national_identity_number'=>'شناسه ملی','company_registration_number'=>'شماره ثبت','company_phone'=>'شماره تلفن ثابت'];
                ?>
                <div class="row">
                    <div class="col-md-6 form-column">
                        <span class="profile_menu_title center" style="padding: 0px;margin-top:0px">حساب شخصی</span>
                        @foreach($personal_input as $key=>$value)
                            <div class="form-group">
                                <div class="account_title">{{ $value }}</div>
                                <label class="input_label">
                                    <input type="text" class="form-control @if($errors->has($key)) validate_error_border @endif" value="{{ getUserData($key,$additionalInfo) }}" name="{{ $key }}" placeholder="لطفا {{ $value }} خود را وارد نمایدد">
                                    @if($errors->has($key))
                                        <label class="feedback-hint" style="display:block">
                                            <span>{{ $errors->first($key) }}</span>
                                        </label>
                                    @endif
                                </label>
                            </div>
                        @endforeach

                        <div class="form-group">
                            <input type="checkbox" @if(getUserData('newsletter',$additionalInfo)=='yes') checked="checked" @endif name="newsletter" id="newsletter_input" class="form-check-input">
                            <span class="check_box @if(getUserData('newsletter',$additionalInfo)=='yes')  active @endif" id="newsletter"></span>
                            <span class="form-check-label">اشتراک در خبرنامه {{ env('SHOP_NAMR') }}</span>
                        </div>

                    </div>
                    <div class="col-md-6 form-column">

                        <span class="profile_menu_title center" id="Legal_title" style="padding: 0px;margin-top: 20px">حساب حقوقی</span>
                        <div class="toggle_box_box">
                            <div class="toggle_box">
                                <div class="toggle-light" id="account_type"></div>
                                <input type="hidden" name="Legal" id="Legal" value="{{ old('Legal') ? old('Legal') : 'false' }}">
                            </div>
                            <span>مایل به تکمیل اطلاعات حقوقی برای خرید سازمانی هستم.</span>
                        </div>
                        <div id="Legal_box">
                            <p class="center Legal_text">
                                با تکمیل اطلاعات حقوقی سازمان مورد نظر خود می‌توانید اقدام به خرید سازمانی با دریافت فاکتور رسمی و گواهی ارزش افزوده نمایید.
                            </p>
                            @foreach($Legal as $key=>$value)
                                <div class="form-group">
                                    <div class="account_title">{{ $value }}</div>
                                    <label class="input_label">
                                        <input type="text" class="form-control @if($errors->has($key)) validate_error_border @endif" value="{{ getUserData($key,$additionalInfo) }}" name="{{ $key }}" placeholder="لطفا {{ $value }} خود را وارد نمایدد">
                                        @if($errors->has($key))
                                            <label class="feedback-hint" style="display:block">
                                                <span>{{ $errors->first($key) }}</span>
                                            </label>
                                        @endif
                                    </label>
                                </div>
                            @endforeach

                            <div class="account_title">محل دفتر مرکزی</div>
                            <div class="row" id="location">
                                <div class="col-md-6">
                                    <label class="input_label">
                                        {{ Form::select('province_id',$province,getUserData('province_id',$additionalInfo),['class'=>'selectpicker','data-live-search'=>'true','id'=>'profile_province_id']) }}
                                        @if($errors->has('province_id'))
                                            <label class="feedback-hint" style="display:block">
                                                <span>استان انتخاب نشده</span>
                                            </label>
                                        @endif
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="input_label">
                                        {{ Form::select('city_id',$city,getUserData('city_id',$additionalInfo),['class'=>'selectpicker','data-live-search'=>'true','id'=>'profile_city']) }}
                                        @if($errors->has('city_id'))
                                            <label class="feedback-hint" style="display:block">
                                                <span>شهر انتخاب نشده</span>
                                            </label>
                                        @endif
                                    </label>
                                </div>
                            </div>




                            <div class="form_cover" @if(old('Legal')=='true') style="display: none" @endif>
                                <span>ثبت اطلاعات حقوقی</span>
                            </div>
                        </div>


                    </div>
                </div>


                <div class="footer">
                    <button class="btn profile_edit_link" style="color:#00bfd6 !important;width:100%;">ثبت اطلاعات</button>
                </div>
            </form>
        </div>

    </div>
@endsection


@section('head')
    <link rel="stylesheet" href="{{ url('css/toggles-full.css') }}"/>
@endsection
@section('footer')
    <script type="text/javascript" src="{{ url('js/toggles.min.js') }}"></script>
    <script>
        $("#account_type").toggles({
            type:'Light',
            text:{'on':'','off':''},
            width:50,
            direction:'rtl',
            on:true
        });
        $("#account_type").on('toggle',function (e,action) {
            if(action){
                $('.form_cover').show();
                $("#Legal_box").hide();
                document.getElementById('Legal').value=false;
            }
            else{
                $('.form_cover').hide();
                $("#Legal_box").show();
                document.getElementById('Legal').value=true;
            }
        });

        @if(old('Legal')=='true' || getUserData('company_name',$additionalInfo))
            $("#account_type").click();
        @endif
    </script>
@endsection
