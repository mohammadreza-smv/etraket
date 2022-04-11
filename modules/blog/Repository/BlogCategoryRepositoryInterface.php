<?php


namespace Modules\blog\Repository;


use App\Repositories\BaseInterface;

interface BlogCategoryRepositoryInterface extends BaseInterface
{
    public function parentCategories();

    public function getCategories() : array ;

    public function all();
}
