<?php
   $cartCount=\Modules\cart\Models\Cart::get_product_count();
?>
<mobile-app-bar shop_name="{{ config('shop-info.shop_name') }}">

    <template v-slot:cat_list>
        @include('front-theme::views.mobile.catList')
    </template>

    <template v-slot:items>

        <a href="{{ url('/Cart') }}" class="router-link">
            <v-badge
                content="{{ $cartCount>0 ? replace_number($cartCount) : '' }}"
                value="{{ $cartCount>0 ? replace_number($cartCount) : '' }}"
                overlap dark
                color="red"
            >
                <v-icon>
                    mdi-cart-outline
                </v-icon>
            </v-badge>
        </a>

        <a href="{{ url('/user/profile/') }}" class="router-link">
            <v-icon>
                mdi-account
            </v-icon>
        </a>

    </template>

</mobile-app-bar>

<header-search class="mobile-theme"></header-search>

<select-cites selected="{{ Cookie::get('selected_shop_cites') }}"></select-cites>
