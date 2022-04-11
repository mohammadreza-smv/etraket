<shop-nav>
    <div class="shopCategory">
        <ul class="shop_menu_ul">
            <li class="cat_hover">
                <div></div>
            </li>
            <li class="shop_nav_li" id="show_cat_list">
                <span class="fa fa-bars"></span>
                <span>دسته بندی ها</span>

                <div class="cat-list-div">
                    <div class="cat_list_box">
                        <div class="parent_list">
                            <ul class="list-inline cat_list">
                                @foreach($catList as $key=>$value)
                                    <li  data-index="{{ $key }}" @if($key==0) class="active" @endif>
                                        <a class="router-link" href="{{ url('main/'.$value->url) }}">{{ $value->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="child_list">
                            @foreach($catList as $key=>$value)
                                <div  @if($key==0) style="display: block" @endif class="child_list_div category-list-{{ $key }} ">
                                    <div class="show-total-sub-cat">
                                        <a class="router-link" href="{{ url('main/'.$value->url) }}">
                                            <span>مشاهده تمام دسته های </span>
                                            <span>{{ $value->name }}</span>
                                        </a>
                                    </div>
                                    @if(sizeof($value->getChild)>0)
                                        <?php
                                        $c=0;
                                        ?>
                                        @if(sizeof($value->getChild)>0) @if($c==0) <ul class="list-inline subList"> @endif @endif
                                            @foreach($value->getChild as $key2=>$value2)
                                                @if($value2->notShow==0)
                                                    @if(get_show_category_count($value2->getChild)>=(14-$c)) <?php $c=0 ?>  </ul> <ul class="list-inline subList"> @endif
                                            <li>
                                                <a class="child_cat router-link" href="{{ get_cat_url($value2) }}">
                                                    <span class="fa fa-angle-left"></span>
                                                    <span>{{ $value2->name }}</span>
                                                </a>
                                                <ul>
                                                    @foreach($value2->getChild as $key3=>$value3)
                                                        @if($value3->notShow==0)
                                                            <li>
                                                                <a class="router-link" href="{{ get_cat_url($value3) }}">{{ $value3->name }}</a>
                                                            </li>
                                                            <?php $c++; ?>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <?php $c++ ?>
                                            @if($c==13)  </ul> <?php $c=0; ?> <ul class="list-inline subList"> @endif
                                            @else
                                                @foreach($value2->getChild as $key3=>$value3)
                                                    @if(get_show_category_count($value3->getChild)>=(14-$c)) <?php $c=0 ?>  </ul> <ul class="list-inline subList"> @endif
                                            @if($value3->notShow==0)
                                                <li>
                                                    <a class="child_cat router-link" href="{{ get_cat_url($value3) }}">
                                                        <span class="fa fa-angle-left"></span>
                                                        <span>{{ $value3->name }}</span>
                                                    </a>
                                                    <ul>
                                                        @foreach($value3->getChild as $key4=>$value4)
                                                            @if($value4->notShow==0)
                                                                <li>
                                                                    <a class="router-link" href="{{ get_cat_url($value4) }}">{{ $value4->name }}</a>
                                                                </li>
                                                                <?php $c++; ?>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                <?php $c++; ?>

                                            @endif

                                            @if($c==13)  </ul> <?php $c=0; ?> <ul class="list-inline subList"> @endif
                                            @endforeach

                                            @endif

                                            @endforeach

                                            @if($c!=0) </ul> @endif

                                        @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </li>
            <li  class="shop_nav_li">
                <a href="">
                    <span class="fa fa-gift"></span>
                    <span>تخفیف‌ها و پیشنهادها</span>
                </a>
            </li>
            <li  class="shop_nav_li">
                <a href="{{ url('faq') }}" class="router-link">
                    <span>سوالی دارید؟</span>
                </a>
            </li>
            <li class="shop_nav_li">
                <a href="{{ url('sellers/login') }}">
                    <span>فروشنده شوید</span>
                </a>
            </li>
        </ul>

        <select-cites selected="{{ Cookie::get('selected_shop_cites') }}"></select-cites>

    </div>
</shop-nav>
