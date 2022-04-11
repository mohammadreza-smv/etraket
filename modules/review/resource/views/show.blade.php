<product-review>
    @foreach($review as $key=>$value)
        @if(empty($value->title))
            <div class="review_tozihat">
                <h4>نقد و بررسی تخصصی</h4>
                {!! $value->tozihat !!}
            </div>
        @endif
    @endforeach
    @foreach($review as $key=>$value)
        @if(!empty($value->title))
            <div class="item_row" id="review_box_{{ $value->id }}">
                <button class="expert_button" onclick='vm.$root.$emit("change_review_box_status","{{ $value->id }}")'>
                    <v-icon class="plus">mdi-plus</v-icon>
                    <v-icon class="minus">mdi-minus</v-icon>
                </button>
                <h3>{{ $value->title }}</h3>
                <div class="content">
                    <?php
                        $find='style="width:100%"';
                        $replace='class="review_image"';
                        $tozihat=str_replace($find,$replace,$value->tozihat);
                    ?>
                    {!! $tozihat !!}
                </div>
            </div>
        @endif
    @endforeach
</product-review>
