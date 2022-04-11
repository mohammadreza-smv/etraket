<div class="mobile_data_box data_box" id="product_items">
    <div class="header">
        <span>مشخصات فنی</span>
        <a>
            <span>بازگشت</span>
            <span class="fa fa-angle-left"></span>
        </a>
    </div>

    <div class="content">
        @if(sizeof($product_items)>0 && $product_item_count>0)
            <table class="item_table">
                @foreach($product_items as $key=>$value)
                    <tr>
                        <td colspan="2" style="padding: 15px 0px">
                            <span class="item_name">{{ $value->title }}</span>
                        </td>
                    </tr>

                    @foreach($value->getChild as $key2=>$value2)
                        @if(sizeof($value2->getValue)>0)
                            <tr>
                                <td class="product_item_name">
                                    {{ $value2->title }}
                                </td>
                            </tr>
                            <tr>
                                <td class="product_item_value">
                                    {{ $value2->getValue[0]->item_value }}
                                </td>
                            </tr>
                            @foreach($value2->getValue as $key3=>$value3)
                                @if($key3>0)
                                    <tr>
                                        <td class="product_item_value">
                                            {{ $value3->item_value }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif


                    @endforeach
                @endforeach
            </table>
        @else
            <p class="empty_message">
                مشخصات فنی برای این محصول ثبت نشده
            </p>
        @endif
    </div>
</div>
