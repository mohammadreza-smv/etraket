<template>
    <transition name="data-box">

          <div class="vue_mobile_data_box" v-if="show_question_form">

            <div class="header">
                <span>{{ header_title }}</span>
                <a v-on:click="show_question_form=!show_question_form">
                    <span>بازگشت</span>
                    <span class="fa fa-angle-left"></span>
                </a>
            </div>
            <div class="content vue_content_box">

                <div class="questionlist question_form">

                  <div class="question_form_label">
                      <span v-if="question_id==0">{{ question_label }} خود را در مورد این محصول مطرح کنید</span>
                      <div v-if="question_text" class="old_question">
                         <span>ارسال پاسخ به : </span>
                         <p v-html=question_text></p>
                      </div>
                  </div>

                  <div v-if="save_question" class="alert alert-warning">
                   پرسش شما با موفقیت ثبت شد و بعد از تایید نمایش داده خواهد شد
                  </div>

                  <div v-if="save_answer" class="alert alert-warning">
                     پاسخ شما با موفقیت ثبت شد و بعد از تایید نمایش داده خواهد شد
                 </div>


                  <textarea v-model="Question"></textarea>

                  <div class="question_buttom_div">
                    <div class="agreement" v-if="question_id==0">
                        <span v-on:click="send_email=!send_email" :class="[send_email ? 'check_box active' : 'check_box']"></span>
                        <label>
                            اولین پاسخی که به پرسش من داده شد، از طریق ایمیل به من اطلاع دهید.
                        </label>
                    </div>
                    <div>
                        <button v-on:click="add_question(question_id)" class="btn add_question">ثبت {{ question_label }}</button>
                    </div>
                  </div>

                  <div  class="question_form_label2">
                       با انتخاب دکمه “ثبت پرسش”، <a href="">موافقت خود را با قوانین انتشار محتوا</a> در دیجی آنلاین اعلام می کنم.
                  </div>
                </div>
            </div>
          </div>
    </transition>
</template>


<script>
import events from '../events';
import myMixin from "../../../../../resources/js/myMixin";
export default({
    name:"MobileQuestionForm",
    mixins:[myMixin,events],
    props:['product_id'],
    data(){
        return {
            header_title:'ارسال پرسش',
            show_question_form:false,
            Question:'',
            send_email:false,
            save_question:false,
            save_answer:false,
            send:true,
            question_label:'',
            question_id:0,
            question_text:false
        }
    },
    methods:{
        updateData:function(show,header_title,question_label,question_id,question_text){
            this.show_question_form=show;
            this.header_title=header_title;
            this.question_label=question_label;
            this.question_id=question_id;
            this.question_text=question_text;
        }
    }
})
</script>


