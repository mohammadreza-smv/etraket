<?php

namespace Modules\blog\Models;

use App\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends CustomModel
{
    use SoftDeletes;

    protected $table='blog__posts';

    protected $guarded=[];

    public static function getData($data)
    {
        $title=array_key_exists('title',$data) ? $data['title'] : '';
        $cat_id=array_key_exists('cat_id',$data) ? $data['cat_id'] : '';
        $categories=[];
        if($cat_id!=''){
            $categories=BlogCategory::where('parent_id',$cat_id)->pluck('id','id')->toArray();
            $categories[$cat_id]=intval($cat_id);
        }
        $filters=[
            ['title','like',$title],
            ['cat_id',$categories]
        ];

        return self::CPaginate($data,$filters,['category']);
    }

    public function category(){
        return $this->belongsTo(BlogCategory::class,'cat_id','id')
            ->withDefault(['name'=>'دسته اصلی']);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($post) {
            if ($post->isForceDeleting()) {
                remove_file($post->pic,'posts');
                remove_file($post->pic,'thumbnails');
            }
        });
    }
}
