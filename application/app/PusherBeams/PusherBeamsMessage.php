<?php

/*
 * Pusher Message
 * Class
 */

namespace App\PusherBeams;

class PusherBeamsMessage
{
    /**
     * type of notification => app/driver
     *
     * @var string
     *
     */

    public $type;

    /**
     * array of interest(like channel name) to broadcast.
     *
     * @var array
     */
    public $interest;

    /**
     * The title text.
     *
     * @var string
     */
    public $title;

    /**
     * The message or description text
     *
     * @var string
     */
    public $message;


    /**
     * The custom data to send along
     *
     * @var array
     */
    public $custom_data = [];


    /**
     * Create a new message instance.
     *
     * @param  string  $type => user/driver
     * @return void
     */
    public function __construct($type = 'user'){
        $this->type = $type;
    }

    /**
     * Set list of interests
     *
     * @param  array  $interest
     * @return $this
     */
    public function interest($interest)
    {
        $this->interest = $interest;

        return $this;
    }



    /**
     * Set the title text.
     *
     * @param  string  $title
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

     /**
     * Set the message or desc text.
     *
     * @param  string  $message
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }


    /**
     * Set custom data
     *
     * @param  array  custom_data
     * @return $this
     */
    public function custom_data(array $custom_data)
    {
        $this->custom_data = $custom_data;

        return $this;
    }
}
