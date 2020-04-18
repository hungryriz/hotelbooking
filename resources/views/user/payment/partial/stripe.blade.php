<form id="payment-form" action="{{ route('card.store') }}" method="POST" >
                {{ csrf_field() }}
    <div class="modal-body">
        <div class="row no-margin" id="card-payment">
            <div class="form-group col-md-12 col-sm-12">
                <label>@lang('user.card.fullname')</label>
                <input data-stripe="name" autocomplete="off" required type="text" class="form-control" placeholder="@lang('user.card.fullname')">
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <label>@lang('user.card.card_no')</label>
                <input data-stripe="number" type="text" onkeypress="return isNumberKey(event);" required autocomplete="off" maxlength="16" class="form-control" placeholder="@lang('user.card.card_no')">
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label>@lang('user.card.month')</label>
                <input type="text" onkeypress="return isNumberKey(event);" maxlength="2" required autocomplete="off" class="form-control" data-stripe="exp-month" placeholder="MM">
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label>@lang('user.card.year')</label>
                <input type="text" onkeypress="return isNumberKey(event);" maxlength="2" required autocomplete="off" data-stripe="exp-year" class="form-control" placeholder="YY">
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label>@lang('user.card.cvv')</label>
                <input type="text" data-stripe="cvc" onkeypress="return isNumberKey(event);" required autocomplete="off" maxlength="4" class="form-control" placeholder="@lang('user.card.cvv')">
            </div>
        </div>
    </div>

  <div class="modal-footer">
    <button type="submit" class="login-btn">@lang('user.card.add_card')</button>
  </div>
</form>
@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
        Stripe.setPublishableKey("{{ Setting::get('stripe_publishable_key')}}");

         var stripeResponseHandler = function (status, response) {
            var $form = $('#payment-form');

            console.log(response);

            if (response.error) {
                // Show the errors on the form
                $form.find('.payment-errors').text(response.error.message);
                $form.find('button').prop('disabled', false);
                alert('error');

            } else {
                // token contains id, last4, and card type
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" id="stripeToken" name="stripe_token" />').val(token));
                jQuery($form.get(0)).submit();
            }
        };
                
        $('#payment-form').submit(function (e) {
            
            if ($('#stripeToken').length == 0)
            {
                console.log('ok');
                var $form = $(this);
                $form.find('button').prop('disabled', true);
                console.log($form);
                Stripe.card.createToken($form, stripeResponseHandler);
                return false;
            }
        });

    </script>
    <script type="text/javascript">
        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        $('#card_pay').on('change',function(){

            if($(this).is(':checked')){
                $('$card_id').val($(this).val());
            }
        })
    </script>
@endsection