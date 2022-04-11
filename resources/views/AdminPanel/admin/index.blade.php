@extends('backend-theme::layout')

@section('content')

    <div>



        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <div class="header">
                        مرسوله ها
                    </div>
                    <div class="panel_content submission_box">
                        <table class="table">
                            <tr>
                                <td>
                                    <img src="{{ url('files/images/step1.svg') }}" style="width: 60px">
                                    کل مرسوله ها
                                </td>
                                <td>
                                    {{ replace_number($submissions) }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ url('files/images/step1.svg') }}" style="width: 60px">
                                    مرسوله های تایید شده
                                </td>
                                <td>
                                    {{ replace_number($submissions_approved) }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ url('files/images/step2.svg') }}" style="width: 60px">
                                    مرسوله های ارسالی امروز
                                </td>
                                <td>
                                    {{ replace_number($items_today) }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ url('files/images/step3.svg') }}" style="width: 60px">
                                    مرسوله های آماده ارسال
                                </td>
                                <td>
                                    {{ replace_number($submissions_ready) }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ url('files/images/step4.svg') }}" style="width: 60px">
                                    مرسوله های ارسال شده به پست
                                </td>
                                <td>
                                    {{ replace_number($posting_send) }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ url('files/images/step5.svg') }}" style="width: 60px">
                                    مرسوله های آماده دریافت از پست
                                </td>
                                <td>
                                    {{ replace_number($posting_receive) }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <img src="{{ url('files/images/step6.svg') }}" style="width: 60px">
                                    مرسوله های تحویل داده شده
                                </td>
                                <td>
                                    {{ replace_number($delivered) }}
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel">
                    <div class="header">
                       اطلاعات کلی فروشگاه
                    </div>
                    <div class="panel_content submission_box shop_info">
                        <table class="table">
                            <tr>
                                <td>
                                    <a href="{{ url('admin/users') }}" target="_blank">
                                    <span class="fa fa-user-o"></span>
                                    کاربران سایت
                                    </a>
                                </td>
                                <td>
                                    <span class="count_span user">{{ replace_number($user_count) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{ url('admin/orders') }}" target="_blank">
                                    <span class="fa fa-list"></span>
                                    سفارشات ثبت شده
                                    </a>
                                </td>
                                <td>
                                    <span class="count_span order">{{ replace_number($order_count) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                   <a href="{{ url('admin/comments') }}" target="_blank">
                                       <span class="fa fa-comment-o"></span>
                                       نظرات ثبت شده
                                   </a>
                                </td>
                                <td>
                                    <span class="count_span comment">{{ replace_number($comment_count) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{ url('admin/questions') }}" target="_blank">
                                        <span class="fa fa-question"></span>
                                        پرسش های ثبت شده
                                    </a>
                                </td>
                                <td>
                                    <span class="count_span question">{{ replace_number($total_question_count) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{ url('admin/products') }}" target="_blank">
                                        <span class="fa fa-shopping-cart"></span>
                                        محصولات ثبت شده
                                    </a>
                                </td>
                                <td>
                                    <span class="count_span product">{{ replace_number($product_count) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{ url('admin/sellers') }}" target="_blank">
                                        <span class="fa fa-home"></span>
                                        فروشندگان
                                    </a>
                                </td>
                                <td>
                                    <span class="count_span user">{{ replace_number($seller_count) }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('footer')

@endsection
