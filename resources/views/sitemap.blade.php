<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<sitemapindex>

    <sitemap>
        <loc>{{ url('sitemap-category.xml') }}</loc>
        <lastmod><?= date('Y-m-d') ?></lastmod>
    </sitemap>

    <?php
      $n=$product_count/100;
      $n=ceil($n)+1;
    ?>
    @for($i=1;$i<$n;$i++)
        <sitemap>
            <loc>{{ url('products/'.$i.'/sitemap-products.xml') }}</loc>
            <lastmod><?= date('Y-m-d') ?></lastmod>
        </sitemap>
    @endfor

</sitemapindex>
