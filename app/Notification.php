<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notification extends Model
{
    use Notifiable;


    const CHANNEL_SMS = 'SMS';
    const CHANNEL_EMAIL = 'EMAIL';

    const STATUS_PENDING = 'PENDING';
    const STATUS_SENT = 'SENT';
    const STATUS_FAILED = 'FAILED';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject', 'msgContent', 'category', 'channel', 'phone_number', 'email'];
    


    /**
     * Route notifications for the Nexmo channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForNexmo($notification)
    {
        return $this->phone_number;
    }


    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }
}
