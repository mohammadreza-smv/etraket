<div class="sidenav">
    <img src="{{ asset(config('shop-info.shop_icon')) }}">
    <p>فروشگاه {{ config('shop-info.shop_name') }}</p>
    <ul style="padding:0px">
        @foreach($catList as $key=>$value)
            <li>
                <a class="parent_cat">
                    {{ $value->name }}

                    <v-icon>mdi-chevron-down</v-icon>
                </a>
                @if(sizeof($value->getChild)>0)
                    <div class="li_div">
                        <ul>
                            @foreach($value->getChild as $key2=>$value2)
                                @if($value2->notShow==0)
                                    <li>
                                        <div class="child_cat">
                                            <a  @if(sizeof($value2->getChild)==0) class="router-link" href="{{ get_cat_url($value2) }}"
                                                @endif>
                                                <span>{{ $value2->name }}</span>
                                                @if(sizeof($value2->getChild)>0)
                                                    <v-icon>mdi-chevron-down</v-icon>
                                                @endif
                                            </a>
                                        </div>

                                        <ul>
                                            @foreach($value2->getChild as $key3=>$value3)
                                                @if($value3->notShow==0)
                                                    <li>
                                                        <a style="color:#515151" class="router-link" href="{{ get_cat_url($value3) }}">{{ $value3->name }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>

                                @else
                                    @foreach($value2->getChild as $key3=>$value3)
                                        @if($value3->notShow==0)
                                            <li>
                                                <div class="child_cat">
                                                    <a  @if(sizeof($value3->getChild )==0) class="router-link"  href="{{ get_cat_url($value3) }}" @endif>
                                                        <span>{{ $value3->name }}</span>
                                                        @if(sizeof($value3->getChild)>0)
                                                            <v-icon>mdi-chevron-down</v-icon>
                                                        @endif
                                                    </a>
                                                </div>
                                                <ul>
                                                    @foreach($value3->getChild as $key4=>$value4)
                                                        @if($value4->notShow==0)
                                                            <li>
                                                                <a style="color:#515151" class="router-link" href="{{ get_cat_url($value4) }}">{{ $value4->name }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</div>
