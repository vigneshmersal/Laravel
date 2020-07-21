var stripe = Stripe($('#stripe_public_key').val());
var elements = stripe.elements();
var cardElement = elements.create('card', { hidePostalCode: true } );
var errorElement = document.getElementById('card-errors');
var generalPaymentErrorEle = document.getElementById('general-payment-errors');

  cardElement.mount('#card-element');

  cardElement.on('change', function(event) {
    if (event.complete) {
      // enable payment button
      errorElement.textContent = '';
      $(".save-btn").prop('disabled', false);
    } else if (event.error) {
      // show validation to customer
      errorElement.textContent = event.error.message;
      $(".save-btn").prop('disabled', true);
    }
  });


  function createStripeToken(order_details){
  console.log(cardElement)

  show_ajax_loader();
//  stripe.createToken(cardElement).then(function(result) {
//    hide_ajax_loader();
//      if (result.error) {
//        // Inform the user if there was an error.
//        errorElement.textContent = result.error.message;
//      } else {
//        // Send the token to your server.
//        errorElement.textContent = '';
//        console.log(result.token);
//      }
//    });

    stripe
      .confirmCardSetup($('#stripe_setup_intent_id').val(), {
        payment_method: {
          card: cardElement,
          billing_details: {
            name: 'Jenny Rosen',
          },
        },
      })
      .then(function(result) {
        // Handle result.error or result.setupIntent
        hide_ajax_loader();


        if(result.error){
            errorElement.textContent = result.error.message;
            $(errorElement).removeClass('hidden');
        }else{
            console.log(result.setupIntent);
            order_details['card_details'] = {
            'card_status' : 0,
            'card_id' : 0,
            'setup_intent_id' : result.setupIntent.id
          };

          submitAfterCardSelected(order_details);


        }
      });
  }


function reinit_card_element(){
    cardElement.unmount();
    cardElement.mount('#card-element');
}

function setup_intent_saved_card(order_details, card_id = null){
    $.ajax({
        url: "api/v1/create_setup_intent",
        type: "post",
        data: { api_key: api_key, card_id : card_id},
        dataType:'json',
        beforeSend: function () {
            show_ajax_loader();
            generalPaymentErrorEle.textContent = '';
            $(generalPaymentErrorEle).addClass('hidden');
        },
        success: function (res) {
            hide_ajax_loader();
            if(res.Response.response_code == '1'){
                confirm_card_payment(order_details, res.data.intent_client_secret, res.data.payment_method);
            }else{
                generalPaymentErrorEle.textContent = 'Card processing failed. Please verify your card detail and try again';
                $(generalPaymentErrorEle).removeClass('hidden');
            }
        },
        complete: function () {
            hide_ajax_loader();
        },
    });
}

function confirm_card_payment(order_details, PAYMENT_INTENT_CLIENT_SECRET, PAYMENT_METHOD_ID){
    show_ajax_loader();
    generalPaymentErrorEle.textContent = '';
    $(generalPaymentErrorEle).addClass('hidden');

    stripe
        .confirmCardSetup(PAYMENT_INTENT_CLIENT_SECRET, {
            payment_method: PAYMENT_METHOD_ID,
        })
        .then(function(result) {
            // Handle result.error or result.setupIntent
            hide_ajax_loader();

            if(result.error){
                generalPaymentErrorEle.textContent = result.error.message;
                $(generalPaymentErrorEle).removeClass('hidden');
            }else{
                submitAfterCardSelected(order_details);
            }
        });
}
