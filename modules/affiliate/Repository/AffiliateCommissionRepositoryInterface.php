<?php

namespace Modules\affiliate\Repository;

use App\Repositories\BaseInterface;

interface AffiliateCommissionRepositoryInterface  extends BaseInterface
{
    public function getCategories();

    public function getBrands();

    public function checkHas($request);
}
