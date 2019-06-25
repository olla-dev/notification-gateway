<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notification;
use App\Customer;
use Illuminate\Support\Facades\Log;

class LogNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotificationSent  $event
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        $notification = $event->notifiable;
        Log::info('Showing notification id: '.$notification->id);
        
        $notification->status = Notification::STATUS_SENT;
        $notification->save();

        // now decrement customer credit
        $customer = Customer::find($notification->customer_id);
        $customer->credit = $customer->credit - 1;
        $customer->save();
    }
}
