<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
     /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.apikey');
    }
    
    /**
     * Create a notification 
     * 
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required|unique:posts|max:255',
            'msgContent' => 'required',
            'type' => 'required',
            'phone_number' => 'required',
            'email_address' => 'required',
            'customer' => 'required',
        ]);
    }
}
