private function process_card_for_charge_later($user, $order_id, $card_details) {

		$StripePayment = new \App\Stripe\StripePayment();

		if ((Int) $card_details['card_status'] === 0) {
			$stripe_cus_exist = $StripePayment->check_stripe_customer_exist($user->id);
			if ($stripe_cus_exist) {
				$stripe_res = $StripePayment->add_card_to_existing_stripe_customer($user->id, $card_details['card_token'], $card_details['card_cvc']);
				Log::info('Order - Add Card to Stripe Customer', ['orderId' => $order_id]);
			} else {
				$stripe_res = $StripePayment->create_stripe_customer_and_save_card($user, $card_details['card_token'], $card_details['card_cvc']);
				Log::info('Order - Create Stripe Customer & Save Card', ['orderId' => $order_id]);
			}
		} else {
			$stripe_res = $StripePayment->fetch_stripe_card_details($user->id, $card_details['card_id']);
			Log::info('Order - Get Stripe Card Details', ['orderId' => $order_id]);
		}

		if ($stripe_res['status'] === '1') {
			$OrderCard = new \App\OrderCard();
			$OrderCard->order_id = $order_id;
			$OrderCard->card_id = $stripe_res['data']['card_id'];
			$OrderCard->save();
			Log::info('Order - Process Card Successful', ['orderId' => $order_id]);
			return TRUE;
		} elseif ($stripe_res['status'] === '0') {
			Log::info('Order - Process Card Unsuccessful', ['orderId' => $order_id, 'error_message' => $stripe_res['message'], 'data' => $stripe_res['data']]);
			return $stripe_res['message'];
		} else {
			Log::info('Order - Process Card Unsuccessful', ['orderId' => $order_id, 'error_message' => $stripe_res['message'], 'data' => $stripe_res['data']]);
			//return 'card processing failed';
			return $stripe_res['message'];
		}
	}

	public function verify_cvc(Request $request) {
		try {
			$response_array = [];
			if ($request->api_key == Helper::GeneralWebmasterSettings("api_key")) {
				$validation_result = $this->check_required_input($request, ['user_id', 'card_id', 'cvc']);
				if (empty($validation_result)) {//if none of required field missing
					$user = new User();
					if ($user->find($request->user_id)) {
						$StripePayment = new \App\Stripe\StripePayment();
						$res = $StripePayment->verify_card_cvc($request->user_id, $request->card_id, $request->cvc);
						if ($res) {
							$response_array = ['Response' => [
									'response_code' => '1',
									'response_message' => 'success'
								],
								'data' => [
									'card_id' => $request->card_id
								]
							];
						} else {
							$response_array = ['Response' => [
									'response_code' => '-1',
									'response_message' => 'card cvc not valid / card expired'
								],
								'data' => (object) []
							];
						}
					} else {
						$response_array = ['Response' => [
								'response_code' => '-1',
								'response_message' => 'not a valid user id'
							],
							'data' => (object) []
						];
					}
				} else {
					//return error responce
					$response_array = $validation_result;
				}
			} else {
				$response_array = ['Response' => [
						'response_code' => '-1',
						'response_message' => 'authentication failed'
					],
					'data' => (object) []
				];
			}
		} catch (\Exception $e) {
			$response_array = [
				'Response' => [
					'response_code' => '-1',
					'response_message' => $this->default_error_message
				],
				'data' => (object) []
			];
		}
		return $this->convertNullsAsEmpty($response_array);
	}