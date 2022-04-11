<template>
    <div class="comment_box">

        <div class="row" v-if="comment_count>0">
            <h2>
                {{ product_title }}
                <span>|</span>
                <span>{{ replaceNumber(5)}}/{{ replaceNumber(avg)}}</span>
                <span>({{ replaceNumber(comment_count)}} نظر)</span>
            </h2>
        </div>

        <div class="row" v-if="getServerData==='ok'">
            <div class="col-md-6">
                <ul class="rating_ul avg_ul" v-if="comment_count>1">
                    <li v-for="(item,key) in scoreItem" v-bind:key="key">
                        <label>{{ item }}</label>
                        <div class="rating" v-bind:data-rate-digit="getLabel2(key)">
                            <div class="rating-value" v-bind:style="{width:getWidth2(key)+'%'}"></div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="comment-summary_note">
                    <span class="title">شما هم می‌توانید در مورد این کالا نظر بدهید.</span>
                    <p>
                        برای ثبت نظر، لازم است ابتدا وارد حساب کاربری خود شوید. اگر این محصول را قبلا از {{ shop_name  }} خریده باشید، نظر شما به عنوان مالک محصول ثبت خواهد شد.
                    </p>
                    <a  v-on:click="$root.$emit('send_get_request',$siteUrl+'/product/comment/create/'+product_id)">
                        <v-btn>
                            افزودن نظر جدید
                        </v-btn>
                    </a>
                </div>
            </div>
        </div>


        <div class="feq_filter"  v-if="getServerData==='ok'">
            <p>نظرات کاربران</p>
            <ul class="feq_filter_item" data-title="مرتب سازی بر اساس :">
                <li :class="[ordering===1 ? 'is-active' : '']" v-on:click="set_ordering(1)">نظر خریداران</li>
                <li :class="[ordering===2 ? 'is-active' : '']" v-on:click="set_ordering(2)">مفید ترین نظرات</li>
                <li :class="[ordering===3 ? 'is-active' : '']" v-on:click="set_ordering(3)">جدید ترین نظرات</li>
            </ul>
        </div>

        <div v-if="loading" class="comment-loading">
            <v-progress-circular
                indeterminate
                color="red"
            ></v-progress-circular>
        </div>

        <div v-else>
            <div class="comment_div" v-for="(comment,key) in list.data" v-bind:key="key">
                <div class="row">
                    <div class="col-md-5">
                        <ul class="rating_ul">
                            <li v-for="(item,key2) in scoreItem" v-bind:key="key2">
                                <label>{{ item }}</label>
                                <div class="rating" v-bind:data-rate-digit="getLabel(key,key2)">
                                    <div class="rating-value" v-bind:style="{width:getWidth(key,key2)+'%'}"></div>
                                </div>
                            </li>
                        </ul>
                        <div class="message_purchased" v-if="comment.order_id>0">
                            <a>
                                <span class="fa fa-shopping-cart"></span>
                                خریدار محصول
                            </a>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="comment_header_box">
                            <span>{{ comment.title }}</span>
                            <p>
                                <span>توسط</span>
                                <span v-if="comment.get_user_info==null">ناشناس</span>
                                <span v-else>
                                {{ comment.get_user_info.first_name+' '+comment.get_user_info.last_name }}
                            </span>
                                <span>در تاریخ</span>
                                {{ getDate(comment.time) }}
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-md-6" v-if="comment.advantage.length>1" style="padding-right: 0px">
                                <span class="evaluation_label">نقاط قوت</span>
                                <ul class="evaluation_ul advantage" >
                                    <li v-for="advantage in comment.advantage" v-if="advantage!=''" v-bind:key="advantage.id">
                                        <span>{{ advantage }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6" v-if="comment.disadvantage.length>1" style="padding-right: 0px">
                                <span class="evaluation_label">نقاط ضعف</span>
                                <ul class="evaluation_ul disadvantage" >
                                    <li v-for="disadvantage in comment.disadvantage"  v-if="disadvantage!=''"  v-bind:key="disadvantage.id">
                                        <span>{{ disadvantage }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="comment_text">{{ comment.content }}</div>

                        <div class="footer">
                            <div>
                                آیا این نظر برایتان مفید بود ؟
                                <button class="btn_like" v-on:click="commentScore(comment,'like')" v-bind:data-count="replaceNumber(comment.like)">بله</button>
                                <button class="btn_like dislike" v-on:click="commentScore(comment,'dislike')" v-bind:data-count="replaceNumber(comment.dislike)">خیر</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="paginate_div">
                <!--            <pagination :data="list" @pagination-change-page="getList"></pagination>-->
            </div>

            <div v-if="comment_count===0 && getServerData==='ok'">
                <p class="no_record_message">تاکنون برای این محصول نظری ثبت نشده</p>
            </div>
        </div>



    </div>
</template>

<script>
    import myMixin from "../../../../../resources/js/myMixin";
    import methods from "../methods";
    export default {
        name: "CommentList",
        props:['auth','product_id','product_title','shop_name'],
        mixins:[myMixin,methods],
        data(){
            return {
                list:{data:[]},
                comment_count:0,
                avg:0,
                avg_score:[],
                getServerData:'no',
                ordering:1,
                scoreItem:[
                    'کیفیت ساخت :',
                    'نوآوری :',
                    'سهولت استفاده :',
                    'ارزش خرید به نسبت قیمت :',
                    'امکانات و قابلیت ها :',
                    'سهولت طراحی و ظاهر :'
                ],
                scoreLabel:[
                    'خیلی بد',
                    'بد',
                    'معمولی',
                    'خوب',
                    'عالی'
                ],
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
                send:true,
                loading:true
            }
        },
        mounted() {
            this.getList();
        },
        methods:{
            getList:function (page=1) {
                this.loading=true;
                const url=this.$siteUrl+"/site/getComment?page="+page+"&product_id="+this.product_id+"&orderBy="+this.ordering;
                this.axios.get(url).then(response=>{
                    this.loading=false;
                    this.list=response.data.comment;
                    this.avg=response.data.avg;
                    this.avg_score=response.data.avg_score;
                    this.comment_count=response.data.comment_count;
                    this.getServerData='ok';
                }).catch(error =>{
                    this.loading=false;
                });
            }
        }
    }
</script>

<style scoped>
    @import "../style.css";
</style>
