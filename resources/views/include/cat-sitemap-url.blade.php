<url>
    <?php $url=$cat->parent_id==0 ? 'main/'.$cat->url : get_cat_url($cat) ?>
    <loc>{{ url($url) }}</loc>
    <priority>0.9</priority>
    @if(!empty($cat->img))
        <image:image>
            <image:loc>{{ url('files/upload/'.$cat->img) }}</image:loc>
            <image:caption>{{ $cat->name }}</image:caption>
        </image:image>
    @endif
    <changefreq>weekly</changefreq>
</url>
