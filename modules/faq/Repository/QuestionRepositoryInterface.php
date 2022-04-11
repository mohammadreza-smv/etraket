<?php


namespace Modules\faq\Repository;


use App\Repositories\BaseInterface;

interface QuestionRepositoryInterface extends BaseInterface
{
    public function getCat():array ;
    public function get($where);
    public function search($key,$value);
}
