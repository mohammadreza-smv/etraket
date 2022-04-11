<product-page-tabs>

    <template v-slot:items>

        <v-tab>
            <v-icon>mdi-book-open-variant</v-icon>
            نقد و بررسی
        </v-tab>

        <v-tab>
            <v-icon>mdi-format-list-bulleted</v-icon>
            مشخصات فنی
        </v-tab>

        <v-tab>
            <v-icon>mdi-comment-text-multiple</v-icon>
            نظرات کاربران
        </v-tab>

        <v-tab>
            <v-icon>mdi-chat-question</v-icon>
            پرسش و پاسخ
        </v-tab>

    </template>

    <template v-slot:content>

        <v-tab-item>
            <v-card flat>
                <product-detail>
                    <div class="review_box">
                        <h2 class="headline">
                            نقد و بررسی اجمالی
                            @if(!empty($product->ename) && $product->ename!='null')
                                <span>{{ $product->ename }}</span>
                            @endif
                        </h2>
                        @if(!empty($product->tozihat))
                            <div class="tozihat">
                                <div class="content">
                                    <div id="product_tozihat">
                                        {!! $product->tozihat !!}
                                    </div>
                                    <a class="more_content">
                                        <span>ادامه مطلب</span>
                                    </a>
                                </div>
                            </div>

                        @endif

                    </div>
                </product-detail>
                
                @includeIf('review::show')
            </v-card>
        </v-tab-item>

        <v-tab-item :eager="true">
            <v-card flat>
                <product-items :product_id="{{ $product->id }}"></product-items>
            </v-card>
        </v-tab-item>

        <v-tab-item>
            <v-card flat>
                <comment-list product_id="{{ $product->id }}" shop_name="{{ config('shop-info.shop_name') }}"></comment-list>
            </v-card>
        </v-tab-item>

        <v-tab-item>
            <v-card flat>
                <question-list
                    product_id="{{ $product->id }}"
                    shop_name="{{ config('shop-info.shop_name') }}"
                    auth="{{ Auth::check() ? 'ok' : 'no' }}"
                ></question-list>
            </v-card>
        </v-tab-item>

    </template>

</product-page-tabs>
