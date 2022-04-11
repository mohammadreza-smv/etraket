<div id="share_div">
    <div id="share_box">
        <p>
            با استفاده از روش‌های زیر می‌توانید این صفحه را با دوستان خود به اشتراک بگذارید.
        </p>
        <ul>
            <li>
                <a href="https://telegram.me/share/url?url=<?= shop_product_url($product) ?>&ref=telegram">
                    <span class="fa fa-telegram"></span>
                </a>
            </li>
            <li>
                <a href="https://twitter.com/intent/tweet/?url=<?= shop_product_url($product) ?>">
                    <span class="fa fa-twitter"></span>
                </a>
            </li>
            <li>
                <a href="https://www.facebook.com/sharer/sharer.php?m2w&s=100&p[url]=<?= shop_product_url($product) ?>">
                    <span class="fa fa-facebook"></span>
                </a>
            </li>
            <li>
                <a href="https://wa.me?text=<?= shop_product_url($product) ?>&ref=telegram">
                    <span class="fa fa-whatsapp"></span>
                </a>
            </li>
        </ul>

    </div>
</div>
