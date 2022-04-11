<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    @foreach($products as $product)
         <url>
             <loc>{{ url('product/dkp-'.$product->id.'/'.$product->product_url) }}</loc>
             <priority>1</priority>
             <image:image>
                 <image:loc>{{ url('files/thumbnails/'.$product->image_url) }}</image:loc>
                 <image:caption>{{ $product->title }}</image:caption>
             </image:image>
             <changefreq>weekly</changefreq>
         </url>
    @endforeach

</urlset>
