<div class="product_item_box">
    <div class="item_box remove_item_box_shadow">
        <span>پرسش و پاسخ</span>
        <a  class="add_link" id="add_question">
            <span>ارسال پاسخ</span>
            <span class="fa fa-plus"></span>
        </a>
    </div>
    <?php $jdf=new \App\Lib\Jdf(); ?>
    @foreach($questions as $question)
         <div class="question_div">
             <div class="question_info">
                 <span class="user_name">
                    @if(!empty($question->getUser->name))
                       {{ $question->getUser->name }}
                     @else
                       <span>ناشناس</span>
                    @endif
                 </span>
                 <span class="date">{{ $jdf->jdate('d F Y',$question->time) }}</span>
             </div>

             <div class="comment_content">{!! strip_tags($question->question) !!}</div>
         </div>
    @endforeach


    @if(sizeof($questions)==0)
       <p class="center_message">تاکنون پرسشی برای این محصول ثبت نشده</p>
    @endif

   @if($question_count>2)
    <div class="show_more_div">
        <a class="more_link" id="show_more_question">
            <span>مشاهده همه {{ replace_number($question_count) }} پرسش  کاربران</span>
            <span class="fa fa-angle-left"></span>
        </a>
    </div>
   @endif

   @php
       $auth=Auth::check() ? 'ok' : 'no';
   @endphp
   <mobile-theme-question-list :product_id="'{{ $product->id }}'" :auth="'{{ $auth }}'" ></mobile-theme-question-list>

</div>
