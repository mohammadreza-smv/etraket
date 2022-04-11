<template>
        <div class="question_box">

            <v-alert type="success" v-if="save_question">
                 پرسش شما با موفقیت ثبت شد و بعد از تایید نمایش داده خواهد شد
            </v-alert>

            <v-alert type="error" v-if="serverError">
                خطا در ارسال اطلاعات مجددا تلاش نمایید
            </v-alert>

            <div class="feq_headline">
                پرسش و پاسخ
                <span>پرسش خود را در مورد محصول مطرح نمایید</span>
            </div>

            <div v-on:click="checkAuth()">
                <v-textarea v-model="Question" v-if="auth==='ok'" ></v-textarea>
                <div v-else class="disabled_textarea_div"></div>
                <div class="question_buttom_div">
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
                    <div class="agreement" style="display: flex">
                        <v-checkbox v-model="send_email"></v-checkbox>
                        <label>
                            اولین پاسخی که به پرسش من داده شد، از طریق ایمیل به من اطلاع دهید.
                            <br>
                            با انتخاب دکمه “ثبت پرسش”، <a href="">موافقت خود را با قوانین انتشار محتوا</a> در {{shop_name  }} اعلام می کنم.
                        </label>
                    </div>
                </div>
            </div>

            <div class="feq_filter" v-if="getServerData">
               <p>پرسش ها و پاسخ ها</p>
               <ul class="feq_filter_item" data-title="مرتب سازی بر اساس :">
                  <li :class="[ordering==='new' ? 'is-active' : '']" v-on:click="set_ordering('new')">جدید ترین پرسش</li>
                  <li :class="[ordering==='answer_count' ? 'is-active' : '']" v-on:click="set_ordering('answer_count')">بیشترین پاسخ به پرسش</li>
                  <li :class="[ordering==='user' ? 'is-active' : '']" v-on:click="set_ordering('user')">پرسش های شما</li>
               </ul>
           </div>

            <div v-if="loading" class="question-loading">
                <v-progress-circular
                    indeterminate
                    color="red"
                ></v-progress-circular>
            </div>

            <template v-else>
                <ul class="feq_list" v-for="(row,key) in list.data" v-bind:key="key">
                    <li>
                        <div class="section">
                            <div class="feq_header">
                                <div>
                                    <p style="margin-bottom:0px"> <v-icon color="#35ccde">mdi-help</v-icon></p>
                                    پرسش
                                    <span v-if="row.user==undefined || row.user==null">ناشناس</span>
                                    <span v-else>{{ row.user.first_name }} {{ row.user.last_name }}</span>
                                </div>
                            </div>
                            <p v-html="row.question"></p>

                            <div class="footer">
                                <span>{{ getDate(row.time) }}</span>
                                <a  class="data_link" v-on:click="set_answer_id(row.id)">
                                    به این پرسش پاسخ دهید
                                </a>
                            </div>
                        </div>
                    </li>

                    <li class="anserFormItem" v-if="answer_id===row.id">
                        <div class="section">
                            <div class="feq_header">
                                <p>
                                    پاسخ
                                </p>
                            </div>
                            <div class="row">
                                <h5>به این سوال پاسخ دهید</h5>
                                <v-alert type="success" v-if="save_answer">
                                    پاسخ شما با موفقیت ثبت شد و بعد از تایید نمایش داده خواهد شد
                                </v-alert>

                                <div style="width:100%">
                                    <v-textarea v-model="answer"></v-textarea>
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
                                    <div class="agreement">
                                        <label>
                                            با انتخاب دکمه “ثبت پرسش”، <a href="">موافقت خود را با قوانین انتشار محتوا</a> در
                                            {{shop_name }} اعلام می کنم.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li v-for="(row,key2) in row.answer" class="answer_li" v-bind:key="key2">
                        <div class="section">
                            <div class="feq_header">
                                <p>
                                    پاسخ
                                    <span v-if="row.user==undefined || row.user.name==null">ناشناس</span>
                                    <span v-else>{{ row.user.first_name }} {{ row.user.last_name }}</span>
                                </p>
                            </div>
                            <p v-html="row.question"></p>
                            <div class="footer">
                                <span>{{ getDate(row.time) }}</span>
                                <div>
                                    آیا این پاسخ برایتان مفید بود ؟
                                    <button class="btn_like" v-on:click="questionScore(row,'like')" v-bind:data-count="replaceNumber(row.like)">بله</button>
                                    <button class="btn_like dislike" v-on:click="questionScore(row,'dislike')" v-bind:data-count="replaceNumber(row.dislike)">خیر</button>

                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

                <div class="paginate_div">
                    <!--                 <pagination :data="list" @pagination-change-page="get_question"></pagination>-->
                </div>
            </template>

            <div style="clear:both"></div>
        </div>
</template>

<script>
 import events from '../events';
 export default {
        name: "QuestionList",
        mixins:[events],
        props:['product_id','auth','shop_name'],
        data(){
            return {
                Question:'',
                send_email:false,
                send:true,
                save_question:false,
                list:{data:[]},
                answer_id:0,
                save_answer:false,
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
                loading:false,
                getServerData:false,
                serverError:false,
                answer:'',
                send_answer:true
            }
        },
        mounted() {
            this.get_question();

        },
        methods:{
            get_question:function(page=1){
                this.loading=true;
                const url=this.$siteUrl+"/site/get_question/"+this.product_id+"?page="+page+"&ordering="+this.ordering;
                this.axios.get(url).then(response=>{
                    this.list=response.data;
                    this.loading=false;
                    this.getServerData=true;
                }).catch(error=>{
                    this.loading=false;
                });
            },
            set_answer_id:function(id){
                if(this.auth==='no')
                {
                    this.$root.$emit('show_desktop_login');
                }
                else{
                    this.answer_id=id;
                    this.answer='';
                }
            },
            set_ordering:function(type){
                this.ordering=type;
                this.answer_id=0;
                this.get_question(1);
            },
            checkAuth:function()
            {
                if(this.auth==='no')
                {
                    this.$root.$emit('show_desktop_login');
                }
            },
        }
 }
</script>

<style scoped>
    @import "../style.css";
</style>
