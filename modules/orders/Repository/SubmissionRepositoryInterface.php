<?php


namespace Modules\orders\Repository;


use App\Repositories\BaseInterface;

interface SubmissionRepositoryInterface
{

    public function submission($request,$status,$order);

    public function trashSubmissionCount($status);

    public function restore($id);

    public function find($id);

    public function destroy($id);

    public function removeItems($ids);

    public function restoreItems($ids);

    public function countForUniqueOrder($where,$arrayStatus=[]);

    public function getOrder($type);
}
