<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Carbon\Carbon;

class SMSNotification extends Notification implements ShouldQueue
{
    use Queueable;    
    
    private $notification;

    /**
    * Create a new notification instance.
    *
    * @return void
    */
    public function __construct($notification)
    {
        $this->notification = $notification;


        if(!empty($notification->sendOn)){
            $this->delay(Carbon::parse($notification->sendOn));
        }
    }



    public function dontSend($notifiable)
    {
        return $this->notification->status === \App\Notification::STATUS_CANCELLED;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        if($this->dontSend($notifiable)) {
            return [];
        }    

        return ['nexmo'];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        $notification = $this->notification;

        return (new NexmoMessage)
                    ->content($notification->subject." \n".$notification->msgContent)
                    ->unicode();
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
            'subject' => $this->notification->subject,
            'msgContent' => $this->notification->msgContent
        ];
    }
}
