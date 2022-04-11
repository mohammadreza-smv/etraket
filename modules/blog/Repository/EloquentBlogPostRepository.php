<?php

namespace Modules\blog\Repository;

use App\Repositories\EloquentBaseRepository;
use Modules\blog\Models\BlogCategory;
use Modules\blog\Models\BlogPost;

class EloquentBlogPostRepository extends EloquentBaseRepository implements BlogPostRepositoryInterface
{

    protected  $model='Modules\blog\Models\BlogPost';

    public function find($id)
    {
        return BlogPost::findOrFail($id);
    }

    public function create($request)
    {
        $post=new BlogPost($request->all());
        $post->url=get_url($request->get('title'));
        $img_url=upload_file($request,'pic','posts');
        $post->pic=$img_url;
        create_fit_pic('files/posts/'.$img_url,$img_url,500,400);
        $post->save();
    }

    public function trashCount()
    {
        return BlogPost::onlyTrashed()->count();
    }

    public function getList($request)
    {
        return BlogPost::getData($request->all());
    }

    public function update($id, $request)
    {
        $data=$request->all();
        $post=BlogPost::findOrFail($id);
        $post->url=get_url($request->get('title'));
        $img_url=upload_file($request,'pic','posts');
        if($img_url!=null){
            $post->pic=$img_url;
            create_fit_pic('files/posts/'.$img_url,$img_url,500,400);
        }
        unset($data['pic']);
        $post->update($data);
    }

    public function getWidgetPosts($data)
    {
        $select=['id','title','url','pic','created_at','view'];
        if($data['show_content']){
            $select[]='content';
        }
        $order=$data['sort']==0 ? 'id' : 'view';
        $limit=intval($data['count']);
        $posts=BlogPost::select($select);
        if(!empty($data['catId'])){
            $catsId=$this->getCatList($data['catId']);
            $posts=$posts->whereIn('cat_id',$catsId);
        }
        return $posts->orderBy($order,'DESC')->limit($limit)->get();
    }

    protected function getCatList($catId){
        $array=[];
        $category=BlogCategory::where('id',$catId)->with('child')->first();
        if($category){
            $array[]=$catId;

            foreach ($category->child as $child){
                $array[]=$child->id;
            }
        }
        return $array;
    }
}
