@extends('user.layouts.app')

@section('title', 'Payment')

@section('content')
  <!-- Content ================================================== -->
    <div class="container margin_60_35">
        <div class="row">
             @include('include.alerts')
        <form id="payment-form" action="{{ url('wallet') }}" method="POST" >
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
                    <h2 class="inner">@lang('user.payment_method')</h2>
                    <?php $card_id = 0;?>
                    @forelse($cards as $card)
                     @if(@$card->is_default)
                        <?php $card_id = $card->id; ?>
                        <div class="payment_select">
                            <label>
                                <input type="radio" value="{{$card->id}}" checked name="card_id" class="icheck mycard">XXX XXX XXXX {{$card->last_four}}</label>
                                
                                
                            @if($card->brand=='Visa')
                                <img src="{{asset('assets/user/img/visa.png')}}" alt="" data-retina="true" class="" style="float: right;">
                            @elseif($card->brand == 'mastercard')
                            <img src="{{asset('assets/user/img/master.png')}}" alt="" data-retina="true" class="" style="float: right;">
                            @endif
                        </div>
                    @else
                         <div class="payment_select">
                            <label>
                                <input type="radio" value="{{$card->id}}"  name="card_id" class="icheck mycard">XXX XXX XXXX {{$card->last_four}}</label>
                               
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
                    
                </div>
                <!-- End box_style_1 -->
            </div>
            <!-- End col-md-6 -->
            <div class="col-md-3" id="sidebar">
                <div class="form-group col-md-12 col-sm-12">
                            
                                        <!-- <input  required type="number" class="form-control" value="{{Auth::user()->wallet_balance}}" readonly> -->

                               <button class="btn btn-success wallet-button" <a href="{{url('/wallet')}}">@lang('menu.user.wallet_amount')  


                                    {{currencydecimal(Auth::user()->wallet_balance)}}</a></button>
                                        
                                    </div>
            </div>
            <div class="col-md-3" id="sidebar">
                <div class="theiaStickySidebar">
                    <div id="card_box">
                        
                                        {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="row no-margin" id="card-payment">
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label>@lang('user.card.price')</label>
                                        <input  required type="number" class="form-control" name="amount" placeholder="@lang('user.card.price')">
                                        
                                    </div>
                                   
                                </div>
                            </div>

                          <div class="modal-footer">
                            <button type="submit" class="btn btn-default">@lang('user.card.add')</button>
                          </div>
                        
                    </div>
                    <!-- End cart_box -->
                </div>
                <!-- End theiaStickySidebar -->
            </div>
            <!-- End col-md-3 -->
        </form>
        </div>
        <!-- End row -->
    </div>




 
    

@endsection

@section('scripts')
   

    <script type="text/javascript">
        
                
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

        $('input[name=payment_method]').on('change',function(){

           
                $('#card_id').val($(this).val());
            
        })
    </script>
@endsection