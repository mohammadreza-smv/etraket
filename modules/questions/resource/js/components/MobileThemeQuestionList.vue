<template>
    <div>
        <div class="product_item_box">

            <div class="question-header-box">
                <span>پرسش و پاسخ</span>
                <a>
                    <v-btn text type="success" class="add-question-link" @click="showList">
                        <v-icon>mdi-plus</v-icon>
                        <span>افزودن پرسش جدید</span>
                    </v-btn>
                </a>
            </div>

            <div class="question_div" style="padding:15px" v-for="question in lastQuestion">

                <div class="question_info">
                 <span class="user_name" v-if="question.getUser!=null && question.getUser.name!=''">
                       {{ question.getUser.name }}
                     @else
                       <span>ناشناس</span>
                    @endif
                 </span>
                 <span v-else>ناشناس</span>
                    <span class="date">{{ getDate(question.time) }}</span>
                </div>
                <div class="comment_content" v-html="question.question"></div>
            </div>

            <p class="center_message" v-if="lastQuestion.length===0 && sendRequest">

                تاکنون پرسشی برای این محصول ثبت نشده

            </p>


            <div class="show_more_div" v-if="question_count>2">
                <a class="more_question" @click="showList">
                    <span>مشاهده همه {{ replaceNumber(question_count) }} پرسش  کاربران</span>
                    <v-icon>mdi-chevron-left</v-icon>
                </a>
            </div>
        </div>

        <v-navigation-drawer
            v-model="drawer"
            fixed
            temporary
            width="100%"
            right

        >
            <v-app-bar
                fixed
                elevation="0"
            >
                <div style="padding-left:10px">
                    <v-icon @click="drawer=!drawer">mdi-arrow-right</v-icon>
                </div>
                <v-toolbar-title>پرسش و پاسخ</v-toolbar-title>

            </v-app-bar>


            <div class="content" style="padding-top:50px">

                <v-alert type="success" v-if="save_question" style="margin:10px">
                     پرسش شما با موفقیت ثبت شد و بعد از تایید نمایش داده خواهد شد
                </v-alert>

                <v-alert type="error" v-if="serverError">
                    خطا در ارسال اطلاعات مجددا تلاش نمایید
                </v-alert>

                <div @click="checkAuth" style="padding: 20px 15px">
                    <v-textarea
                        v-model="Question"
                        outlined
                        label="پرسش شما"
                        v-if="auth==='ok'" ></v-textarea>
                    <div v-else class="disabled_textarea_div"></div>
                    <div class="question_buttom_div">
                        <div class="agreement" style="display: flex">
                            <v-checkbox v-model="send_email"></v-checkbox>
                            <label>
                                اولین پاسخی که به پرسش من داده شد، از طریق ایمیل به من اطلاع دهید.
                                <br>
                                با انتخاب دکمه “ثبت پرسش”، <a href="">موافقت خود را با قوانین انتشار محتوا</a> در {{shop_name  }} اعلام می کنم.
                            </label>
                        </div>
                    </div>
                    <div class="question_buttom_div" style="margin-top:10px">
                        <div>
                            <v-btn @click="add_question()" color="secondary">
                                <template v-if="!send">
                                    <v-progress-circular
                                        indeterminate
                                        color="white"
                                    ></v-progress-circular>
                                </template>
                                <template v-else>
                                    ثبت پرسش
                                </template>
                            </v-btn>
                        </div>
                    </div>
                </div>

                <div v-if="show_loading_box" class="question-loading">
                    <v-progress-circular
                        indeterminate
                        color="red"
                    ></v-progress-circular>
                </div>

                <div class="questionlist" style="box-shadow:none">
                    <ul class="mobile-feq_list" v-for="(row,key) in Questions.data" v-bind:key="key">
                        <li>
                            <div class="mobile-section">
                                <div class="mobile-feq_header">
                                    <span v-if="row.user===undefined || row.user==null">ناشناس</span>
                                    <span v-else>{{ row.user.first_name }} {{ row.user.last_name }}</span>
                                    <span>{{ getDate(row.time) }}</span>
                                </div>
                                <p v-html="row.question"></p>

                                <div class="footer">

                                    <a  class="data_link" v-on:click="set_answer_id(row)">
                                        به این پرسش پاسخ دهید
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li class="anserFormItem" v-if="answer_id===row.id">
                            <div class="section" style="padding: 15px">
                                <div class="row">
                                    <v-alert type="success" v-if="save_answer">
                                        پاسخ شما با موفقیت ثبت شد و بعد از تایید نمایش داده خواهد شد
                                    </v-alert>

                                    <div style="width:100%;">
                                        <v-textarea
                                            v-model="answer"
                                            outlined
                                            label="پاسخ شما"></v-textarea>
                                    </div>
                                    <div class="question_buttom_div">
                                        <div>
                                            <v-btn @click="add_answer(answer_id)" color="primary">
                                                <template v-if="!send_answer">
                                                    <v-progress-circular
                                                        indeterminate
                                                        color="white"
                                                    ></v-progress-circular>
                                                </template>
                                                <template v-else>
                                                    ثبت پاسخ
                                                </template>
                                            </v-btn>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>


                        <li v-for="(row,key2) in row.answer" class="answer_li" v-bind:key="key2">
                            <div class="mobile-section">
                                <div class="answer_header">
                                    <span>پاسخ : </span>
                                    <span v-if="row.user===undefined || row.user.name===null">ناشناس</span>
                                    <span v-else>{{ row.user.first_name }} {{ row.user.last_name }}</span>
                                </div>
                                <p v-html="row.question"></p>
                                <div class="footer">
                                    <span>آیا این پاسخ برایتان مفید بود ؟</span>
                                    <div style="display: flex">
                                        <button class="btn_like" v-on:click="questionScore(row,'like',true)" v-bind:data-count="replaceNumber(row.like)">بله</button>
                                        <button class="btn_dislike" v-on:click="questionScore(row,'dislike',true)" v-bind:data-count="replaceNumber(row.dislike)">خیر</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div v-if="last_page>1" class="paginate">
                    <span :class="[page<last_page ? 'active' : '']" v-on:click="next()">بعدی</span>
                    <div>
                        صفحه
                        {{ replaceNumber(page) }}
                        از
                        {{ replaceNumber(last_page) }}
                    </div>
                    <span :class="[page>1 ? 'active' : '']" v-on:click="previous()">قبلی</span>
                </div>

            </div>
        </v-navigation-drawer>
    </div>
