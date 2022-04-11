<?php


namespace Modules\address\Repository;


interface AddressRepositoryInterface
{
    public function all($user_id);

    public function create($request);

    public function delete($address_id,$request,$getList=true);

    public function update($request);

    public function paginate($user_id);

    public function first($where,$withTrashed=false,$relation=[]);

    public function add($data);

    public function edit($id,$user_id,$data);
}
