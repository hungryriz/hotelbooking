@extends('user.layouts.app')

@section('title', 'Payment')

@section('content')
  <!-- Content ================================================== -->
    <div class="container margin_60_35">
        <div class="row">
             @include('include.alerts')
            <div class="col-md-3">
                <div class="box_style_2 hidden-xs info">
                    <h4 class="nomargin_top">@lang('home.payment.delivery_time_title') <i class="icon_clock_alt pull-right"></i></h4>
                    <p>
                        @lang('home.payment.delivery_time_desc')
                    </p>
                    <hr>
                    <h4>@lang('home.payment.secure_payment_title') <i class="icon_creditcard pull-right"></i></h4>
                    <p>
                        @lang('home.payment.secure_payment_desc')
                    </p>
                </div>
                <!-- End box_style_2 -->
                <div class="box_style_2 hidden-xs" id="help">
                    <i class="icon_lifesaver"></i>
                    <h4>@lang('home.payment.need_help')</h4>
                    <a href="javascript:void(0)" class="phone">@lang('home.payment.contact_number')</a>
                    <!-- <small>Monday to Friday 9.00am - 7.30pm</small> -->
                </div>
            </div>
            <!-- End col-md-3 -->
            <div class="col-md-6">
                <div class="box_style_2">
                    <h2 class="inner">@lang('user.payment_method') @if(Request::get('type')=='ether' || Request::get('type')=='ripple') 
                    <span class="pull-right">Total {{currencydecimal(Session::get('amount'))}}(USD)</span>
                    @endif </h2>
                    @if(Request::get('type')=='ripple')
                        @include('user.payment.partial.ripple')

                    @elseif(Request::get('type')=='ether')
                        @include('user.payment.partial.ether')
                    @else
                    <?php $card_id = 0;?>
                    @forelse($cards as $card)
                     @if($card->is_default)
                        <?php $card_id = $card->id; ?>
                        <div class="payment_select">
                            <label>
                                <input type="radio" value="{{$card->id}}" checked name="payment_method" class="icheck">XXX XXX XXXX {{$card->last_four}}</label>
                                <form action="{{route('card.destroy',$card->id)}}" method="POST" class="pull-right">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="card_id" value="{{$card->card_id}}">
                                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm" ><i class="icon_trash_alt delete"></i></button>
                                </form>
                                
                            @if($card->brand=='Visa')
                                <img src="{{asset('assets/user/img/visa.png')}}" alt="" data-retina="true" class="" style="float: right;">
                            @elseif($card->brand == 'mastercard')
                            <img src="{{asset('assets/user/img/master.png')}}" alt="" data-retina="true" class="" style="float: right;">
                            @endif
                        </div>
                    @else
                         <div class="payment_select">
                            <label>
                                <input type="radio" value="{{$card->id}}"  name="payment_method" class="icheck">XXX XXX XXXX {{$card->last_four}}</label>
                                <form action="{{route('card.destroy',$card->id)}}" method="POST" class="pull-right">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="card_id" value="{{$card->card_id}}">
                                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm" ><i class="icon_trash_alt delete"></i></button>
                                </form>
                            @if($card->brand=='Visa')
                                <img src="{{asset('assets/user/img/visa.png')}}" alt="" data-retina="true" class="" style="float: right;">
                            @elseif($card->brand == 'mastercard')
                            <img src="{{asset('assets/user/img/master.png')}}" alt="" data-retina="true" class="" style="float: right;">
                            @endif
                        </div>
                    @endif
                    @empty
                    <div>@lang('home.payment.no_card')</div>
                    @endforelse
                    @if(count($cards)>0)
                        <form action="{{url('orders')}}" id="pay_now_form" method="POST" >
                            {{ csrf_field() }}
                            <input type="hidden" value="{{Session::get('wallet')}}" name="wallet" />
                            <input type="hidden" value="{{Request::get('type')}}" name="payment_mode" />
                            <input type="hidden" value="{{Session::get('note')}}" name="note" />
                            <input type="hidden" value="{{Session::get('user_address_id')}}" name="user_address_id" />
                            @if(Setting::get('SCHEDULE_ORDER')==1)
                            <input type="hidden" value="{{Session::get('delivery_date')}}" name="delivery_date" />
                            @endif
                            <input type="hidden" value="{{$card_id}}" name="card_id" />
                            <input type="hidden" value="1" name="payment_mode_again" />
                            <button id="ext_card_pay" class="btn_full pay_now">@lang('home.payment.pay_now')</button>
                        </form>

                    @elseif(Request::get('type')=='braintree')
                        <form action="{{url('orders')}}" id="pay_now_form" method="POST" >
                            {{ csrf_field() }}
                            <input type="hidden" value="{{Session::get('wallet')}}" name="wallet" />
                            <input type="hidden" value="{{Request::get('type')}}" name="payment_mode" />
                            <input type="hidden" value="{{Session::get('note')}}" name="note" />
                            <input type="hidden" value="{{Session::get('user_address_id')}}" name="user_address_id" />
                            @if(Setting::get('SCHEDULE_ORDER')==1)
                            <input type="hidden" value="{{Session::get('delivery_date')}}" name="delivery_date" />
                            @endif
                            <input type="hidden" value="1" name="payment_mode_again" />
                            <button id="ext_card_pay" class="btn_full pay_now" style="display:none;">@lang('home.payment.pay_now')</button>
                        </form>
                    @endif


                @endif
                </div>
                <!-- End box_style_1 -->
            </div>
            <!-- End col-md-6 -->
            <div class="col-md-3" id="sidebar">
                <div class="theiaStickySidebar">
                    <div id="card_box">
                        @if(Request::get('type')=='braintree')
                            @include('user.payment.partial.braintree')
                        @elseif(Request::get('type')=='ripple')
                            <h2 class="ripple_banner">@lang('user.deposit_address')</h2>
                            <div class="payment_select ripple_box">
                            <label id="p1">{{setting::get('RIPPLE_KEY')}}</label>
                                <br/><br/>
                              
                               <span><img src="{{Setting::get('RIPPLE_BARCODE')}}" /></span>
                                <br/><br/><br/>
                                 <button type="button" class="btn btn-default rip_full" onclick="copyToClipboard('#p1')">Copy Address</button>
                                <span class="pcpy" style="display: none;color:green;">Copy Successfully</span>
                            
                        </div>
                        @elseif(Request::get('type')=='ether')
                             <h2 class="ripple_banner">@lang('user.deposit_address')</h2>
                            <div class="payment_select ripple_box">
                            <label id="p1">{{setting::get('ETHER_KEY')}}</label>
                            
                                <br/><br/>
                              
                               <span><img src="{{Setting::get('ETHER_BARCODE')}}" /></span>
                                <br/><br/><br/>
                                <button type="button" class="btn btn-default rip_full" onclick="copyToClipboard('#p1')">Copy Address</button>
                                <span class="pcpy" style="display: none;color:green;">Copy Successfully</span>
                            
                        </div> 
                        @else
                            @include('user.payment.partial.stripe')
                        @endif
                    </div>
                    <!-- End cart_box -->
                </div>
                <!-- End theiaStickySidebar -->
            </div>
            <!-- End col-md-3 -->
        </div>
        <!-- End row -->
    </div>




    <!-- Add Card Modal -->
    <div id="add-card-modal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content" >
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@lang('user.card.add_card')</h4>
          </div>
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
            <button type="submit" class="btn btn-default">@lang('user.card.add_card')</button>
          </div>
        </form>

        </div>

      </div>
    </div>

    

@endsection

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