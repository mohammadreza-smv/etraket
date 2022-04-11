<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($category as $cat)

        @include('include.cat-sitemap-url',['cat'=>$cat])

        @foreach($cat->getChild as $cat2)
            @include('include.cat-sitemap-url',['cat'=>$cat2])

            @foreach($cat2->getChild as $cat3)
                @include('include.cat-sitemap-url',['cat'=>$cat3])

                @foreach($cat3->getChild as $cat4)
                    @include('include.cat-sitemap-url',['cat'=>$cat4])
                @endforeach

            @endforeach
        @endforeach
    @endforeach
</urlset>
