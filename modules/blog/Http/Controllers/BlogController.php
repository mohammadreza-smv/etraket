<?php

namespace Modules\blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\blog\Repository\BlogCategoryRepositoryInterface;

class BlogController extends Controller
{
    public function index(BlogCategoryRepositoryInterface $blogCategoryRepository){
        $categories=$blogCategoryRepository->all();
        return CView('blog::index',compact('categories'));
    }
}
