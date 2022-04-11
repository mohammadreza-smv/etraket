<?php


namespace Modules\incredibleOffers\Repository;

interface IncredibleOffersRepositoryInterface
{
    public function update($price_variation,$request);

    public function remove($priceVariation);

    public function productList($request);

    public function lastOffers($cat1,$cat2);
}
