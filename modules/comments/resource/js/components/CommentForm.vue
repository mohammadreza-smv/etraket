<template>
    <v-card style="margin:0px 15px" :loading="loading" :disabled="loading">
        <v-card-text>

            <v-alert type="error" v-if="serverError">
                خطا در ثبت نظر،مجددا تلاش نمایید
            </v-alert>

            <v-alert type="success" v-if="serverRes">
                {{ serverRes }}
            </v-alert>

            <div class="product_info" id="score_box" style="padding-bottom:30px">
                <v-row>
                    <v-col cols="4">
                        <img :src="$siteUrl+'/files/thumbnails/'+product.image_url" >
                    </v-col>
                    <v-col cols="8">
                        <div class="score_box_header">
                            <p class="title">{{ product.title }}</p>
                            <p v-if="product.ename!=='' || product.ename!=='null'">{{ product.ename }}</p>
                        </div>
                        <v-row>

                            <v-col md="6">
                                <div class="rang_box" v-for="(item,key) in score_item1">
                                    <label class="label">{{ item }}</label>
                                    <div class="rang_slider_div" data-rate-title="معمولی">
                                        <span class="js-slider-step slider_step_two active_rang_step" data-rate-title="خیلی بد"></span>
                                        <span class="js-slider-step slider_step_three active_rang_step" data-rate-title="بد"></span>
                                        <span class="js-slider-step slider_step_four" data-rate-title="معمولی"></span>
                                        <span class="js-slider-step slider_step_five" data-rate-title="خوب"></span>
                                        <span class="js-slider-step slider_step_six" data-rate-title="عالی"></span>
                                        <div class="active_rang_slider"></div>
                                    </div>
                                    <input type="range" min="0" max="4" value="2" v-model="score[key]" class="item_slider">
                                </div>
                            </v-col>

                            <v-col md="6">
                                <div class="rang_box" v-for="(item,key) in score_item2">
                                    <label class="label">{{ item }}</label>
                                    <div class="rang_slider_div" data-rate-title="معمولی">
                                        <span class="js-slider-step slider_step_two active_rang_step" data-rate-title="خیلی بد"></span>
                                        <span class="js-slider-step slider_step_three active_rang_step" data-rate-title="بد"></span>
                                        <span class="js-slider-step slider_step_four" data-rate-title="معمولی"></span>
                                        <span class="js-slider-step slider_step_five" data-rate-title="خوب"></span>
                                        <span class="js-slider-step slider_step_six" data-rate-title="عالی"></span>
                                        <div class="active_rang_slider"></div>
                                    </div>
                                    <input type="range" min="0" max="4" value="2" v-model="score[(key+3)]" class="item_slider">
                                </div>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </div>

            <v-row>
               <v-col cols="5">

                  <v-form  ref="form"
                           v-model="valid"
                           :disabled="formDisabled"
                  >

                      <v-text-field
                          label="عنوان نظر شما"
                          outlined
                          :rules="titleRules"
                          v-model="title"
                      >

                      </v-text-field>


                      <v-row>

                          <v-col cols="6" style="padding-right:0px">

                              <v-text-field
                                  outlined
                                  placeholder="نقاط قوت"
                                  clearable
                                  clear-icon="mdi-plus"
                                  v-model="advantage"
                                  hide-details
                                  @click:clear="addAdvantage"
                              >
                              </v-text-field>

                              <div id="advantage_input_box" class="item_list">
                                  <div v-for="(item,key) in advantageList">
                                      <span>
                                          {{ item }}
                                      </span>
                                      <span @click="removeAdvantage(key)">
                                          <v-icon>mdi-close</v-icon>
                                      </span>
                                  </div>
                              </div>

                          </v-col>

                          <v-col cols="6" style="padding-left:0px">

                              <v-text-field
                                  outlined
                                  placeholder="نقاط ضعف"
                                  clearable
                                  clear-icon="mdi-plus"
                                  v-model="disadvantage"
                                  hide-details
                                  @click:clear="addDisadvantage"
                              ></v-text-field>

                              <div id="disadvantage_input_box" class="item_list">
                                  <div v-for="(item,key) in disadvantageList">
                                      <span>
                                          {{ item }}
                                      </span>
                                      <span @click="removeDisadvantage(key)">
                                          <v-icon>mdi-close</v-icon>
                                      </span>
                                  </div>
                              </div>

                          </v-col>

                          <v-col cols="6"></v-col>

                      </v-row>

                      <v-textarea
                          outlined
                          label="متن نظر شما"
                          v-model="content"
                          :rules="contentRules"
                      ></v-textarea>


                      <v-btn class="add_comment_btn" @click="addComment">
                          ثبت نظر
                      </v-btn>

                  </v-form>

               </v-col>
               <v-col cols="7">
                   <div class="add_comment_tozihat">
                       <h4>
                           دیگران را با نوشتن نظرات خود، برای انتخاب این محصول راهنمایی کنید.

                       </h4>
                       <p>لطفا پیش از ارسال نظر، خلاصه قوانین زیر را مطالعه کنید:</p>
                       <p>فارسی بنویسید و از کیبورد فارسی استفاده کنید. بهتر است از فضای خالی (Space) بیش‌از‌حدِ معمول، شکلک یا ایموجی استفاده نکنید و از کشیدن حروف یا کلمات با صفحه‌کلید بپرهیزید.</p>
                       <p>نظرات خود را براساس تجربه و استفاده‌ی عملی و با دقت به نکات فنی ارسال کنید؛ بدون تعصب به محصول خاص، مزایا و معایب را بازگو کنید و بهتر است از ارسال نظرات چندکلمه‌‌ای خودداری کنید.</p>
                       <p>بهتر است در نظرات خود از تمرکز روی عناصر متغیر مثل قیمت، پرهیز کنید.</p>
                       <p>به کاربران و سایر اشخاص احترام بگذارید. پیام‌هایی که شامل محتوای توهین‌آمیز و کلمات نامناسب باشند، حذف می‌شوند.</p>
                       <p>از ارسال لینک‌های سایت‌های دیگر و ارایه‌ی اطلاعات شخصی خودتان مثل شماره تماس، ایمیل و آی‌دی شبکه‌های اجتماعی پرهیز کنید.</p>
                       <p>با توجه به ساختار بخش نظرات، از پرسیدن سوال یا درخواست راهنمایی در این بخش خودداری کرده و سوالات خود را در بخش «پرسش و پاسخ» مطرح کنید.</p>
                   </div>
               </v-col>
            </v-row>

        </v-card-text>
    </v-card>
</template>

<script>
    import methods from "../methods";
    export default {
        name: "CommentForm",
        props:['product'],
        mixins:[methods],
        data(){
            return {
                score_item1:['کیفیت ساخت','نوآوری','سهولت استفاده'],
                score_item2:['ارزش خرید به نسبت قیمت','امکانات و قابلیت ها','سهولت طراحی و ظاهر'],
                score:[2,2,2,2,2,2],
                valid:false,
                titleRules: [
                    v => !!v || 'عنوان نظر را وارد کنید',
                ],
                contentRules: [
                    v => !!v || 'متن نظر را وارد کنید',
                ],
                title:'',
                content:'',
                advantage:'',
                disadvantage:'',
                advantageList:[],
                disadvantageList:[],
                loading:false,
                serverError:false,
                serverRes:false,
                formDisabled:false
            }
        },
        mounted() {
            this.sliderEvent();
        },
        methods:{

        }
    }
</script>

