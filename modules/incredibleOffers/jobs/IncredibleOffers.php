<?php


namespace Modules\incredibleOffers\jobs;


use App\Offers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\incredibleOffers\Repository\IncredibleOffersRepositoryInterface;
use Modules\priceVariation\Models\PriceVariation;
use Modules\priceVariation\Repository\PriceVariationRepositoryInterface;

class IncredibleOffers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $row_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->row_id=$id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $variationRepository=app(PriceVariationRepositoryInterface::class);
        $offersRepository=app(IncredibleOffersRepositoryInterface::class);

        $priceVariation=$variationRepository->first(['id'=>$this->row_id]);

        if($priceVariation && $priceVariation->offers==1){
            $time=time();
            if($priceVariation->offers_first_time<=$time)
            {
                $offersRepository->remove($priceVariation);
            }
        }
    }
}
