<?php

namespace Modules\blog\Http\Controllers;

use App\Http\Controllers\Admin\CustomController;
use Illuminate\Http\Request;
use Modules\blog\Http\Requests\BlogPostRequest;
use Modules\blog\Repository\BlogCategoryRepositoryInterface;
use Modules\blog\Repository\BlogPostRepositoryInterface;

class BlogPostsController extends CustomController
{
    protected $title='پست';

    protected $route_params='blog/posts';

    protected $repository=null;

    public function __construct(BlogPostRepositoryInterface $repository)
    {
        $this->repository=$repository;
    }

    public function index(Request $request,BlogCategoryRepositoryInterface $categoryRepository)
    {
        $posts=$this->repository->getList($request);
        $trash_post_count=$this->repository->trashCount();
        $categories=$categoryRepository->getCategories();
        return CView('blog::post.index',[
            'posts'=>$posts,
            'trash_post_count'=>$trash_post_count,
            'req'=>$request,
            'categories'=>$categories
        ]);
    }

    public function create(BlogCategoryRepositoryInterface $categoryRepository){
        $categories=$categoryRepository->getCategories();
        return CView('blog::post.create',compact('categories'));
    }

    public function store(BlogPostRequest $request){
        $this->repository->create($request);
        return  [
            'redirect_url'=>url('admin/blog/posts'),
            'message'=>'ثبت پست جدید با موفقیت انجام شد'
        ];
    }

    public function edit($id,BlogCategoryRepositoryInterface $categoryRepository){
        $categories=$categoryRepository->getCategories();
        $post=$this->repository->find($id);
        return CView('blog::post.edit',compact('categories','post'));
    }

    public function update(BlogPostRequest $request, $id)
    {
        $this->repository->update($id,$request);
        return  [
            'redirect_url'=>url('admin/blog/posts'),
            'message'=>'ویرایش پست با موفقیت انجام شد'
        ];
    }
}
