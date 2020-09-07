<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\URL;
use App\PusherBeams\PusherBeamsChannel;
use App\PusherBeams\PusherBeamsMessage;
use Storage;
use Helper;

// Notification::send(Admin::first(), new TodoCompleted($task));
// $admin->notify(new TodoCompleted($task));
class WelcomeMsgToUser extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Queueable;

    public $user;

    public function __construct(\App\User $user,StripePaymentDetails $payment_details) {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable) {
        return ['database', 'mail', 'nexmo', 'slack', 'broadcast',PusherBeamsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable) {
        \Log::info(['order id=' => $this->order->id]);
        $order_details = $this->getOrderDetails($this->order);

        return (new MailMessage)
            ->subject('Welcome to ' . config('app.name'))
            ->markdown('notifications.shop.driver', ['data' => $order_details])
            ->bcc(config('general.admin_mail_address'), config('general.admin_name'))
            ->bcc(config('general.business_to_email_id'));

        return $this->from('example@example.com')
                ->view('emails.orders.shipped')
                ->text('emails.orders.shipped_plain')
                ->with([
                    'orderName' => $this->order->name,
                    'orderPrice' => $this->order->price,
                ])
                ->attach('/path/to/file')
                ->attach('/path/to/file', [
                    'as' => 'name.pdf',
                    'mime' => 'application/pdf',
                ])
                ->attachFromStorage('/path/to/file')
                ->attachFromStorage('/path/to/file', 'name.pdf', [
                   'mime' => 'application/pdf'
                ])
                ->attachFromStorageDisk('s3', '/path/to/file')
                ->attachData($this->pdf, 'name.pdf', [
                    'mime' => 'application/pdf',
                ]);
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $order_details = $this->getOrderDetails($this->order);
        $order = $this->order;
        $admin_url = url('admin');

        return (new SlackMessage)
            ->success()
            ->content('New Order Alert')
            ->attachment(function ($attachment) use($order_details, $order, $admin_url ) {
                $attachment->title('Order Details:', $admin_url)
                ->fields([
                    'Order Id' => $order_details['order_id'],
                    'Amount' => '£' . $order_details['total_amout'],
                    'From' => $order->user->email,
                    'To the shop' => $order_details['shop_name'],
                ]);
            });
    }

    public function toNexmo($notifiable) {
        return (new NexmoMessage)
            ->content('content' . PHP_EOL
                . 'next line');
    }

    public function toArray($notifiable) {
        return [
            'title' => 'Welcome to ' . config('app.name'),
            'icon' => URL::to('frontEnd/img/notifications/notification1.png'),
            'open' => URL::to('home'),
            'body' => 'Thanks for registering with us',
            'order_id' => $this->order->display_order_id
        ];
    }

    /**
     * Get the broadcastable representation of the notification for pusher beams
     */
    public function toPusherBeams($notifiable) {
        return (new PusherBeamsMessage)
            ->title('Welcome to ' . config('app.name'))
            ->message('Thanks for registering with us')
            ->custom_data(['order_id' => $this->order->display_order_id]);
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast($notifiable) {
        return new BroadcastMessage([
            'title' => 'Order Alert',
            'icon' => URL::to('frontEnd/img/notifications/notification1.png'),
            'open' => URL::to('home'),
            'body' => 'New order was requested. Please check your shop panel...!',
            'order_id' => $this->order->display_order_id
        ]);
    }

    private function getOrderDetails($order) {

        $myRequest = new \Illuminate\Http\Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add(['api_key' => Helper::GeneralWebmasterSettings("api_key"), 'user_id' => $order->user_id, 'order_id'=> $order->display_order_id]);
        $apicontroller = new APIsController();
        $order_res = $apicontroller->fetch_order_details($myRequest);
        $order_data = json_decode( json_encode( $order_res->getData() ),true);

        return $order_data['data']['orders_details'];
    }
}