</template>
<script>
 import events from '../events';
  export default{
      name:"MobileThemeQuestionList",
      mixins:[events],
      data(){
          return {
              lastQuestion:[],
              question_count:0,
              sendRequest:false,
              monthName:[
                  'فروردین',
                  'اردیبهشت',
                  'خرداد',
                  'تیر',
                  'مرداد',
                  'شهریور',
                  'مهر',
                  'آبان',
                  'آذر',
                  'دی',
                  'بهمن',
                  'اسفند'
              ],
              ordering:'new',
              drawer:false,
              Questions:{data:[]},
              show_loading_box:false,
              page:1,
              last_page:0,
              Question:'',
              send_email:false,
              send:true,
              save_question:false,
              serverError:false,
              answer_id:0,
              save_answer:false,
              answer:'',
              send_answer:true
          }
      },
      props:['product_id','auth','shop_name'],
      mounted() {
        this.getLastQuestion();
      },
      methods:{
          getLastQuestion:function () {
              const url=this.$siteUrl+'/question/last/'+this.product_id;
              this.axios.get(url).then(response=>{
                  this.sendRequest=true;
                  if(response.data['question_count']!==undefined)
                  {
                      this.question_count=response.data['question_count'];
                  }
                  if(response.data['questions']!==undefined)
                  {
                      this.lastQuestion=response.data['questions'];
                  }
              }).catch(error=>{
                  this.sendRequest=true;
              });
          },
          showList:function () {
              this.drawer=true;
              if(this.Questions.data.length===0)
              {
                  this.getQuestions();
              }
          },
          getQuestions:function(){
              this.show_loading_box=true;
              const url=this.$siteUrl+"/site/get_question/"+this.product_id+"?page="+this.page+"&ordering="+this.ordering;
              this.axios.get(url).then(response=>{
                  this.Questions=response.data;
                  this.last_page=response.data.last_page
                  this.show_loading_box=false;
              }).catch(error=>{
                  this.show_loading_box=false;
              });
          },
          next:function()
          {
              if(this.page<this.last_page)
              {
                  this.page=this.page+1;
                  this.getQuestions();
              }
          },
          previous:function(){
              if(this.page>=2)
              {
                  this.page=this.page-1;
                  this.getQuestions();
              }
          },
          checkAuth:function()
          {
              if(this.auth==='no')
              {
                  this.$root.$emit('show_mobile_login');
              }
          },
          set_answer_id:function(question){
              if(this.auth==='no')
              {
                  this.$root.$emit('show_mobile_login');
              }
              else
              {
                  if(this.answer_id===question.id){
                      this.answer_id='';
                  }
                  else{
                      this.answer='';
                      this.answer_id=question.id;
                  }
              }
          },
      }

  };
</script>
<style scoped>
    .paginate{
        width: 95%;
        margin: 10px auto;
        box-shadow: 1px 1px 4px 0 rgba(0,0,0,.09);
        -webkit-box-shadow: 1px 1px 4px 0 rgba(0,0,0,.09);
        background-color: white;
        border-radius: 6px;
        -webkit-border-radius: 6px;
        display: flex;
        justify-content: space-between;
        padding: 10px;
        cursor: pointer;
    }
    .paginate span{
        color: #858585;
    }
    .paginate .active{
        color: black !important;
    }
</style>
