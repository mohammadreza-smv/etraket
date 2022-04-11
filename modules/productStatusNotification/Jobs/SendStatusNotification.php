<?php

namespace Modules\productStatusNotification\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\productStatusNotification\Models\ProductStatusNotification;
use DB;

class SendStatusNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;

    protected $page;

    protected $setting;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product,$page,$setting)
    {
        $this->product=$product;
        $this->page=$page;
        $this->setting=$setting;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->product){
            $items=ProductStatusNotification::where('product_id',$this->product->id)
                ->skip($this->page)->take(10)->get();
            foreach ($items as $item){
                $user=DB::table('users')->find($item->user_id);
                if($user){
                    $text=config('shop-info.shop_name').' : ';
                    $text.=$user->name."\n";
                    $text.='کالای ';
                    $text.=$this->product->title.' را در حال حاضر موجود داریم';
                    $text.="\n".shop_short_product_url($this->product);
                    if($item->send_message==1) {
                        send_message($user,$text);
                    }
                    if($item->send_sms==1){
                        $channel=$this->setting['product-notification-channel'];
                        run_action($channel.'_send_sms',[
                            [
                                'message'=>$text,
                                'mobile_number'=>$user->mobile,
                                'channel'=>$channel,
                                'line_number'=>$this->setting['product-notification-line-number'],
                                'api-key'=>$this->setting['product-notification-api-key'],
                                'template'=>''
                            ]
                        ]);
                    }
                    $item->delete();
                }
            }
        }

    }
}
