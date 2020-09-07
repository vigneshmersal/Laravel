# Mail
https://blog.mailtrap.io/send-email-in-laravel/

> php artisan make:mail WelcomeMail -m emails.welcome
- app/mail/welcomemail.php
- resources/emails/welcome.blade.php

Use default,
> Mail::to($email)->send(new WelcomeMail());

Use other mailers,
> Mail::mailer('mailgun')->to()->send();

## publish
> php artisan publish -> choose laravel-mail
- resources/vendor/mail

## Preview Mailables
If you use Mailables to send email, you can preview the result without sending, directly in your
browser. Just return a Mailable as route result:
```php
Route::get('/mailable', function () {
	return new App\Mail\InvoicePaid($user);
});
```

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

___
## Mailgun
MAIL_DRIVER=mailgun
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587 | 465
MAIL_USERNAME={mailid}
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls | ssl
MAILGUN_SECRET=
MAILGUN_DOMAIN=

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

___
