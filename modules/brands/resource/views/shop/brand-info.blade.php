<brand-info>
    <div class="brand-detail">
        @if(!empty($brand->brand_icon))
            <img src="{{ url('files/upload/'.$brand->brand_icon) }}" />
        @endif
        <a href="{{ url('brand/'.$brand->brand_ename) }}" class="router-link brand-name">
            {{ $brand->brand_name }}
        </a>
        <a href="{{ url('brand/'.$brand->brand_ename) }}" class="router-link brand-link">
            {{ url('brand/'.$brand->brand_ename) }}
        </a>
    </div>
</brand-info>
