<?php

/*
 * Pusher Beams - Push Notification Control Class
 */

namespace App\PusherBeams;

use Pusher\PushNotifications\PushNotifications;

class PusherBeams {

    private $push_notifications;

    public function __construct($type) {
        /*
         * Configure and create new PushNotifications instance
         */

        if($type === 'user'){
            $this->push_notifications = new PushNotifications(array(
                "instanceId" => config('broadcasting.connections.pusher.beams_user_instance_id'),
                "secretKey" => config('broadcasting.connections.pusher.beams_user_secret'),
            ));
        }elseif($type === 'driver'){
            $this->push_notifications = new PushNotifications(array(
                "instanceId" => config('broadcasting.connections.pusher.beams_driver_instance_id'),
                "secretKey" => config('broadcasting.connections.pusher.beams_driver_secret'),
            ));
        }
    }

    /*
     * publish notification
     *
     * @param
     *
     * $interest => channel name to broadcast
     * $title => title text
     * $message => message body text
     * $custom_data => addtional data to be sent to subscribed app
     */

    public function publish_notification(array $interest, $title, $message, array $custom_data = []) {


        try {
            $this->push_notifications->publishToInterests($interest, array(
                "apns" => array("aps" => array(
                        "alert" => array(
                            "title" => $title,
                            "body" => $message,
                        ),
                    ),
                    'data' => $custom_data
                ),
                "fcm" => array("notification" => array(
                        "title" => $title,
                        "body" => $message,
                    ),
                    'data' => $custom_data
                ),
            ));

            return TRUE;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

}
