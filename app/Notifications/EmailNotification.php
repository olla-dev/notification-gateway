<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EmailNotification extends Notification implements ShouldQueue
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

        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $notification = $this->notification;

        return (new MailMessage)
                    ->subject($notification->subject)
                    ->line($notification->msgContent);
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
