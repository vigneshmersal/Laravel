# Mail
https://blog.mailtrap.io/send-email-in-laravel/

## Domain Verify
https://help.mailgun.com/hc/en-us/articles/360026833053-Domain-Verification-Walkthrough

## customize
https://laraveldaily.com/mail-notifications-customize-templates/

> php artisan make:mail WelcomeMail -m emails.welcome
- app/mail/welcomemail.php
- resources/emails/welcome.blade.php

## publish
> php artisan vendor:publish --tag=laravel-notifications
> php artisan vendor:publish --tag=laravel-mail

## send Mail
```php
$user->notify(new InvoicePaid($invoice));

Mail::to($email)->send(new WelcomeMail());

use Illuminate\Support\Facades\Notification;
use App\Notifications\NewMessage;
Notification::route('mail', 'yourMailtrapEmailAddress')->notify(new NewMessage());
Notification::send($users, new InvoicePaid($invoice));

// Use other mailers,
> Mail::mailer('mailgun')->to()->send();
```

## Preview Mail
If you use Mailables to send email, you can preview the result without sending, directly in your
browser. Just return a Mailable as route result:
```php
Route::get('/mailable', function () {
	return (new App\Notifications\PasswordResetRequest('sduysdfugu'))
			->toMail(auth()->user());
	// or
	$message = (new \App\Notifications\TestNotification())
		->toMail('test@email.com');
	    
	$markdown = new \Illuminate\Mail\Markdown(view(), config(‘mail.markdown’));
	return $markdown->render(‘vendor.notifications.email’, $message->toArray());
});
```

## Features
```php
>>> new Illuminate\Notifications\Messages\MailMessage
=> Illuminate\Notifications\Messages\MailMessage {#4336
	+view: null,
	+textView: null,
	+viewData: [],
	+markdown: "notifications::email",
	+theme: null,
	+from: [],
	+replyTo: [],
	+cc: [],
	+bcc: [],
	+attachments: [],
	+rawAttachments: [],
	+priority: null,
	+callbacks: [],
	+level: "info",
	+subject: null,
	+greeting: null,
	+salutation: null,
	+introLines: [],
	+outroLines: [],
	+actionText: null,
	+actionUrl: null,
	+mailer: null,
}
```

config/mail.php
```php
'mailgun' => [
	'transport' => 'mailgun',
	'host' => env('MAILGUN_HOST', 'smtp.mailgun.org'),
	'port' => env('MAILGUN_PORT', 587),
	'encryption' => env('MAILGUN_ENCRYPTION', 'tls'),
	'domain' => env('MAILGUN_DOMAIN'),
	'secret' => env('MAILGUN_SECRET'),
],
```

___
## Mailgun
```php
MAIL_DRIVER=mailgun
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587 | 465
MAIL_USERNAME={mailid}
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls | ssl
MAILGUN_DOMAIN=
MAILGUN_SECRET=
```

## phpmailer
```php
$mail = new PHPMailer(true);
try {
//Server settings
$mail->SMTPDebug = 0;                                    // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mailgun.org';                      // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'postmaster@domain.com';                 // SMTP username
$mail->Password = 'password';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;									// 587

//Recipients
$mail->setfrom('from@gmail.com', 'fromName');
$mail->addAddress($to,$username);     // Add a recipient
```

## sample code
```php
return (new MailMessage)
    // ->mailer('mailgun')
    ->greeting('Hello!')
    ->line('You are receiving this email because we received a password reset request for your account.')
    ->action('Reset Password', url($url))
    ->line('If you did not request a password reset, no further action is required.');
```

___
