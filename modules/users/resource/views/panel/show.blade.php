@extends('backend-theme::layout')

@section('content')

    @include('include.breadcrumb',['data'=>[
          ['title'=>'مدیریت کاربران','url'=>url('admin/users')],
          ['title'=>'مشخصات کاربر : '.$user->mobile,'url'=>url('admin/users/'.$user->id)]
        ]])
    <div class="panel">

        <div class="header">
            <div>
                <span>مشخصات کاربر : </span>
                <span>{{ $user->name }}</span>
                (<span>
                   @if ($user->getRole)
                    {{ $user->getRole->name }}
                   @elseif($user->role=='admin')
                    مدیر
                   @else
                      کاربر عادی
                   @endif
                </span>)
            </div>
        </div>

        <div class="panel_content">

            <?php $additionalInfo=$user->getAdditionalInfo;  ?>
            @include('include.Alert')

            <table class="table table-bordered order_table_info" style="margin:0px !important;width:100% !important">
                <tr>
                    <td>
                        نام و نام خانوادگی :
                        <span>
                            {{ getUserPersonalData($additionalInfo,'first_name','last_name') }}
                        </span>
                    </td>
                    <td>
                        پست الکترنیکی :
                        <span>{{ getUserPersonalData($additionalInfo,'email') }}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        شماره تلفن همراه :
                        <span>{{ $user->mobile }}</span>
                    </td>
                    <td>
                        کد ملی :
                        <span>{{ getUserPersonalData($additionalInfo,'national_identity_number') }}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        دریافت خبرنامه :
                        <span>
                            @if(getUserPersonalData($additionalInfo,'newsletter')=='yes')
                                بله
                            @else
                               خیر
                            @endif
                        </span>
                    </td>
                    <td>
                        شماره کارت بانکی :
                        <span>{{ getUserPersonalData($additionalInfo,'bank_card_number') }}</span>
                    </td>
                </tr>
            </table>

            @if (!empty(getUserData('company_name',$additionalInfo)))
            <p style="margin-top:20px;font-weight:bold;">اطاعات حساب حقوقی</p>
            <table class="table table-bordered order_table_info" style="margin:0px !important;width:100% !important">
                <tr>
                    <td>
                        نام شرکت :
                        <span>
                            {{ getUserPersonalData($additionalInfo,'company_name') }}
                        </span>
                    </td>
                    <td>
                        کد اقتصادی :
                        <span>{{ getUserPersonalData($additionalInfo,'company_economic_number') }}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        شناسه ملی :
                        <span>{{ getUserPersonalData($additionalInfo,'company_national_identity_number') }}</span>
                    </td>
                    <td>
                        شماره ثبت :
                        <span>{{ getUserPersonalData($additionalInfo,'company_registration_number') }}</span>
                    </td>
                </tr>

                <tr>
                    <td>
                        شماره تلفن ثابت :
                        <span>{{ getUserPersonalData($additionalInfo,'company_phone') }}</span>
                    </td>
                    <td>
                       استان و شهر :
                       @if ($additionalInfo)
                         <span>{{ $additionalInfo->getProvince->name.' '.$additionalInfo->getCity->name }} </span>
                       @endif

                    </td>
                </tr>

            </table>
            @endif

            <div id="tab_div">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="order-tab" data-toggle="tab" href="#last-order" role="tab" aria-controls="home" aria-selected="true">
                          <span class="fa fa-shopping-cart"></span>
                          <span>آخرین سفارشات کاربر</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="comment-tab" data-toggle="tab" href="#last-comment" role="tab" aria-controls="profile" aria-selected="false">
                        <span class="fa fa-comment-o"></span>
                        <span>آخرین نظرات کاربر</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="questtion-tab" data-toggle="tab" href="#last-questtion" role="tab" aria-controls="contact" aria-selected="false">
                        <span class="fa fa-question"></span>
                        <span>آخرین پرسش های کاربر</span>
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="last-order" role="tabpanel" aria-labelledby="home-tab">
                        <div class="conetnt_tab_div">
                            @include('include.orderList',['remove_delete_link'=>true])
                            @if (sizeof($orders)>0)
                                <a href="{{ url('admin/orders?user_id='.$user->id) }}" target="_blank">
                                    <span class="fa fa-arrow-left"></span>
                                    <span>نمایش لیست کامل سفارشات کاربر</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="last-comment" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="conetnt_tab_div">
                            @include('include.CommentList',['remove_delete_link'=>true])
                            @if (sizeof($comments)>0)
                                <a href="{{ url('admin/comments?user_id='.$user->id) }}" target="_blank">
                                    <span class="fa fa-arrow-left"></span>
                                    <span>نمایش لیست کامل نظرات کاربر</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="last-questtion" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="conetnt_tab_div">
                            @include('include.QuestionList',['remove_delete_link'=>true])
                            @if (sizeof($questions)>0)
                                <a href="{{ url('admin/questions?user_id='.$user->id) }}" target="_blank">
                                    <span class="fa fa-arrow-left"></span>
                                    <span>نمایش لیست پرسش نظرات کاربر</span>
                                </a>
                            @endif
                        </div>
                    </div>
                  </div>
            </div>

        </div>

    </div>

@endsection
