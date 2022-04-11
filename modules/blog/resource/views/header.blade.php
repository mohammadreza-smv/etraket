<header>
    <div class="blog-header">

        <div class="logo-box">
            <div style="display: flex;align-items: center">
                <div>
                    <img src="{{ asset(config('shop-info.shop_icon')) }}" class="logo">
                </div>
                <div class="blog-title">
                    <a href="{{ route('blog.index') }}" class="router-link" >
                        <span>وبلاگ</span>
                        <span>{{ config('shop-info.shop_name') }}</span>
                    </a>
                </div>
            </div>

            <div>
                <div class="category-navigation-drawer">

                    <v-app-bar-nav-icon @click="$root.$emit('show_navigation_drawer')"></v-app-bar-nav-icon>

                    <category-navigation-drawer>
                        @if(isset($categories))
                            <ul class="nav-blog-categories">
                                @foreach($categories as $cat)
                                    <li class="nav-parent-li">
                                        <a  @if(sizeof($cat->child)==0)
                                            href="{{ route('blog.cat.posts', ['cat1' => $cat->url]) }}" class="router-link" @else
                                            class="parent-link" @endif  >
                                            {{ $cat->name }}
                                            @if(sizeof($cat->child)>0)
                                                <v-icon>mdi-chevron-down</v-icon>
                                            @endif
                                        </a>
                                        @if(sizeof($cat->child)>0)
                                            <ul class="nav-child-cat">
                                                @foreach($cat->child as $child)
                                                    <li>
                                                        <a  href="{{ route('blog.cat.posts', ['cat1' => $cat->url,'cat2' => $child->url]) }}" class="router-link child-link">
                                                            {{ $child->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </category-navigation-drawer>

                </div>
            </div>
        </div>

        <div>
            <menu-list>
                @if(isset($categories))
                    <ul class="blog-categories">
                        @foreach($categories as $cat)
                            <li class="parent-li">
                                <a  href="{{ route('blog.cat.posts', ['cat1' => $cat->url]) }}" class="router-link " >
                                    {{ $cat->name }}
                                    @if(sizeof($cat->child)>0)
                                        <v-icon>mdi-chevron-down</v-icon>
                                    @endif
                                </a>
                                @if(sizeof($cat->child)>0)
                                    <ul class="child-menu">
                                        @foreach($cat->child as $child)
                                            <li>
                                                <a  href="{{ route('blog.cat.posts', ['cat1' => $cat->url,'cat2' => $child->url]) }}" class="router-link">
                                                    {{ $child->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </menu-list>
        </div>

    </div>
</header>
