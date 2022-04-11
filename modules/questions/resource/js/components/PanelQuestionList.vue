<template>

    <div>

        <div v-for="(question,key) in questionList.data" class="question_div" :key="key">
            <div :class="[question.status==0 ? 'question_div_header question-pending-approval' : 'question_div_header']">

                <div style="display: flex;align-items: center">
                    <check-box v-if="removed"></check-box>

                    <span class="questions_status" @click="changeStatus(question,key)">
                        <span v-if="question.status==1">تایید شده</span>
                        <span v-else>در انتظار تایید</span>
                    </span>
                </div>

                <div style="display: flex">
                    <div v-if="question.question_id===0">
                        <v-icon>mdi-help-circle-outline</v-icon>
                        پرسش
                    </div>
                    <div v-else>
                        <v-icon>mdi-reply</v-icon>
                        پرسش
                    </div>

                    <template v-if="question.user!=null && question.user.first_name!==null">
                        {{ question.user.first_name+' '+question.user.last_name }}
                    </template>
                    <span v-else>ناشناس</span>
                    <span>در تاریخ</span>
                    <span>{{ getDate(question.time) }}</span>
                </div>

                <div v-if="removed" style="display: flex">

                    <delete-link
                        label="پرسش"
                        :row-id="question.id"
                        :color="question.status===1 ? 'gray' : 'red'"
                        :url="$siteUrl+'/admin/questions/'+question.id"
                        :sendTrash="trashed() ? 'no' : 'yes'"
                    >

                    </delete-link>
                    <restore-link  v-if="trashed()"
                                   label="پرسش"
                                   :row-id="question.id"
                                   :url="$siteUrl+'/admin/questions/'+question.id"
                    ></restore-link>
                </div>
            </div>

            <div class="question_content">
                <span v-html="question.question"></span>

                <div style="min-height:70px">
                    <div class="main" v-if="question.question_id!=0">
                        <p>
                            <v-icon>mdi-help-circle-outline</v-icon>
                            <span>پرسش اصلی</span>
                        </p>
                        <span v-html="question.get_parent.question"></span>
                    </div>
                </div>

                <div v-if="question.question_id===0 && answerBox[question.id]!==undefined">
                    <v-textarea placeholder="پاسخ" v-model="answer[question.id]"></v-textarea>
                    <v-btn @click="sendAnswer(question.id)">ارسال پاسخ</v-btn>
                </div>

                <div class="question_footer">
                    <a v-if="question.product">
                        ثبت شده در محصول : {{ question.product.title }}
                    </a>
                    <span v-if="question.question_id===0"
                          @click="showAnswerBox(question.id)"
                          class="add_answer">ارسال پاسخ به این پرسش</span>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    import events from "../events";
    export default {
        name: "PanelQuestionList",
        props:['questions','removed'],
        mixins:[events],
        data(){
            return {
                questionList:{data:[]},
                monthName :[
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
                answer:{},
                answerBox:{}
            }
        },
        mounted() {
            this.questionList=this.questions;
        },
        methods:{
            trashed:function () {
                return window.location.href.indexOf('trashed')>-1;
            },
            showAnswerBox:function(id)
            {
                this.answerBox[id]='show';
                this.$forceUpdate();
            },
            sendAnswer:function (id) {
                if(this.answer[id]!==undefined && this.answer[id].toString().trim()!=='')
                {
                    const url=this.$siteUrl+'/admin/question/addAnswer/'+id;
                    const formData=new FormData();
                    formData.append('answer',this.answer[id]);
                    this.$root.$emit('send_post_request',url,formData);
                }

            }
        }
    }
</script>

<style scoped>
    @import "../admin.css";
</style>
