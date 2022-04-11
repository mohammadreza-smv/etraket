<template>
    <div>

        <div class="product_item_box">

            <div class="comment-header-box">
                 <span>مفید ترین نظرات</span>
                 <a v-on:click="$root.$emit('send_get_request',$siteUrl+'/product/comment/create/'+product_id)">
                     <v-btn text type="success" class="add-comment-link">
                         <v-icon>mdi-plus</v-icon>
                         <span>افزودن نظر جدید</span>
                     </v-btn>
                 </a>
             </div>

            <div class="comment_div" style="padding:15px" v-for="comment in useful_comment">

                <span class="user_name" v-if="comment.get_user_info!=null">
                    {{ comment.get_user_info.first_name+' '+comment.get_user_info.last_name }}
                </span>
                <span v-else>
                    ناشناس
                </span>

                <span class="date">{{ getDate(comment.time,'yes') }}</span>
                <div class="comment_content">{{ comment.content }}</div>

                <span class="evaluation_label" v-if="comment.advantage.length>1">نقاط قوت</span>
                <ul class="evaluation_ul advantage">

                    <li v-for="item in comment.advantage" v-if="item!==''">
                        <span>{{ item }}</span>
                    </li>

                </ul>

                <span class="evaluation_label" v-if="comment.disadvantage.length>1">نقاط ضعف</span>

                <ul class="evaluation_ul disadvantage">

                    <li v-for="item in comment.disadvantage" v-if="item!==''">
                        <span>{{ item }}</span>
                    </li>

                </ul>

            </div>

            <p class="center_message" v-if="useful_comment.length===0 && sendRequest">

                تاکنون نظری برای این محصول ثبت نشده

            </p>


            <div class="show_more_div" v-if="comment_count>0">
                <a  style="color:black;font-size:13px" @click="showList()">
                    <span>مشاهده همه {{ replaceNumber(comment_count) }} نظر  کاربران</span>
                    <span class="fa fa-angle-left"></span>
                </a>
            </div>


        </div>

        <v-navigation-drawer
            v-model="drawer"
            fixed
            temporary
            width="100%"
            right
            id="comment-list-box"

        >

            <v-app-bar
                fixed
                elevation="0"
            >
                <div style="padding-left:10px">
                    <v-icon @click="drawer=!drawer">mdi-arrow-right</v-icon>
                </div>
                <v-toolbar-title>نظرات کاربران</v-toolbar-title>

            </v-app-bar>


            <div class="content" style="background:#f5f5f5">

                <div style="padding-top:40px"></div>

                <div class="mobile-theme-feq_filter">
                    <div class="comment-header-box">
                        <span>نظر خود را ثبت کنید</span>
                        <a v-on:click="$root.$emit('send_get_request',$siteUrl+'/product/comment/create/'+product_id)">
                            <v-btn text type="success" class="add-comment-link">
                                <span>افزودن نظر جدید</span>
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>
                        </a>
                    </div>

                    <span class="mobile-theme-feq_filter_title">مرتب سازی بر اساس :</span>

                        <v-radio-group v-model="ordering">
                            <ul class="mobile-feq_filter_item">
                            <li>
                                <v-radio
                                    label="نظر خریداران"
                                    :value="1"
                                    @click="set_ordering(1)"
                                    color="red"
                                ></v-radio>
                            </li>

                            <li>
                                <v-radio
                                    label="مفید ترین نظرات"
                                    :value="2"
                                    @click="set_ordering(2)"
                                    color="red"
                                ></v-radio>
                            </li>

                            <li>
                                <v-radio
                                    label="جدید ترین نظرات"
                                    :value="3"
                                    @click="set_ordering(3)"
                                    color="red"
                                ></v-radio>
                            </li>
                            </ul>
                        </v-radio-group>
                </div>

                <div class="comment_div2" v-for="(comment,key) in list.data" v-bind:key="key">
                    <div  style="width:100%">
                        <div class="comment_header">
                            <div>
                                <span class="comment_title">{{ comment.title }}</span>
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
                            <div v-if="comment.order_id>0" class="title-buyer">خریدار</div>
                        </div>
                        <div  style="width:100%">
                            <div v-if="comment.advantage.length>1" style="width:100%">
                                <span class="evaluation_label">نقاط قوت</span>
                                <ul class="evaluation_ul advantage" >
                                    <li v-for="advantage in comment.advantage" v-if="advantage!=''"  v-bind:key="advantage.id">
                                        <span>{{ advantage }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div  v-if="comment.disadvantage.length>1" style="width:100%">
                                <span class="evaluation_label">نقاط ضعف</span>
                                <ul class="evaluation_ul disadvantage" >
                                    <li v-for="disadvantage in comment.disadvantage" v-if="disadvantage!=''" v-bind:key="disadvantage.id" >
                                        <span>{{ disadvantage }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="comment_text">{{ comment.content }}</div>

                        <div class="footer">
                            <div>
                                آیا این نظر برایتان مفید بود ؟
                            </div>
                            <div style="display: flex">
                                <button class="btn_like" v-on:click="commentScore(comment,'like','redirect')" v-bind:data-count="replaceNumber(comment.like)">بله</button>
                                <button class="btn_dislike" v-on:click="commentScore(comment,'dislike','redirect')" v-bind:data-count="replaceNumber(comment.dislike)">خیر</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="comment_count===0 && getServerData==='ok'">
                    <p class="no_record_message">تاکنون برای این محصول نظری ثبت نشده</p>
                </div>


            </div>

            <v-sheet class="comment-loading" elevation="0" v-if="show_loading_box">

                <v-progress-circular
                    indeterminate
                    color="red"
                ></v-progress-circular>
            </v-sheet>

        </v-navigation-drawer>
    </div>

</template>

<script>
    import methods from "../methods";
    export default {
        name: "MobileThemeCommentList",
        data(){
            return {
                useful_comment:[],
                comment_count:0,
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
                sendRequest:false,
                drawer:false,
                scoreLabel:[
                    'خیلی بد',
                    'بد',
                    'معمولی',
                    'خوب',
                    'عالی'
                ],
                scoreItem:[
                    'کیفیت ساخت :',
                    'نوآوری :',
                    'سهولت استفاده :',
                    'ارزش خرید به نسبت قیمت :',
                    'امکانات و قابلیت ها :',
                    'سهولت طراحی و ظاهر :'
                ],
                list:{data:[]},
                ordering:1,
                show_loading_box:false,
                send_request:true,
                avg:0,
                avg_score:[],
                getServerData:'ok',
                page:1,
            }
        },
        mixins:[methods],
        props:['product_id','product_title'],
        mounted() {
            this.getLastComment();
        },
        methods:{
            getLastComment:function () {
                const url=this.$siteUrl+'/comments/last/'+this.product_id;
                this.axios.get(url).then(response=>{
                    this.sendRequest=true;
                    if(response.data['comment_count']!==undefined)
                    {
                        this.comment_count=response.data['comment_count'];
                    }
                    if(response.data['useful_comment']!==undefined)
                    {
                        this.useful_comment=response.data['useful_comment'];
                    }
                }).catch(error=>{
                    this.sendRequest=true;
                });
            },
            showList:function () {
                this.drawer=true;
                this.scroll();
                if(this.list.data.length===0)
                {
                    this.getList();
                }
            },
            getList:function (page) {
                if(this.send_request)
                {
                    this.send_request=false;
                    this.show_loading_box=true;
                    const app=this;
                    if(page===1){
                        this.list.data=[];
                    }
                    const url=this.$siteUrl+"/site/getComment?page="+page+"&product_id="+this.product_id+"&orderBy="+this.ordering;
                    this.axios.get(url).then(response=>{
                        this.show_loading_box=false;
                        response.data['comment'].data.forEach(function (item) {
                            app.list.data.push(item);
                        });
                        this.avg=response.data.avg;
                        this.avg_score=response.data.avg_score;
                        this.comment_count=response.data.comment_count;
                        this.send_request=true;
                        if(response.data['comment'].data.length===0)
                        {
                            this.getServerData='no';
                        }
                    }).catch(reason =>{
                        this.show_loading_box=false;
                        this.send_request=true;
                    });
                }
            },
            scroll:function () {
               const self=this;
               this.$nextTick(function () {
                   setTimeout(function () {
                       const w= document.querySelector('#comment-list-box .v-navigation-drawer__content');
                       w.addEventListener('scroll',()=>{

                           if ((w.scrollTop + w.clientHeight) >= w.scrollHeight && (w.scrollTop + w.clientHeight)>500 && self.getServerData==='ok' && self.send_request===true) {
                               self.page=self.page+1;
                               self.getList( self.page);
                           }
                       });

                   },500);
               });
            }
        }
    }
</script>

