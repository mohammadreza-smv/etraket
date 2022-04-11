<?php

namespace Modules\productStatusNotification\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\products\Repository\ProductRepositoryInterface;
use Modules\productStatusNotification\Models\ProductStatusNotification;
use Modules\setting\Repository\SettingRepositoryInterface;

class StatusNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product_id)
    {
        $this->product_id=$product_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $productRepository=app(ProductRepositoryInterface::class);
        $settingRepository=app(SettingRepositoryInterface::class);
        $product=$productRepository->first(['id'=>$this->product_id],[],['id','title']);
        $setting=$settingRepository->getValues([
            'product-notification-channel',
            'product-notification-api-key',
            'product-notification-line-number',
        ]);
        if($product){
            $count=ProductStatusNotification::where('product_id',$this->product_id)->count();
            if($count>0){
                $n=ceil($count/10);
                for ($i=0;$i<$n;$i++){
                    SendStatusNotification::dispatch($product,$i,$setting);
                }
            }
        }

    }
}
