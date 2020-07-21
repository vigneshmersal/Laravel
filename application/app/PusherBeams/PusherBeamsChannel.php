<?php

/*
 * Custom notification channel for sending notifications to andriod and ios devices
 */

namespace App\PusherBeams;

use App\PusherBeams\PusherBeams;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class PusherBeamsChannel {

    protected $pusher_beams;

    public function __construct() {

    }

    public function send($notifiable, Notification $notification) {

        //get data from notification
        $pusher_message = $notification->toPusherBeams($notifiable, $notification);

        // Pusher Beams instance
        $this->pusher_beams = new PusherBeams($pusher_message->type);

        $interest_channel = $notifiable->routeNotificationFor('PusherBeams');

        if (! $interest_channel || empty($interest_channel) ) {
            return;
        }

        //publish notification
        $result = $this->pusher_beams->publish_notification($interest_channel,$pusher_message->title,$pusher_message->message,$pusher_message->custom_data);

        //error logs
        if($result !== TRUE){
            Log::error( $result );
        }
    }

}
