<template>
    <div>

        <div v-for="(comment,key) in commentList.data" :class="[comment.status===1 ? 'comment_box Accepted' :'comment_box pending_approval' ]">

            <div class="comment_header_box" :style="{alignItems:'center',padding:removed ? '0px 15px' : '15px'}">
                <div style="display: flex;align-items: center">
                    <check-box v-if="removed"></check-box>
                    <span class="comment_status" @click="changeStatus(comment,key)">
                        <span v-if="comment.status==1">تایید شده</span>
                        <span v-else>در انتظار تایید</span>
                    </span>
                </div>
                <div style="display: flex">
                    <span>ثبت شده </span>
                    <div v-if="removed">
                        <span>توسط</span>
                        <template v-if="comment.user!=null && comment.user.first_name!==null">
                            {{ comment.user.first_name+' '+comment.user.last_name }}
                        </template>
                        <span v-else>ناشناس</span>
                    </div>
                    <span>در تاریخ</span>
                    <span>{{ getDate(comment.time) }}</span>
                </div>
                <div v-if="removed" style="display: flex">

                    <delete-link
                        label="نظر"
                        :row-id="comment.id"
                        :color="comment.status===1 ? 'gray' : 'red'"
                        :url="$siteUrl+'/admin/comments/'+comment.id"
                        :sendTrash="trashed() ? 'no' : 'yes'"
                    >

                    </delete-link>
                    <restore-link  v-if="trashed()"
                                   label="نظر"
                                   :row-id="comment.id"
                                   :url="$siteUrl+'/admin/comments/'+comment.id"
                    ></restore-link>
                </div>
            </div>

            <v-row>
                <v-col md="6">
                    <ul class="rating_ul" v-if="comment.get_score!==null">
                        <li v-for="(item,key) in scoreItem">
                            <label>{{ item }}</label>
                            <div class="rating" :data-rate-digit="type[comment.get_score['score'+(key+1)]]">
                                <div class="rating-value" :style="{
                                    width:(comment.get_score['score'+(key+1)]*25)+'%'
                                }"></div>
                            </div>
                        </li>
                    </ul>

                    <template v-if="comment.order>0">
                        <div class="message_purchased">
                            <a @click="$root.$emit('send_get_request','admin/orders/'+comment.order)">
                                <v-icon>mdi-cart-outline</v-icon>
                                خریدار محصول
                            </a>
                        </div>
                    </template>

                    <span>ثبت شده در محصول : </span>
                    <p v-if="comment.product!=null">
                        {{ comment.product.title }}
                    </p>
                    <p v-else>حذف شده</p>

                </v-col>

                <v-col md="6">

                    {{ comment.title }}

                    <v-row>

                        <v-col md="6">
                            <span v-if="comment.advantage.length>0" class="evaluation_label">نقاط قوت</span>
                            <ul class="evaluation_ul advantage">
                                <li v-for="advantage in comment.advantage"><span>{{ advantage }}</span></li>
                            </ul>
                        </v-col>

                        <v-col md="6">
                            <span v-if="comment.disadvantage.length>0" class="evaluation_label">نقاط ضعف</span>
                            <ul class="evaluation_ul disadvantage">
                                <li v-for="disadvantage in comment.disadvantage"><span>{{ disadvantage }}</span></li>
                            </ul>
                        </v-col>

                    </v-row>

                    <div class="comment_content">{{ comment.content }}</div>

                </v-col>

            </v-row>

        </div>

        <div v-if="commentList.data.length===0">
            <p style="padding-top: 30px;padding-bottom: 20px;text-align: center">رکوردی برای نمایش یافت نشد</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PanelCommentList",
        props:['comments','removed'],
        data(){
            return{
                scoreItem:[
                    'کیفیت ساخت : ',
                    'نوآوری : ',
                    'سهولت استفاده :',
                    'ارزش خرید به نسبت قیمت : ',
                    'امکانات و قابلیت ها : ',
                    'سهولت طراحی و ظاهر : '
                ],
                type:[
                    'خیلی بد',
                    'بد',
                    'معمولی',
                    'خوب',
                    'عالی'
                ],
                commentList:{data:[]}
            }
        },
        methods:{
            trashed:function () {
                return window.location.href.indexOf('trashed')>-1;
            },
            changeStatus:function(comment,key){
                if(this.removed){
                    const url = this.$siteUrl + "/admin/comment/change_status";
                    this.$root.$emit('show_progress');
                    const formData=new FormData();
                    formData.append('comment_id',comment.id);
                    this.axios.post(url,formData).then(response=>{
                        if(response.data=='ok'){
                            if(this.commentList.data[key].status===0){
                                this.commentList.data[key].status=1;
                            }
                            else{
                                this.commentList.data[key].status=0;
                            }
                            this.$forceUpdate();
                        }
                        this.$root.$emit('hide_progress');
                    }).catch(error=>{
                        this.$root.$emit('hide_progress');
                    });
                }
            },
            getDate: function (time) {
                time = time * 1000;
                const date = new Date(time);
                let r = '';
                const jalali = this.gregorian_to_jalali(date.getFullYear(), (date.getMonth() + 1), date.getDate());
                r = this.replaceNumber(jalali[0]) + "/" + this.replaceNumber(jalali[1]) + "/" + this.replaceNumber(jalali[2]);
                return r;
            },
            gregorian_to_jalali: function (gy, gm, gd) {
                var g_d_m, jy, jm, jd, gy2, days;
                g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
                if (gy > 1600) {
                    jy = 979;
                    gy -= 1600;
                } else {
                    jy = 0;
                    gy -= 621;
                }
                gy2 = (gm > 2) ? (gy + 1) : gy;
                days = (365 * gy) + (parseInt((gy2 + 3) / 4)) - (parseInt((gy2 + 99) / 100)) + (parseInt((gy2 + 399) / 400)) - 80 + gd + g_d_m[gm - 1];
                jy += 33 * (parseInt(days / 12053));
                days %= 12053;
                jy += 4 * (parseInt(days / 1461));
                days %= 1461;
                if (days > 365) {
                    jy += parseInt((days - 1) / 365);
                    days = (days - 1) % 365;
                }
                jm = (days < 186) ? 1 + parseInt(days / 31) : 7 + parseInt((days - 186) / 30);
                jd = 1 + ((days < 186) ? (days % 31) : ((days - 186) % 30));
                return [jy, jm, jd];
            },
            replaceNumber: function (n) {
                if (n != undefined) {
                    n = n.toString();
                    const find = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                    const replace = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                    for (let i = 0; i < find.length; i++) {
                        n = n.replace(new RegExp(find[i], 'g'), replace[i]);
                    }
                    return n;
                }
            }
        },
        mounted() {
            this.commentList=this.comments;
        }
    }
