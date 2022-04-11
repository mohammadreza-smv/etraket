@extends('front-theme::layouts.app')

@section('content')

    <faq>

        <div class="content" style="margin:-15px">

            <div  style="background:linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)), url('<?= url('/modules/faq/9de6ef39.jpg') ?>') top no-repeat"  class="page_cover">

                <div class="page_cover_title">
                    <h3>پاسخ پرسش‌های پرتکرار</h3>
                </div>

                <div class="search_box">
                    <faq-search></faq-search>
                </div>

            </div>

            <div class="page faq_list" >

                <div  class="cat_info">
                    <h5>{{ $question->title }}</h5>
                </div>
                <div class="answer">
                    {!! strip_tags($question->answer,'<p><ul><li><img><video><a><span><div>') !!}
                </div>
            </div>
            <div class="page faq_list common_question_list" >

                <h5>پرتکرارترین پرسش‌ها</h5>
                <div style="margin-top:30px">
                    @foreach($pin_question as $key=>$value)
                        <div class="common_question">
                            <div class="common_question_header">
                                <h5>{{ $value->title }}</h5>
                                <v-icon>mdi-chevron-down</v-icon>
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

    </faq>

@endsection
