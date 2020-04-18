

<!-- <div id="paypal-button"></div>
<div id="paypal-credit-button"></div> -->

<div id="dropin-container"></div>
<button class="btn_full pay_now" id="submit-button">Pay</button>

<!-- <script src="https://www.paypalobjects.com/api/checkout.js" data-version-4 log-level="warn"></script>
<script src="https://js.braintreegateway.com/web/3.26.0/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.26.0/js/paypal-checkout.min.js"></script> -->
<script src="https://js.braintreegateway.com/web/dropin/1.9.0/js/dropin.min.js"></script>
<script>
 /* braintree.client.create({
    authorization: 'sandbox_v5r97hvk_twbd779hfc859jxq'
  }, function (err, clientInstance) {
    braintree.paypalCheckout.create({
      client: clientInstance
    }, function (err, paypalCheckoutInstance) {

      // Set up regular PayPal button
      paypal.Button.render({
        env: 'sandbox', // or 'sandbox'
        payment: function () {
          return paypalCheckoutInstance.createPayment({
            flow: 'vault',
            billingAgreementDescription: 'Your agreement description',
            enableShippingAddress: true,
            shippingAddressEditable: false,
            shippingAddressOverride: {
              recipientName: 'Scruff McGruff',
              line1: '1234 Main St.',
              line2: 'Unit 1',
              city: 'Chicago',
              countryCode: 'US',
              postalCode: '60652',
              state: 'IL',
              phone: '123.456.7890'
            }
          });
        },
        onAuthorize: function (data, actions) {
          return paypalCheckoutInstance.tokenizePayment(data)
            .then(function (payload) {
              console.log(payload);
               $('#pay_now_form').append($('<input type="hidden" id="payment_method_nonce" name="payment_method_nonce" />').val(payload.nonce));
               $('#pay_now_form').submit();
              // Submit `payload.nonce` to your server
            });
        },
      }, '#paypal-button');

    });
  });*/

  var button = document.querySelector('#submit-button');

    braintree.dropin.create({
      authorization: "{{Setting::get('CLIENT_AUTHORIZATION')}}",
      container: '#dropin-container',
      paypal: {
        flow: 'vault',
        currency:"{{Setting::get('currency_code')}}"
      }
    }, function (createErr, instance) {
      console.log(instance);
      button.addEventListener('click', function () {
        $('#ext_card_pay').prop('disabled',true);
        instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
          // Submit payload.nonce to your server
          console.log(payload);
          $('#pay_now_form').append($('<input type="hidden" id="payment_method_nonce" name="payment_method_nonce" />').val(payload.nonce));
          $('#pay_now_form').append($('<input type="hidden" id="payment_card" name="payment_card" />').val(payload.type));
               $('#pay_now_form').submit();
        });
      });
    });
</script>