# Stripe
Install
> composer require stripe/stripe-php

> composer require laravel/cashier

## Links
Laravel Cashier Plan & Subscription integration using stripe v3
> https://hackernoon.com/laravel-6-stripe-payment-integration-example-kim320b

## Setup
```php
# .env
STRIPE_KEY=pk_test_xxxxxxxxxxxxxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxxxxxxxx

# config/services.php
'stripe' => [
    'model'  => App\User::class,
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
],
```

## Test card number
```php
# Succeeds
4242 4242 4242 4242

# Displays a pop-up modal to authenticate & Declines and asks customer for new card
4000 0000 0000 3220

# Require authentication
4000 0025 0000 3155

# insufficient_funds


# International test card (with tax)
4000 0007 6000 0002

```

## Class
```php
# Set API Key for access
Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

# Create token
$token = $stripe->tokens()->create([
	'card' => [
		'number' => $request->get('card_no'),
		'exp_month' => $request->get('ccExpiryMonth'),
		'exp_year' => $request->get('ccExpiryYear'),
		'cvc' => $request->get('cvvNumber'),
	],
]);

# Create a customer
$customer = \Stripe\Customer::create([
    'name' => 'Customer1',
    'email' => 'cust.omer@example.com'
]);

# Charge
$charge = Stripe\Charge::create ([
	"amount" => 100 * 100,
	"currency" => "usd",
	"source" => $request->stripeToken,
	"description" => "Test payment from itsolutionstuff.com."
]);
$charge = $stripe->charges()->create([
	'card' => $request->stripeToken,
	'currency' => 'USD',
	'amount' => 20.49,
	'description' => 'wallet',
]);

# Create Plan
$plan = \Stripe\Plan::create([
    'currency' => 'cad',
    'interval' => 'month',
    'product' => 'prod_GjqhbxxCAq2XmY',
    'nickname' => 'Pro Plan',
    'amount' => 3000,
    'usage_type' => 'metered',
]);

# Create subscription
$subscription = \Stripe\Subscription::create([
	'customer' => 'cus_GjrAgbuWzdsg0G', // $customer->id
	'items' => [['plan' => 'plan_GjqimW27CsRGyL']], // $plan
]);
```

## Handling Exception
```php
try{
} catch (Exception $e) { // $e->getMessage()
} catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
} catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
}
```

## Stripe v2
```php
# bootstrap css
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />

# jquery js
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Form -->
<form class="form-horizontal" method="POST" id="payment-form" action="" >
	@csrf

	<!-- Card Number -->
	<div class='form-row'>
		<div class='col-xs-12 form-group card required'>
			<label class='control-label'>Card Number</label>
			<input autocomplete='off' class='form-control card-number' size='20' type='text' name="card_no">
		</div>
	</div>
	<!-- /Card Number -->

	<div class='form-row'>

		<!-- CVV -->
		<div class='col-xs-4 form-group cvc required'>
			<label class='control-label'>CVV</label>
			<input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' name="cvvNumber">
		</div>
		<!-- /CVV -->

		<!-- ExpiryMonth -->
		<div class='col-xs-4 form-group expiration required'>
			<label class='control-label'>Expiry Month</label>
			<input class='form-control card-expiry-month' placeholder='MM' size='4' type='text' name="ccExpiryMonth">
		</div>
		<!-- /ExpiryMonth -->

		<!-- ExpiryYear -->
		<div class='col-xs-4 form-group expiration required'>
			<label class='control-label'>Expiry Year</label>
			<input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' name="ccExpiryYear">
			{!! Form::hidden('amount', 300, []) !!}
		</div>
		<!-- /ExpiryYear -->

	</div>

	<!-- amount -->
	<div class='form-row'>
		<div class='col-md-12' style="margin-left:-10px;">
			<div class='form-control total btn btn-primary' >
				Total: <span class='amount'>$300</span>
			</div>
		</div>
	</div>
	<!-- /amount -->

	<!-- Pay Button -->
	<div class='form-row'>
		<div class='col-md-12 form-group'>
			<button class='form-control btn btn-success submit-button' type='submit'>Pay »</button>
		</div>
	</div>
	<!-- /Pay Button -->

</form>
<!-- /Form -->

# Stripe js v2
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

# Submit form
$('form').bind('submit', function(e) {
	e.preventDefault();

	// validate
	if (validation faild) {
		$('error').show();
	}

	if (pass) {
		// set srtipe key
		Stripe.setPublishableKey($form.data('stripe-publishable-key'));

		// create stripe token
		Stripe.createToken({
			number: $('.card-number').val(),
			cvc: $('.card-cvc').val(),
			exp_month: $('.card-expiry-month').val(),
			exp_year: $('.card-expiry-year').val()
		}, stripeResponseHandler);
	}
});

function stripeResponseHandler(status, response) {
	if (response.error) {
			$('.error').text(response.error.message).show();
	} else {
		// token contains - id, last4, and card type
		var token = response['id'];

		// insert the token into the form
		$form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

		# submit the form
		$form.get(0).submit();
	}
}
```

## Database
```php
# create_users_table
$table->string('stripe_id')->nullable()->collation('utf8mb4_bin');
$table->string('card_brand')->nullable();
$table->string('card_last_four', 4)->nullable();
$table->timestamp('trial_ends_at')->nullable();

# create_subscriptions_table
$table->increments('id');
$table->unsignedInteger('user_id');
$table->string('name');
$table->string('stripe_id')->collation('utf8mb4_bin');
$table->string('stripe_plan');
$table->integer('quantity');
$table->timestamp('trial_ends_at')->nullable();
$table->timestamp('ends_at')->nullable();
$table->timestamps();

# create_plans_table - create the plans manually on Stripe Dashboard (go to Billing >> Products)
$table->increments('id');
$table->string('name'); // Basic
$table->string('slug')->unique(); // basic
$table->string('stripe_plan'); // Basic
$table->float('cost'); // 50.00
$table->text('description')->nullable();
$table->timestamps();
```

## Model
```php
# User Model
use Laravel\Cashier\Billable; // add cashier
class User extends Authenticatable {
    use Billable;
}

# Plan Model
class Plan extends Model {
    protected $fillable = [
        'name', 'slug', 'stripe_plan', 'cost', 'description'
    ];

    public function getRouteKeyName() {
        return 'slug';
    }
}
```
