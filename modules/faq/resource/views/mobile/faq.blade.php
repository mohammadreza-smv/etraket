@extends('front-theme::layouts.mobile-app')

@section('content')

    <mobile-faq>

        <div class="content">

            <div class="page_cover" style="background:linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)), url('<?= url('/modules/faq/9de6ef39.jpg') ?>') top no-repeat" >

                <div class="page_cover_title">
                    <h4>پاسخ پرسش‌های پرتکرار</h4>
                </div>

                <div class="search_box">
                    <faq-search></faq-search>
                </div>

            </div>

            @if($request->get('q')!='')
                <div class="page faq_list" >

                    <h6>
                        جستجوی "{{ $q }}"
                    </h6>
                    <div style="margin-top:30px">
                        @foreach($search_question as $key=>$value)
                            <div class="common_question">
                                <div class="common_question_header">
                                    <h6>
                                        <v-icon>mdi-chevron-down</v-icon>
                                        {{ $value->title }}
                                    </h6>
                                </div>
                                <div class="small_answer">
                                    {!! strip_tags($value->small_answer,'<ul><li><a><p><br>') !!}

                                    @if(!empty($value->answer))
                                        <div class="more_data">
                                            <a href="{{ url('faq/question/'.$value->id) }}" class="router-link data_link">مشاهده توضیحات تکمیلی</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        @if(sizeof($search_question)==0)
                            <p>موردی یافت نشد </p>
                        @endif
                    </div>
                </div>
            @endif

            <div class="page faq_list @if($request->get('q')!='') common_question_list @endif">

                <h6>دسته‌بندی پرسش‌ها</h6>
                <div class="feq_cat_list">
                    @foreach($cat as $key=>$value)
                        <a href="{{ url('faq/category/'.$value->id) }}" class="router-link">
                            <div class="feq_cat @if(($key+1)%2!=0) cat_list_border_left @endif">
                                @if(!empty($value->icon))
                                    <div class="faq_cat_icon">
                                        <img src="{{ url('files/upload/'.$value->icon) }}" >
                                    </div>
                                @endif
                                <span>{{ $value->title }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="page faq_list common_question_list" >

                <h6>پرتکرارترین پرسش‌ها</h6>
                <div style="margin-top:20px">
                    @foreach($question as $key=>$value)
                        <div class="common_question">
                            <div class="common_question_header">
                                <h6>
                                    <v-icon>mdi-chevron-down</v-icon>
                                    {{ $value->title }}
                                </h6>
                            </div>
                            <div class="small_answer">
                                {!! strip_tags($value->small_answer,'<ul><li><a><p><br>') !!}

                                @if(!empty($value->answer))
                                    <div class="more_data">
                                        <a href="{{ url('faq/question/'.$value->id) }}" class="router-link data_link">مشاهده توضیحات تکمیلی</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </mobile-faq>

@endsection
