<seller-page-info>
    <template v-slot:seller-page-info>

        <a href="{{ url('seller/'.$seller->id) }}" class="seller-brand">
            {{ $seller->brand_name }}
        </a>

        <?php
            $jdf=new \App\Lib\Jdf();
            $lastDate=$seller->updated_at->getTimestamp();
        ?>

        <follow-btn follow="{{ $follow }}"
                    seller_id="{{ $seller->id }}"
                    device="{{ view_type }}"
                    followers_count="{{ $followers_count }}"
                    last-date="{{ sellerLastTimeOnline($lastDate) }}"
        >
        </follow-btn>
    </template>
</seller-page-info>
