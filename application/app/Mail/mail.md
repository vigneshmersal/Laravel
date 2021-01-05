# Mail
https://blog.mailtrap.io/send-email-in-laravel/
https://www.cloudways.com/blog/send-email-in-laravel/
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

## send Mail via notification
```php
$user->notify(new InvoicePaid($invoice));

use Illuminate\Support\Facades\Notification;
use App\Notifications\NewMessage;
Notification::route('mail', 'yourMailtrapEmailAddress')->notify(new NewMessage());
Notification::send($users, new InvoicePaid($invoice));
```

## Send Mail
```php
use Illuminate\Support\Facades\Mail;
// Use other mailers,
Mail::mailer('mailgun')
	->locale('es')
	->to($toEmail, $toName)->cc($moreUsers)->bcc($evenMoreUsers)
	->send(new WelcomeMail());
	->queue(new OrderShipped($order));
	->later($when=now()->addMinutes(10), new OrderShipped($order));

Mail::send('markdownPath', $data=['key'=>'value'], function($message) use ($toMail) {
	$message->from($fromMail, $fromName)->to($toMail)->subject($subject);
});
Mails::send([], [], function ($message) use ($toMail, $subject, $content) {
	$message->to($toMail)->subject($subject)->setBody($content, 'text/html'); // raw html
});

Mail::raw($content, function ($message) use ($fromMail, $fromName, $toMail, $subject) {
	$message->from($fromMail, $fromName)->to($toMail)->subject($subject);
});

Mail::queue('send', ['user' => $user], function($message) use ($user) {
	foreach ($user as $user) {
		$message->to($user->email)->subject('Email Confirmation');
	}
});
Mail::queue($view, $data, function($message) use ($toUserName, $subject, $from, $fromName, $to) {
	$message->to($to, $toUserName)->from($from, $fromName)->subject($subject);
});

// check for failures
if (Mail::failures()) { }
if( count(Mail::failures()) > 0 ) {
	foreach(Mail::failures() as $email_address) {   }
}
```

## Preview Mail
If you use Mailables to send email, you can preview the result without sending, directly in your
browser. Just return a Mailable as route result:

```php
Route::get('/mailable', function () {
	return (new App\Notifications\PasswordResetRequest('sduysdfugu'));
	// or
	$message = (new \App\Notifications\TestNotification());
	$markdown = new \Illuminate\Mail\Markdown(view(), config(‘mail.markdown’));
	return $markdown->render(‘vendor.notifications.email’, $message->toArray());
});
```

## Features

```php
>>> new Illuminate\Notifications\Messages\MailMessage
=> Illuminate\Notifications\Messages\MailMessage {#4336
	+view: null,			->view('user.mail')
	+textView: null,
	+viewData: [],
	+markdown: "notifications::email", ->markdown()
	+theme: null,			->theme()
	+from: [],				->from($fromMail, $fromName)
	+replyTo: [],			->replyTo($replyToMail)
	+cc: [], 				->cc($ccMail)
	+bcc: [],				->bcc($bccMail)
	+attachments: [],
	+rawAttachments: [],
	+priority: null,
	+callbacks: [],
	+level: "info",
	+subject: null, 		->subject('Black Friday Campaign');
	+greeting: null, 		->greeting('Hello!')
	+salutation: null,
	+introLines: [],
	+outroLines: [],
	+actionText: null,
	+actionUrl: null,
	+mailer: null, ->greeting('Hello!')
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

## ElasticMail

MAIL_DRIVER=smtp
MAIL_HOST=smtp.elasticemail.com

https://elasticemail.com/integrations/php-integration-library
https://elasticemail.com/api-v1/send-v1
http://api.elasticemail.com/public/help#Email_Send
https://github.com/ElasticEmail/ElasticEmail.WebApiClient-php

https://github.com/dena-a/laravel-elastic-email
https://github.com/rdanusha/LaravelElasticEmail
https://github.com/chocoholics/laravel-elastic-email

## Amazon SES Mail
https://medium.com/@martin.riedweg/configure-amazon-ses-on-laravel-5-8-in-5-minutes-764c30df6399
