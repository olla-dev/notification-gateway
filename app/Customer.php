<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * Get the notification for the customer.
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }
}
