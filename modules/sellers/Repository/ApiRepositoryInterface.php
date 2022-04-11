<?php


namespace Modules\sellers\Repository;


interface ApiRepositoryInterface
{
    public function first_step_register($request);

    public function second_step_register($request);

    public function resend_active_code($request);

    public function check_active_code($request);

    public function upload_document($request);

    public function monthSalesStatistics();

    public function orders($request);

    public function edit_profile($request);

    public function profile_active_code($request);

    public function seller_payment($request);

    public function order_content($id);
}
