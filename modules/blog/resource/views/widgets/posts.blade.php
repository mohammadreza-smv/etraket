<?php
    $var=$args['id'];
    $var=str_replace('-',"_",$var);
    $jdf=new \App\Lib\Jdf();
?>
@if(isset(${$var}))
   @php $data=${$var} @endphp
   <div class="post-box">
       <div class="box-title">
           <h4>{{ $data['title'] }}</h4>
           <div class="post-box-line"></div>
       </div>

       @if(!$data['show_content'])
           <div class="post-list1">
               @foreach($data['posts'] as $post)
                   <div class="post-view">
                       <a href="{{ route('blog.show.post',['url'=>$post->url]) }}">
                           <v-img
                               max-width="100%"
                               src="{{ url('files/posts/'.$post->pic) }}"
                           ></v-img>
                       </a>
                       <a href="{{ route('blog.show.post',['url'=>$post->url]) }}" class="post-title">
                           {{ $post->title }}
                       </a>
                       <div class="post-detail">
                           <div>
                               {{ $jdf->jdate(' d F Y',$post->created_at->timestamp) }}
                           </div>
                           <div>
                               <span>{{ replace_number($post->view) }}</span>
                               <v-icon size="16">
                                   mdi-eye
                               </v-icon>
                           </div>
                       </div>
                   </div>
               @endforeach
           </div>
       @else
           <div class="post-list2">

               @foreach($data['posts'] as $post)
                   <div class="post-view">
                       <div class="image-box">
                           <a href="{{ route('blog.show.post',['url'=>$post->url]) }}">
                               <v-img
                                   max-width="100%"
                                   src="{{ url('files/posts/'.$post->pic) }}"
                               ></v-img>
                           </a>
                       </div>
                       <div>
                           <a href="{{ route('blog.show.post',['url'=>$post->url]) }}" class="post-title">
                               {{ $post->title }}
                           </a>
                           <div class="post-detail">
                               <div>
                                   {{ $jdf->jdate(' d F Y',$post->created_at->timestamp) }}
                               </div>
                               <div>
                                   <span>{{ replace_number($post->view) }}</span>
                                   <v-icon size="16">
                                       mdi-eye
                                   </v-icon>
                               </div>
                           </div>
                           <div class="content">
                               @if(strlen(strip_tags($post->content))>200)
                                   {!! mb_substr(strip_tags($post->content),0,200).'...' !!}
                               @else
                                   {!! $post->content !!}
                               @endif

                           </div>
                       </div>
                   </div>
               @endforeach

           </div>
       @endif
   </div>
@endif
