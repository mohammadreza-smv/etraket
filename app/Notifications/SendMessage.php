<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMessage extends Notification implements ShouldQueue
{
    use Queueable;
    protected $message;
    protected $name;
    protected $url;
    protected $parent_id;
    protected $label;
    protected $mobile;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message,$name,$url,$parent_id,$label,$mobile)
    {
        $this->message=$message;
        $this->name=$name;
        $this->url=$url;
        $this->parent_id=$parent_id;
        $this->label=$label;
        $this->mobile=$mobile;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->name ? ['mail',SmsChannel::class] : [SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $text='';
        if( $this->parent_id==0){
            $actionText='نمایش پیام';
            $text=''.$this->label.' گرامی،'.$this->name.' پیامی با عنوان '.$this->message->title.' دریافت کرده اید';
        }
        else
        {
            $actionText='نمایش پاسخ';
            $text=''.$this->label.' گرامی،'.$this->name.' پاسخی به پیام با عنوان '.$this->message->title.' را دریافت کرده اید';
        }
        $subject='دریافت پیام از '.config('shop-info.shop_name').'';
        return (new MailMessage)
                   ->greeting('سلام')
                    ->line($text)
                    ->action($actionText,$this->url)->subject($subject);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
    public function toSms($notifiable)
    {
        $text='';
        if( $this->parent_id==0){
            $text=''.$this->label.' گرامی،'.$this->name.' پیامی با عنوان '.$this->message->title.' دریافت کرده اید';
        }
        else
        {
            $text=''.$this->label.' گرامی،'.$this->name.' پاسخی به پیام با عنوان '.$this->message->title.' را دریافت کرده اید';
        }
        $text.="\n".config('shop-info.shop_name');
        return [
            'mobile_number'=> $this->mobile,
            'message'=>$text
        ];
    }
}
