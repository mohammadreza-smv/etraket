<?php

namespace Modules\sellers\Repository;

use App\Repositories\BaseInterface;

interface CommissionRepositoryInterface  extends BaseInterface
{
    public function getCategories();

    public function getBrands();

    public function checkHas($request);
}
