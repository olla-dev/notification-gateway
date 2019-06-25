<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Customer;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\Notifications\SMSNotification;
use App\Notifications\EmailNotification;

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
        $validator = \Validator::make($request->all(), [
            'subject' => 'required|max:255',
            'msgContent' => 'required',
            'category' => 'required',
            'channel' => 'required|in:SMS,EMAIL',
            'phone_number' => 'required',
            'email' => 'required',
            'name' => 'required|exists:customers',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        // get Customer by Name and check his credit 
        $customerName = $request->get('name');
        $customer = Customer::where('name', '=', $customerName)->firstOrFail();

        if($customer->credit == 0){
            return response()->json([
                'message' => 'This customer has no notification credit left!'
            ], 500);
        }

        // persist Notification and queue it
        $notification = new Notification;
        $notification->msgId = Uuid::generate();
        $notification->subject = $request->get('subject');
        $notification->msgContent = $request->get('msgContent');
        $notification->channel = $request->get('channel');
        $notification->category = $request->get('category');
        $notification->customer_id = $customer->id;
        $notification->status = Notification::STATUS_PENDING;
        $notification->phone_number = $request->get('phone_number');
        $notification->email = $request->get('email');
        $notification->save();

        // queue notification 
        if($notification->channel == Notification::CHANNEL_SMS){
            if(!$customer->hasSMS){
                $notification->status = Notification::STATUS_FAILED;
                $notification->save();
                return response()->json([
                    'message' => 'This customer does not have SMS notifications enabled!'
                ], 500);
            }

            $notification->notify(new SMSNotification($notification));
        } else {
            if(!$customer->hasEmail){
                $notification->status = Notification::STATUS_FAILED;
                $notification->save();
                return response()->json([
                    'message' => 'This customer does not have email notifications enabled!'
                ], 500);
            }

            $notification->notify(new EmailNotification($notification));
        }

        return response()
            ->json(['message' => 'Notification submitted successfully!']);
            
    }
}
