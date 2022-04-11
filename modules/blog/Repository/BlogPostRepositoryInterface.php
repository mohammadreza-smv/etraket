<?php

namespace Modules\blog\Repository;

use App\Repositories\BaseInterface;

interface BlogPostRepositoryInterface extends BaseInterface
{
    public function getWidgetPosts($data);
}
