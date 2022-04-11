@extends('front-theme::layouts.mobile.user-panel')


@section('panel-content')

    <?php $args=['title'=>'پیام های من']; ?>

    <?php use App\Lib\Jdf;$jdf=new Jdf(); ?>

    <x-user-panel-box :args="$args">

       <panel-message>
           <div class="message_list">

               @if(Session::has('add-message'))
                   <v-alert type="success" dismissible>
                       {{ Session::get('add-message') }}
                   </v-alert>
               @endif

               @includeIf('messages::userPanel._searchForm')

               <a href="{{ url('user/profile/messages/create') }}" class="router-link"  style="margin-bottom:20px;display: block">
                   <v-btn color="success">
                       <span>ارسال پیام جدید</span>
                   </v-btn>
               </a>

               @foreach($messages as $key=>$value)
                   <div class="mobile-message-box">
                       <div class="profile_info_row" style="border-top:0px">
                           <div>
                               عنوان
                           </div>
                           <a href="{{ url('user/profile/messages/'.$value->id) }}" class="router-link">
                               <v-icon>mdi-</v-icon>
                           </a>
                       </div>
                       <div class="profile_info_row">
                           <span>ارسال کننده</span>
                           <span>
                     @if($value->from)
                                   <span class="form_link">
                            @if($value->from_id==$value->user_id)
                                           {{ $value->from->name }}
                                       @else
                                           {{ config('shop-info.shop_name') }}
                                       @endif
                        </span>
                               @endif
                </span>
                       </div>
                       <div class="profile_info_row">
                           <span>دریافت کننده</span>
                           <span>
                    @if($value->to)
                                   <span class="to_link">
                             {{ $value->to->name }}
                        </span>
                               @else
                                   <span class="to_link">
                              {{ config('shop-info.shop_name') }}
                        </span>
                               @endif
                </span>
                       </div>
                       <div class="profile_info_row">
                           <span>زمان ارسال</span>
                           <span>
                    {{ $jdf->jdate('H:i:s',$value->time)  }} / {{  $jdf->jdate('Y-n-j',$value->time) }}
                </span>
                       </div>
                   </div>
               @endforeach
               {{ $messages->links() }}
           </div>
       </panel-message>

    </x-user-panel-box>


@endsection

