@extends('front-theme::layouts.app')

@section('content')

  <v-row class="category-page">

      <div class="catlist">

         <v-card>

             <v-card-title class="child-cat-list-title">
                 دسته بندی کالاها
             </v-card-title>

             <v-card-text>

                 @foreach($category->getChild as $key=>$value)

                     <div class="child-cat-list">
                         <a href="{{ get_cat_url($value) }}" class="cat-name router-link">
                             {{ $value['name'] }}
                         </a>
                         @if(sizeof($value['getChild'])>0)
                             @if(sizeof($value['getChild'])>5) <child-cat-ul id="child-cat-{{ $value->id }}"> @endif
                                 <ul @if(sizeof($value['getChild'])>5) id="child-cat-{{ $value->id }}" @endif>
                                     @foreach($value['getChild'] as $key2=>$value2)
                                         <li>
                                             <a href="{{ get_cat_url($value) }}" class="router-link">
                                                 {{ $value2['name'] }}
                                             </a>
                                         </li>
                                     @endforeach
                                 </ul>
                             @if(sizeof($value['getChild'])>5) </child-cat-ul> @endif
                         @endif
                     </div>

                 @endforeach

             </v-card-text>

         </v-card>

      </div>

      <div class="content">

          @includeIf('themes::widgets.view',['location'=>'desktop_main_cat:widgetParam'])

      </div>

  </v-row>

@endsection
