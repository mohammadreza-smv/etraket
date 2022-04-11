<?php


namespace Modules\comments;

use App\BaseModule;
use Modules\comments\Repository\CommentRepositoryInterface;
use Modules\products\Models\Product;
use Modules\users\Models\AdditionalInfo;
use Auth;
use View;
class Module extends BaseModule
{
    public function show_all_comment_relations($relation){
        if(class_exists('Modules\products\Models\Product')){
            $relation[]='product';
        }
        if(class_exists('Modules\users\Models\AdditionalInfo')){
            $relation[]='user';
        }
        return $relation;
    }

    public function show_user_comments_relations($relation){
        if(class_exists('Modules\products\Models\Product')){
            $relation[]='product';
        }
        return $relation;
    }

    public function comments_product_relation(){
        return function($self){
            return $self->hasone(Product::class,'id','product_id')
                ->select(['id','product_url','title']);
        };
    }

    public function comments_user_relation(){
        return function($self){
            return $self->hasone(AdditionalInfo::class,'user_id','user_id')
                ->select(['id','user_id','email','first_name','last_name']);
        };
    }

    public function registerComponent(){
        $routeName=getRouteName();
        if($routeName==='show_product' || $routeName==='comment_form'
            || $routeName==='comments_index' || $routeName==='user_comments'){
            return vue_component_detail('comments');
        }
    }

    public function get_product_comments_relations($relation){
        if(class_exists('Modules\users\Models\AdditionalInfo')){
            $relation[]='user';
        }
        return $relation;
    }

    public function load_backend_data(){
        if(Auth::user()->role=='admin' || has_access_author_admin('comments')){
            $repository=app(CommentRepositoryInterface::class);
            $comments_count=$repository->count(['status'=>0]);
            View::share('comments_count',$comments_count);
        }
    }

    public function set_user_access_list($access){
        $access['comments']=[
            'label'=>'نظرات کاربران',
            'access'=>[
                'comment_manager'=>['label'=>'مدیریت نظرات کاربران',
                    'routes'=>['comments.index','comment_change_status','comments.destroy','comments.restore']],
            ]
        ];
        return $access;
    }

    public function user_panel_menu($data){
        $data[]=[
            'label'=>'نقد و نظرات',
            'icon'=>'mdi-comment-outline',
            'url'=>url('user/profile/comments'),
        ];
        return $data;
    }

    public function mobile_product_view()
    {
        return [
            [
                'view'=>'comments::mobile.comments',
                'index'=>1
            ]
        ];
    }

}
