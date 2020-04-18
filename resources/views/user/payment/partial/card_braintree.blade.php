<form method="post" id="pay_now_form" action="{{url('card')}}">
	{{csrf_field()}}
  <div id="dropin-container"></div>
   <!-- <div id="paypal-container"></div> -->
  <hr>
  
  <button id="payment-button" class="btn btn-primary btn-flat" type="button">Add New card</button>
</form>

@section('scripts')
  <!-- <script src="https://js.braintreegateway.com/js/braintree-2.30.0.min.js"></script>

    <script>
  braintree.setup('{{$token}}', 'dropin', {
    container: 'dropin-container'
  });
    </script> -->
  <script src="https://js.braintreegateway.com/web/dropin/1.9.0/js/dropin.min.js"></script>
   <script>
  var button = document.querySelector('#payment-button');

    braintree.dropin.create({
      authorization: "{{Setting::get('CLIENT_AUTHORIZATION')}}",
      container: '#dropin-container',
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
@endsection