<mobile-gallery>
    @foreach($product->Gallery as $key=>$value)

        <v-carousel-item key="{{ $key }}">
            <img src="{{ url('files/gallery/'.$value->image_url) }}" class="mobile-gallery">
        </v-carousel-item>
    @endforeach
</mobile-gallery>
