# Notification

> php artisan notifications:table

> php artisan migrate

> php artisan make:notification TaskCompleted

> php artisan vendor:publish --tag=laravel-notifications

> php artisan vendor:publish --tag=laravel-mail

> php artisan make:notification InvoicePaid --markdown=mail.invoice.paid

> Notification::send(Admin::first(), new TodoCompleted($task));

> $admin->notify(new TodoCompleted($task));

> return (new App\Notifications\InvoicePaid($invoice))->toMail($invoice->user);

app/Notifications/TodoCompleted.php
model

```php
use Illuminate\Notifications\Notifiable;
class User extends Model {
    use Notifiable; // Import Notifiable Trait

    // Specify Slack Webhook URL to route notifications to
    public function routeNotificationForSlack() {
        return $this->slack_webhook_url;
    }
}
```

## firebase
https://firebase.google.com/docs/cloud-messaging/http-server-ref
