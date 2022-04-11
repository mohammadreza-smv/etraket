<a href="{{ url('Cart') }}" style="position: relative">
    <?php
    $count=\Modules\cart\Models\Cart::get_product_count()
    ?>
    @if($count>0)
        <span class="cart_product_count">{{ replace_number($count) }}</span>
    @endif
    <span class="fa fa-shopping-basket"></span>
</a>
