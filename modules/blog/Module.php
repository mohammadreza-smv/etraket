<?php

namespace Modules\blog;

use App\BaseModule;
use Modules\blog\Repository\BlogPostRepositoryInterface;

class Module extends BaseModule
{
    public function install(){

        $from_path=base_path('modules/blog/config/blog.php');
        $to_path=base_path('config/blog.php');
        File::copy($from_path, $to_path);
    }

    public function registerComponent($theme,$type){
        $routeName=getRouteName();
        if(str_contains($routeName,'blog') && !str_contains($routeName,'admin') ){
            return vue_component_detail('blog');
        }
    }

    public function widgets(){
        $settings=[
            'list'=>[
                'title'=>['type'=>'string','value'=>'','label'=>'عنوان'],
                'show_content'=>['type'=>'checkbox','value'=>'','label'=>'نمایش توضیحات'],
                'count'=>['type'=>'string','value'=>'','label'=>'تعداد نمایش پست'],
                'catId'=>['type'=>'string','value'=>'','label'=>'شناسه دسته'],
                'sort'=>['type'=>'array','value'=>'','label'=>'مرتب سازی بر اساس']
            ],
            'data'=>[
                'sort'=>[
                    0=>'جدید ترین',
                    1=>'پربازدید ترین',
                ]
            ]
        ];
        return [
            [
                'name'=>'posts',
                'title'=>'نمایش مطالب وبلاگ',
                'view'=>'blog::widgets.posts',
                'setting'=>$settings,
            ]
        ];
    }

    public function widget_location(){
        return [
            'blog_index'=>[
                'title'=>'صفحه اول وبلاگ',
                'description'=>'لوکیشنی جهت اضافه کردن ابزارک برای نمایش در صفحه اول وبلاگ',
                'use_template'=>'no'
            ],
        ];
    }

    public function posts_widget($args,$data){
        $key=str_replace('-','_',$data['data_id']);
        $title=array_key_exists('title',$data) ? $data['title'] :'';
        $show_content=array_key_exists('show_content',$data) ? $data['show_content'] :'';
        $repository=app(BlogPostRepositoryInterface::class);
        $posts=$repository->getWidgetPosts($data);
        $args[$key]=[
            'posts'=>$posts,
            'title'=>$title,
            'show_content'=>$show_content
        ];
        return $args;
    }
}