</script>

<style scoped>
    .comment_box{
        font-size: 15px;
        margin-top: 20px;
    }
    .comment_box .rating_ul{
        margin-top: 56px;
        padding-right: 0px !important;
    }
    .comment_box .rating_ul li{
        list-style: none;
        display: flex;
        font-size: 14px;
        width: 100%;
        padding-bottom: 10px;
    }
    .comment_box .rating_ul li label{
        width: 170px !important;
    }
    .comment_box .rating{
        position: relative;
        height: 4px;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        background-color: #eaeaea;
        width: calc(100% - 220px);
        margin-top: 9px;
    }
    .comment_box .rating::before{
        content:attr(data-rate-digit);
        position: absolute;
        right: 100%;
        margin-right: 11px;
        color: #6f6f6f;
        font-size: 13px !important;
        bottom: -6px;
    }
    .rating-value{
        background-color: #00bfd6;
        height: 4px;
        border-radius: 3px;
        -webkit-border-radius: 3px;
    }
    .comment_box .comment_content{
        color: #505050;
        font-size: 15px;
        line-height: 24px;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .comment_box .fa-trash{
        color: black;
        font-size: 16px;
    }
    .comment_box .fa-refresh{
        font-size: 16px;
    }
    .comment_box .row{
        padding: 20px 15px;
    }
    .comment_header_box{
        padding:0px  20px;
        display: flex;
        justify-content: space-between;
        font-size: 14px;
    }
    .pending_approval{
        border:1px solid #ece1e2;
    }
    .pending_approval .comment_header_box{
        color: #fb3449;
        background-color: #fff3f4;
    }
    .Accepted{
        border: 1px solid #f1f3f5;
    }
    .Accepted .comment_header_box{
        color: #fb3449;
        background-color: rgba(249, 249, 249, 0.8);
    }
</style>
