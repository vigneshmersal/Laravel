<?php

namespace App\Stripe;

use App\OrderCard;
use App\UserCardDetails;
use Illuminate\Support\Facades\Hash;
use Log;

class StripePayment {

    private $admin_commision;

    public function __construct() {
        $this->admin_commision = env('SHOP_COMMISSION', 15); /* in percentage without symbol(%) */
        \Stripe\Stripe::setApiKey(config('payment.stripe.secret_key'));
    }

    public function create_stripe_customer_and_save_card($user, $setup_intent_id) {
        try {

            $setup_intent = $this->fetch_setup_intent_by_id($setup_intent_id);
            
            if($setup_intent){

                $stripe_customer = \Stripe\Customer::create([
                    'payment_method' => $setup_intent->payment_method,
                ]);

                $user_stripe = new \App\UserStripeDetails();
                $user_stripe->user_id = $user->id;
                $user_stripe->stripe_cus_id = $stripe_customer->id;
                $user_stripe->is_active = 1;
                $user_stripe->payload = json_encode($stripe_customer);
                $user_stripe->save();


                $PaymentMethod = \Stripe\PaymentMethod::all([
                    'customer' => $stripe_customer,
                    'type' => 'card',
                ]);

                $user_card_id = $this->save_card_details_db($user->id, $user_stripe->id, $PaymentMethod->data[0], 1);

                if ($user_card_id) {
                    return ['status' => '1', 'data' => ['stripe_id' => $user_stripe->id, 'card_id' => $user_card_id], 'message' => 'success'];
                } else {
                    return ['status' => '2', 'data' => '', 'message' => 'card save in db failed'];
                }
            }else{
                return ['status' => '2', 'data' => '', 'message' => 'invalid stripe token given'];
            }
        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'card declined'];
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'too many requests made to the api too quickly'];
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'invalid parameters were supplied to stripe\'s api'];
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'authentication with stripe\'s api failed'];
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'network communication with stripe failed'];
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'generic stripe error'];
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return ['status' => '3', 'data' => $e->getMessage(), 'message' => 'non stripe generic error'];
        }
    }

    public function save_card_details_db($user_id, $stripe_id, $payment_method, $is_default = 0) {
        try {

            $card = $payment_method->card;

            $user_card = UserCardDetails::where('fingerprint', $card->fingerprint)
                    ->where('user_id',$user_id)
                    ->where('stripe_id',$stripe_id)
                    ->first();
            
            if(!$user_card){
                $user_card = new UserCardDetails();
            }
            
            
            $user_card->user_id = $user_id;
            $user_card->stripe_id = $stripe_id;
            $user_card->stripe_card_id = $payment_method->id;
            $user_card->fingerprint = $card->fingerprint;
            $user_card->brand = $card->brand;
            $user_card->last4 = $card->last4;
            $user_card->exp_month = $card->exp_month;
            $user_card->exp_year = $card->exp_year;
            $user_card->payload = json_encode($card);
            $user_card->is_active = 1;
            $user_card->is_default = $is_default;
            $user_card->save();
            return $user_card->id;
        } catch (\Exception | \Throwable $e) {
            return false;
        }
    }

    public function check_stripe_customer_exist($user_id) {
        try {
            $user_stripe = \App\UserStripeDetails::whereUserId($user_id)->first();
            if ($user_stripe) {
            	Log::info('Payment - Stripe customer exist', ['userId' => $user_id]);
                //$user_stripe_details = $user_stripe->toArray();
                return $user_stripe;
            } else {
            	Log::info('Payment - Stripe customer not exist', ['userId' => $user_id]);
                return null;
            }
        } catch (\Exception $ex) {
        	Log::error('Payment - Stripe customer exist check', ['userId' => $user_id, 'error_message' => $ex->getMessage()]);
            return false;
        }
    }

    public function list_user_cards($user_id) {
        $cards_list = [];
        $stripe_customer = $this->check_stripe_customer_exist($user_id);
        if ($stripe_customer) {
            try {
                //$cards_list = \Stripe\Customer::retrieve($stripe_customer->stripe_cus_id)->sources->all(array('object' => 'card'));
                $user_cards = UserCardDetails::whereUserId($user_id)->whereIsActive(1)->get();
                if (count($user_cards->toArray()) > 0) {
                    foreach ($user_cards as $user_card) {
                        if (( $user_card->exp_year > date('Y') ) || ( $user_card->exp_year == date('Y') && $user_card->exp_month >= date('m') )) {
                            $temp = [];
                            $temp['id'] = $user_card->id;
                            $temp['last4'] = $user_card->last4;
                            $temp['brand'] = $user_card->brand;
                            $temp['is_default'] = $user_card->is_default;
                            $cards_list[] = $temp;
                        } else {
                            $user_card->is_active = 0;
                            $user_card->save();
                        }
                    }
                    return $cards_list;
                } else {
                    return null;
                }
            } catch (\Exception $ex) {
                return false;
            }
        } else {
            return null;
        }
    }

    public function delete_user_card($user_id, $card_id) {
        $stripe_customer = $this->check_stripe_customer_exist($user_id);
        if ($stripe_customer) {
            try {
                $user_card = UserCardDetails::find($card_id);

                if ($user_card) {
                    if ($user_card->is_default === 1) {
                        $user_card_next = UserCardDetails::where('id', '!=', $user_card->id )->whereUserId($user_id)->orderBy('id', 'desc')->first();
                        if ($user_card_next) {
                            $user_card->is_default = 0;
                            $user_card->save();

                            $user_card_next->is_default = 1;
                            $user_card_next->save();
                        }
                    }

                    $user_card->delete();

                    $payment_method = \Stripe\PaymentMethod::retrieve($user_card->stripe_card_id);
                    $payment_method->detach();

                    return true;
                } else {
                    return null;
                }
            } catch (\Exception $ex) {
                return false;
            }
        } else {
            return null;
        }
    }

    public function create_charge($user_id, $order_id, $amount, $card_id, $currency) {
        try {
            $stripe_customer = $this->check_stripe_customer_exist($user_id);

            $user_card = UserCardDetails::find($card_id);

            if ($user_card) {

                Log::info('Payment - User card exist', ['userId' => $user_id]);

                $PaymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => $amount * 100,
                    'currency' => 'usd',
                    'customer' => $stripe_customer->stripe_cus_id,
                    'payment_method' => $user_card->stripe_card_id,
                    'off_session' => true,
                    'confirm' => true,
                ]);

                if ($PaymentIntent) {
                    $stripe_charge = $PaymentIntent->charges->data[0];

                    $balance_transaction = \Stripe\BalanceTransaction::retrieve($stripe_charge->balance_transaction);

                	Log::info('Payment - Stripe Charge Successful', ['txn_id' => $balance_transaction->id]);
                	
                    $payment_details = new \App\StripePaymentDetails();
                    $payment_details->user_id = $user_id;
                    $payment_details->order_id = $order_id;
                    $payment_details->stripe_id = $stripe_customer->id;
                    $payment_details->card_id = $card_id;
                    $payment_details->txn_id = $balance_transaction->id;
                    $payment_details->charge_id = $stripe_charge->id;
                    $payment_details->amount = ($stripe_charge->amount) / 100; //stripe will acceept in cents/pounds
                    $payment_details->currency = $stripe_charge->currency;
                    $payment_details->payload = json_encode($stripe_charge);

                    $payment_details->save();

                    //for notification and other purpose
                    $user = \App\User::find($user_id);
                    $order = \App\Order::find($order_id);
                    $shop = \App\Shop::find($order->shop_id);

                    //make splits and save in payment split table

                    $stripe_fee = $balance_transaction->fee; //in cents
                    $exchange_rate = $balance_transaction->exchange_rate??0;
                    $stripe_fee_in_current_currency = $exchange_rate?($stripe_fee / $exchange_rate):$stripe_fee; // for eg pence
                    $stripe_fee_in_current_currency = $stripe_fee_in_current_currency / 100; // in pound ==> 100 pence = 1 pound

                    $net_amount = $amount - $stripe_fee_in_current_currency;

                    $admin_share = ($net_amount * $this->admin_commision) / 100;

                    $shop_share = $net_amount - $admin_share;

                    $payment_splits = new \App\OrderPaymentSplit();
                    $payment_splits->order_id = $order_id;
                    $payment_splits->admin_commission = $this->admin_commision;
                    $payment_splits->stripe_fees = $stripe_fee_in_current_currency;
                    $payment_splits->admin_share = round($admin_share, 2);
                    $payment_splits->shop_share = round($shop_share, 2);
                    $payment_splits->total_amount = $amount;
                    $payment_splits->save();

                    $shop_balance_sheet = new \App\ShopBalanceSheet();
                    $shop_balance_sheet->shop_id = $order->shop_id;
                    $shop_balance_sheet->amount = round($shop_share, 2);
                    $shop_balance_sheet->type = 0; //credit
                    $shop_balance_sheet->order_id = $order_id;
                    $shop_balance_sheet->save();
					Log::info('Payment - Commission', ['admin_commission' => $this->admin_commision]);

                    return ['status' => '1', 'data' => ['payment_id' => $payment_details->id, 'payment_details' => $payment_details], 'message' => 'success'];
                } else {
                	Log::error('Payment - Stripe Charge Unsuccessful', ['userId' => $user_id, 'error_message' => json_encode($stripe_charge)]);
                    return ['status' => '2', 'data' => '', 'message' => 'something went wrong'];
                }
            } else {
            	Log::error('Payment - Stripe Card', ['userId' => $user_id, 'error_message' => 'Card not found']);
                return ['status' => '3', 'data' => '', 'message' => 'card not found'];
            }
        }catch (\Stripe\Exception\CardException $e) {

            if($e->getError()->code == 'authentication_required'){
                //            $payment_intent_id = $e->getError()->payment_intent->id;
                //            $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);

                Log::error('Payment - Re-authentication required', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
                return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'Re-authentication required'];
            }else{
                Log::error('Payment - Stripe Card Exception', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
                return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'Stripe Card Exception'];
            }
        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            Log::error('Payment - Stripe Card Declined', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'card declined'];
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            Log::error('Payment - Stripe Card Rate Limit', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'too many requests made to the api too quickly'];
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            Log::error('Payment - Stripe Card Invaild Parameters', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'invalid parameters were supplied to stripe\'s api'];
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            Log::error('Payment - Stripe Authentication Failed', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'authentication with stripe\'s api failed'];
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            Log::error('Payment - Stripe API Connection Failed', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'network communication with stripe failed'];
        } catch (\Stripe\Error\Base $e) {
        	Log::error('Payment - Stripe Generic Error', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'generic stripe error'];
        } catch (\Exception $e) {
        	Log::error('Payment - Stripe Error', ['userId' => $user_id, 'error_message' => $e->getMessage()]);
            // Something else happened, completely unrelated to Stripe
            return ['status' => '3', 'data' => $e->getMessage(), 'message' => 'non stripe generic error'];
        }
    }

    public function processing_charge($user_id, $order_id, $amount, $card_id, $currency = 'GBP') {
		Log::info('Payment - Stripe charge initiated', ['orderId' => $order_id]);
        $pay_res = $this->create_charge($user_id, $order_id, $amount, $card_id, $currency);

        $payment_status = new \App\OrderPaymentStatus();
        $payment_status->order_id = $order_id;

        if ($pay_res['status'] === '1') {
        	Log::info('Payment - Stripe charge successful', ['orderId' => $order_id]);
            $payment_status->status = 1;
        } else {
        	Log::error('Payment - Stripe charge unsuccessful', ['orderId' => $order_id, 'error_message' => $pay_res['message']]);
            $payment_status->status = 0;

            $payment_fail_log = new \App\OrderPaymentFailLog();
            $payment_fail_log->order_id = $order_id;
            $payment_fail_log->error_status = (Int) $pay_res['status'];
            $payment_fail_log->error_message = $pay_res['message'];
            $payment_fail_log->save();
        }
        $payment_status->save();

        $paymentDetails = null;
        if( is_array( $pay_res['data'] ) && isset($pay_res['data']['payment_details']) ) {
        	$paymentDetails = $pay_res['data']['payment_details'];
        }
        
        return array('status' => $payment_status->status, 'payment_details' => $paymentDetails);
    }

    public function get_payment_fail_log($order_id) {
        try {
            $payment_fail_log = \App\OrderPaymentFailLog::whereOrderId($order_id)->orderBy('id', 'desc')->first();
            if ($payment_fail_log) {
                return $payment_fail_log->error_message;
            } else {
                return 'no logs found for the order';
            }
        } catch (\Exception $ex) {
            return null;
        }
    }

    public function add_card_to_existing_stripe_customer($user_id, $setup_intent_id) {
        try {
            $setup_intent = $this->fetch_setup_intent_by_id($setup_intent_id);
            if($setup_intent){

                $payment_method = \Stripe\PaymentMethod::retrieve($setup_intent->payment_method);
                $stripe_customer = $this->check_stripe_customer_exist($user_id);
                $payment_method->attach(['customer' => $stripe_customer->stripe_cus_id]);
                $user_card_id = $this->save_card_details_db($user_id, $stripe_customer->id, $payment_method);

                if ($user_card_id) {
                    return ['status' => '1', 'data' => ['stripe_id' => $stripe_customer->id, 'card_id' => $user_card_id], 'message' => 'success'];
                } else {
                    return ['status' => '2', 'data' => '', 'message' => 'card save in db failed'];
                }
            }else{
                return ['status' => '2', 'data' => '', 'message' => 'invalid stripe token given'];
            }
        } catch (\Stripe\Error\Card $e) {
        	Log::error('Order - Add Card To Stripe Customer Card Declined', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
            // Since it's a decline, \Stripe\Error\Card will be caught
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'card declined'];
        } catch (\Stripe\Error\RateLimit $e) {
        	Log::error('Order - Add Card To Stripe Customer Throttle Limit', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
            // Too many requests made to the API too quickly
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'too many requests made to the api too quickly'];
        } catch (\Stripe\Error\InvalidRequest $e) {
        	Log::error('Order - Add Card To Stripe Customer Invalid Request', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
            // Invalid parameters were supplied to Stripe's API
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'invalid parameters were supplied to stripe\'s api'];
        } catch (\Stripe\Error\Authentication $e) {
        	Log::error('Order - Add Card To Stripe Customer Authentication', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'authentication with stripe\'s api failed'];
        } catch (\Stripe\Error\ApiConnection $e) {
        	Log::error('Order - Add Card To Stripe Customer API Connection', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);
            // Network communication with Stripe failed
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'network communication with stripe failed'];
        } catch (\Stripe\Error\Base $e) {
			Log::error('Order - Add Card To Stripe Customer Generic Error', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);        	
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'generic stripe error'];
        } catch (\Exception $e) {
			Log::error('Order - Add Card To Stripe Customer Non Generic Error', ['userId' => $user_id, 'error_message' => $e->getJsonBody()]);        	
            // Something else happened, completely unrelated to Stripe
            return ['status' => '3', 'data' => $e->getMessage(), 'message' => 'non stripe generic error'];
        }
    }

    public function fetch_setup_intent_by_id($setup_intent_id) {
        try {
            $setup_intent = \Stripe\SetupIntent::retrieve($setup_intent_id);
            return $setup_intent;
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return false;
        }
    }

    public function fetch_stripe_card_details($user_id, $card_id) {

        try {

            $user_card = UserCardDetails::whereId($card_id)->whereUserId($user_id)->first();
            $stripe_customer = $this->check_stripe_customer_exist($user_id);

            if ( $user_card && $stripe_customer  ) {
                $payment_method = \Stripe\PaymentMethod::retrieve($user_card->stripe_card_id);
                if ($payment_method) {
                    return ['status' => '1', 'data' => ['stripe_id' => $stripe_customer->id, 'card_id' => $user_card->id], 'message' => 'success'];
                } else {
                    return ['status' => '2', 'data' => '', 'message' => 'card fetch from stripe failed'];
                }
            } else {
                return ['status' => '3', 'data' => ['user_id' => $user_id, 'card_id' => $card_id], 'message' => 'stripe user not found in remote'];
            }
        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'card declined'];
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'too many requests made to the api too quickly'];
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'invalid parameters were supplied to stripe\'s api'];
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'authentication with stripe\'s api failed'];
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'network communication with stripe failed'];
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return ['status' => '0', 'data' => $e->getJsonBody(), 'message' => 'generic stripe error'];
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return ['status' => '3', 'data' => $e->getMessage(), 'message' => 'non stripe generic error'];
        }
    }

}
