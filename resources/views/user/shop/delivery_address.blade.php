@extends('user.layouts.app')

@section('content')
 <!-- Content Wrapper Starts -->
        <div class="content-wrapper gray-bg">
            <div class="checkout p-40">
                <div class="container-fluid">
                    <!-- Checkout Left Starts -->
                   
                    
                    <div class="cart-left-outer col-md-8 col-sm-12 col-xs-12">
                        <div class="checkout-left">
                            <!-- Delivery Block Starts -->
                            <div class="checkout-left-block delivery-block">
                                <div class="checkout-left-head row m-0">
                                    <div class="pull-left">
                                        <h4>Delivery Address <i class="ion-checkmark-round check"></i></h4>
                                        <p>Multiple addresses in this location</p>
                                    </div>
                                    <div class="pull-right">
                                        <a href="javascript:void(0);" class="change-link">Change</a>
                                    </div>
                                </div>
                                <div class="checkout-left-content delivery-address row">
                                    
                                    <!-- Address Box Ends -->
                                    <?php $add_type = ['home'=> 'home','work'=> 'work','other'=> 'other'];
                                    $delivery_id =0; ?>
                                    @forelse(Auth::user()->addresses  as $k=>$address)
                                    <?php
                                        $delivery_addr_id = $address->id;
                                        if(in_array($address->type, $add_type)){ 
                                            if($address->type=='other'){
                                            }else{
                                                unset($add_type[$address->type]);
                                            }
                                        }
                                    ?>
                                    <!-- Address Box Starts -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="javascript:void(0);" data-id="{{$address->id}}" class="address-box address-cmn-box row m-0 update_addr">
                                            <div class="address-box-left pull-left">
                                                @if($address->type=='work')
                                                <i class="ion-ios-briefcase-outline address-icon"></i>
                                                @else
                                                <i class="ion-ios-location-outline address-icon"></i>
                                                @endif
                                            </div>
                                            <div class="address-box-right">
                                                <input type="hidden" class="address_id" value="{{$address->id}}" />
                                                <h6 class="address-tit addr-type">{{$address->type}}</h6>
                                                <p class="address-txt addr-map">{{$address->map_address}}</p>
                                                <h6 class="address-delivery-time">{{$Shop->estimated_delivery_time}}Mins</h6>
                                                <button class="address-btn">Delivery Here</button>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- Address Box Ends -->
                                    @empty
                              
                                    @endforelse
                                    <?php //print_r($add_type); ?>
                                    <!-- Address Box Ends -->
                                    <!-- Address Box Starts -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="#" class="address-cmn-box add-new-address row m-0" onclick="$('#location-sidebar').asidebar('open')">
                                            <div class="address-box-left pull-left">
                                                <i class="ion-ios-location-outline address-icon"></i>
                                            </div>
                                            <div class="address-box-right">
                                                <h6 class="address-tit">Add New Address</h6>
                                                <p class="address-txt">{{Session::get('search_loc')}}</p>
                                                <button class="address-btn">Add New</button>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- Address Box Ends -->
                                </div>
                                <div class="selected-address">
                                    <h6 class="address-tit addr_type"></h6>
                                    <p class="address-txt addr_map"></p>
                                    <!-- <input type="hidden" id="user_address_id" name="user_address_id" /> -->
                                    <h6 class="address-delivery-time">40Mins</h6>
                                </div>
                            </div>
                            <!-- Delivery Block Ends -->
                            <!-- Payment Block Starts -->
                            <div class="checkout-left-block payment-block">
                                <div class="payment-block-inner">
                                    <div class="checkout-left-head">
                                        <h4 class="m-0">Payment</h4>
                                    </div>
                                    <div class="payment-content row">
                                        <!-- Payment Left Starts -->
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <div class="payment-content-left">
                                                <ul class="nav nav-tabs payment-tabs" role="tablist">
                                                   
                                                   <li class="active">
                                                        <a href="#cash" aria-controls="card" role="tab" data-toggle="tab" class="payment_mode_type cassh" data-id="cash" ><span><i class="mdi mdi-credit-card"></i></span> Cash</a>
                                                    </li>
                                                    <li>
                                                        <a href="#card" aria-controls="card" role="tab" data-toggle="tab" class="payment_mode_type" data-id="card" ><span><i class="mdi mdi-credit-card"></i></span> Credit &amp; Debit Cards</a>
                                                    </li>
                                                   
                                                    <li>
                                                        <a href="#ripple" aria-controls="ripple" role="tab" data-toggle="tab" class="payment_mode_type" data-id="ripple"><span class="pay-icon"><img src="{{asset('assets/user/img/ripple.png')}}"></span> Ripple</a>
                                                    </li>
                                                    <li>
                                                        <a href="#ethereum" aria-controls="ethereum" role="tab" data-toggle="tab" class="payment_mode_type" data-id="ethereum" ><span class="pay-icon"><img src="{{asset('assets/user/img/eth.png')}}"></span> Ethereum</a>
                                                    </li>
                                                   <!--  <li>
                                                        <a href="#bitcoin" aria-controls="bitcoin" role="tab" data-toggle="tab"><span class="pay-icon"><img src="img/bitcoin.png"></span> Bitcoin</a>
                                                    </li> -->
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Payment Left Ends -->

                                        <!-- Payment Right Starts -->
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <div class="tab-content payment-content-right">
                                              
                                                <!-- Card Tab Starts -->
                                                <div role="tabpanel" class="tab-pane fade in active" id="cash">
                                                    
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="card">
                                                    
                                                    <div class="cards-list">
                                                        <?php $card_id = 0;?>
                                                        @forelse($cards as $card)
                                                        @if(@$card->is_default)
                                                            <?php $card_id = $card->id; ?>
                                                        <!-- Saved Cards Box Starts -->
                                                        <div class="saved-cards-box">
                                                            <!-- Saved Card Box Top Starts -->
                                                            <div class="saved-cards-box-top row m-0">
                                                                <div class="saved-cards-box-left pull-left">
                                                                    <i class="fa fa-cc-visa"></i>
                                                                </div>
                                                                <div class="saved-cards-box-center pull-left">
                                                                    <p class="card-number">XXX XXX XXXX {{$card->last_four}}</p>
                                                                    <!-- <p class="valid">Valid Till 10/2022</p> -->
                                                                </div>
                                                            </div>
                                                            <!-- Saved Card Box Top Ends -->
                                                            <!-- Saved Card Box Bottom Starts -->
                                                            <div class="saved-cards-box-btm">
                                                                 <input type="radio" class="form-control cvv default cardpay"  value="{{$card->id}}"  
                                                                 name="payment_method" id="card_{{$card->id}}"/>
                                                                <label class="pay-btn" for="card_{{$card->id}}"> Pay </label>
                                                            </div>
                                                            <!-- Saved Card Box Bottom Ends -->
                                                        </div>
                                                        <!-- Saved Cards Box Ends -->
                                                        @else
                                                            <div class="saved-cards-box">
                                                            <!-- Saved Card Box Top Starts -->
                                                            <div class="saved-cards-box-top row m-0">
                                                                <div class="saved-cards-box-left pull-left">
                                                                    <i class="fa fa-cc-visa"></i>
                                                                </div>
                                                                <div class="saved-cards-box-center pull-left">
                                                                    <p class="card-number">XXX XXX XXXX {{$card->last_four}}</p>
                                                                    <!-- <p class="valid">Valid Till 10/2022</p> -->
                                                                </div>
                                                            </div>
                                                            <!-- Saved Card Box Top Ends -->
                                                            <!-- Saved Card Box Bottom Starts -->
                                                            <div class="saved-cards-box-btm">
                                                                
                                                                 <input type="radio" class="form-control cvv cardpay" value="{{$card->id}}"  
                                                                 name="payment_method" id="card_{{$card->id}}">
                                                                <label class="pay-btn" for="card_{{$card->id}}"> Pay </label>
                                                            </div>
                                                            <!-- Saved Card Box Bottom Ends -->
                                                        </div>
                                                        @endif
                                                        @empty
                                                        <div>@lang('home.payment.no_card')</div>
                                                        @endforelse
                                                    </div>
                                                     <a href="#" class="add-card-box row m-0" onclick="$('#addcard-sidebar').asidebar('open')">
                                                        <div class="add-card-left pull-left">
                                                            <i class="ion-plus-round address-icon"></i>
                                                        </div>
                                                        <div class="add-card-right">
                                                            <h6 class="address-tit">Add New</h6>
                                                            <p class="address-txt1">20% cashback on 1st &amp; every 3rd txn with Mastercard CC/DC (max Rs.75/txn).TnC</p>
                                                            <button class="address-btn add-new">Add New</button>
                                                        </div>
                                                    </a>
                                                </div>
                                                <!-- Card Tab Ends -->
                                                <!-- Netbanking Tab Starts -->
                                              
                                                <!-- Ripple Tab Starts -->
                                                <div role="tabpanel" class="tab-pane fade" id="ripple">
                                                    <div class="crypto">
                                                        <div class="crypto-head">
                                                            <h5 class="bit-coin-tit">1 Ripple = {{$ripple_response->last}} USD </h5>
                                                            <h6 class="bit-coin-txt">You need to pay <span id="t_xrp">{{53/$ripple_response->last}}</span>Ripple</h6>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Address</label><a href="javascript:void(0);" class="pull-right" onClick="ClipBoard('rip_key');"  >Copy</a> 
                                                            <input type="text" readonly="" id="rip_key" class="form-control" value="{{setting::get('RIPPLE_KEY')}}" name="" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Destination Tag Number</label>  <a href="javascript:void(0);" class="pull-right" onClick="ClipBoard('Destination');"  >Copy</a> 
                                                            <input type="text" readonly="" 
                                                            id="Destination" class="form-control" value="{{$transaction_id}}" name="" required>
                                                        </div>
                                                        <!-- <div class="crypto-img">
                                                            <h6>Scan QR Code</h6>
                                                            <img src="{{Setting::get('RIPPLE_BARCODE')}}">
                                                        </div> -->
                                                        <div class="form-group">
                                                            <label style="color:red">Don`t refresh this page till order complete *</label>
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                           <!--  <label>Note:-</label>
                                                            <small>Please check Your payment Status. Dont Refresh Or Go Back at the time of checking. </small> -->
                                                            <input type="hidden" class="form-control" placeholder="Transaction ID" value="{{$transaction_id}}"  name="payment_id" id="transaction_id_ripple" required>
                                                            <div id ="ripple_form_error" class="ripple_error"></div>
                                                        </div>
                                                        <button type="button" onclick="checkpayment('ripple');" class="confirm-btn">Confirm</button>
                                                    </div>
                                                </div>
                                                <!-- Ripple Tab Ends -->
                                                <!-- Ethereum Tab Starts -->
                                                <div role="tabpanel" class="tab-pane fade" id="ethereum">
                                                    <div class="crypto">
                                                        <div class="crypto-head">
                                                            <h5 class="bit-coin-tit">1 Ethereum = {{$ether_response->result->ethusd}} USD</h5>
                                                            <h6 class="bit-coin-txt">You want pay 20 Ethereum</h6>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <input type="text" readonly="" class="form-control" placeholder="{{Setting::get('ETHER_KEY')}}" name="">
                                                        </div>
                                                        <div class="crypto-img">
                                                            <h6>Scan QR Code</h6>
                                                            <img width=100 src="{{Setting::get('ETHER_BARCODE')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Transaction ID</label>
                                                            <input type="text" name="payment_id" id="transaction_id_eather" class="form-control" placeholder="Transaction ID" name="">
                                                            <div id ="eather_form_error" class="ripple_error"></div>
                                                        </div>
                                                    <button type="button" onclick="checkpayment('eather');"  class="confirm-btn">Confirm</button>
                                                    </div>
                                                </div>
                                                <!-- Ethereum Tab Ends -->
                                                <!-- Bitcoin Tab Starts -->
                                                <div role="tabpanel" class="tab-pane fade" id="bitcoin">
                                                    <div class="crypto">
                                                        <div class="crypto-head">
                                                            <h5 class="bit-coin-tit">1 Bitcoin = $40.00</h5>
                                                            <h6 class="bit-coin-txt">You want pay 20 Bitcoin</h6>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <input type="text" class="form-control" placeholder="1F1tAaz5x1HUXrCNLbtMDqcw6o5GNn4xqX" name="">
                                                        </div>
                                                        <div class="crypto-img">
                                                            <h6>Scan QR Code</h6>
                                                            <!-- <img src="img/barcode.png"> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Transaction ID</label>
                                                            <input type="text" class="form-control" placeholder="Transaction ID" name="">
                                                        </div>
                                                        <button class="confirm-btn">Confirm</button>
                                                    </div>
                                                </div>
                                                <!-- Bitcoin Tab Ends -->
                                            </div>
                                        </div>
                                        <!-- Payment Right Ends -->
                                    </div>
                                </div>
                            </div>
                            <!-- Payment Block Ends -->
                        </div>
                    </div>
                    <!-- Checkout Left Ends -->
                    <!-- Checkout Right Starts -->
                    <div class="cart check-cart cart-main-page col-md-4 col-sm-12 col-xs-12 p-0">
                        <div class="cart-inner">
                            <!-- Cart Head Starts -->
                            @if(count($Cart)>0)
                             <form  action="{{url('orders')}}" id="order_checkout" method="POST">
                                    {{ csrf_field() }}
                            <div class="cart-head">
                                <h4 class="cart-tit">Cart</h4>
                                <p class="cart-txt">from <a href="{{url('/restaurant/details')}}?name={{$Shop->name}}" class="cart-link">{{$Shop->name}}</a></p>
                                <p class="cart-head-txt">{{count($Cart['carts'])}} Items</p>
                            </div>
                            <!-- Cart Head Ends -->
                            <!-- Cart Section Starts -->
                            <div class="cart-section table-responsive">
                                <table class="table table-responsive">
                                    <thead>
                                    </thead>
                                    <tbody>
                                     <?php $tot_gross=0;?>
                                    @forelse($Cart['carts'] as $item)
                                         <?php $tot_gross += $item->quantity*$item->product->prices->price;  ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="row m-0">
                                                     @if($item->product->food_type=='veg')
                                                    <img src="{{asset('assets/user/img/veg.jpg')}}" class="veg-icon">
                                                    @else
                                                    <img src="{{asset('assets/user/img/non-veg.jpg')}}" class="veg-icon">
                                                    @endif
                                                    <div class="food-menu-details">
                                                        <h5>{{$item->product->name}}</h5>
                                                         <input type="hidden" value="{{@$item->product->prices->price}}" name="price" id="product_price_{{$item->product->id}}" />
                                                        @if(count($item->cart_addons)>0)
                                                      <a href="#" class="custom-txt add_to_basket" 
                                                        data-id="{{$item->id}}"
                                                        data-productid="{{$item->product->id}}">Customize <i class="ion-chevron-right"></i></a> 
                                                     
                                                        @endif
                                                    </div>
                                                </div>
                                            </th>
                                            <td>
                                                <button type="button" class="cart-add-btn">
                                                    <div class="numbers-row" data-id="{{$item->id}}" data-pid="{{$item->product->id}}" >
                                                        <input type="number" min="1" data-price="{{$item->product->prices->price}}" readonly="" name="add-quantity" class="add-sec" id="add-quantity_{{$item->id}}" value="{{$item->quantity}}">
                                                    </div>
                                                </button>
                                            </td>
                                            <td class="text-right">
                                                <p class="total_product_{{$item->id}}">{{currencydecimal($item->quantity*$item->product->prices->price)}}</p>
                                            </td>
                                            @forelse($item->cart_addons as $cartaddon)
                                        <?php //print_r($cartaddon); ?>
                                            <input type="hidden" value="{{$cartaddon->quantity}}" id="cart_addon_{{$cartaddon->user_cart_id}}_{{$cartaddon->addon_product_id}}" />
                                            <?php $tot_gross += $item->quantity*$cartaddon->quantity*$cartaddon->addon_product->price;  ?>
                                           
                                        @empty
                                             
                                        @endforelse
                                        </tr>
                                        @empty
                                        <tr><td colspan="2">Empty Cart!</td></tr>
                                        @endforelse
                                       
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Item Total</td>
                                            <td></td>
                                            <td class="text-right sub-total">{{currencydecimal($tot_gross)}}</td>
                                            <input type="hidden" id="total_price" value="{{$tot_gross}}"/>
                                            <input type="hidden" id="total_addons_price" value="0"/>
                                            <input type="hidden" id="total_product_price" value="{{$tot_gross}}"/>
                                        </tr>
                                        <tr>
                                            <td> Discount</td>
                                            <td></td>
                                            <td class="text-right">
                                                <?php
                                                    $discount=0;
                                                    $net = $tot_gross;
                                                    if($Shop->offer_percent){
                                                        if($tot_gross > $Shop->offer_min_amount){
                                                           //$discount = roundPrice(($tot_gross*($Shop->offer_percent/100)));
                                                           $discount = number_format(($tot_gross*($Shop->offer_percent/100)),2,'.','');
                                                           //if()
                                                           $net = $tot_gross - $discount;
                                                        }
                                                    }
                                                 ?>
                                               -{{currencydecimal($discount)}}
                                            </td>
                                        </tr>
                                        <?php
                                                    $discount=0;
                                                    $tax = number_format($net*(Setting::get('tax')/100),2,'.','');
                                                    $net =$net+$tax+Setting::get('delivery_charge');
                                                 ?>
                                        <tr>
                                            <td>Tax({{Setting::get('tax')}}%)</td>
                                            <td></td>
                                            <td class="text-right to_tax">{{currencydecimal($tax)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Charges</td>
                                            <td></td>
                                            <td class="text-right">{{currencydecimal(Setting::get('delivery_charge'))}}</td>
                                        </tr>
                                        <tr>
                                            <th>To Pay</th>
                                            <th></th>
                                            <th class="text-right to_pay">{{currencydecimal(roundPrice($net))}}</th>
                                             <input type="hidden" name="amount" id="total_amount_pay" value="{{roundPrice($net)}}" />
                                             <input type="hidden" name="ripple_price" id="ripple_price" value="0" />
                                             <input type="hidden" id="user_address_id" name="user_address_id" value="" />
                                             <input type="hidden" id="total_payment_mode" value="{{Setting::get('payment_mode')}}" name="payment_mode" />
                                            <input type="hidden" id="card_id" value="" name="card_id" />
                                            <input type="hidden" id="promocode_id" value="" name="promocode_id" />
                                            <input type="hidden" id="total_transaction_id" name="payment_id" />
                                            <input type="hidden" id="DestinationTag" name="DestinationTag" />
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row m-0" style="display: none">
                                <div class="coupon-left pull-left">
                                        <input type="radio"  name="payment_mode_type" class="payment_mode_type cash" value="cash"  ><label for="cash">Cash</label>
                                    </div>
                                    <div class="coupon-right pull-right">
                                         <input type="radio" name="payment_mode_type" class="payment_mode_type card" value="card"  ><label for="card">Card</label>
                                    </div>
                                </div>
                            <a href="#" class="coupon" onclick="$('#coupon-sidebar').asidebar('open')">
                                <div class="row m-0">
                                    <div class="coupon-left pull-left">
                                        Have a coupon code?
                                    </div>
                                    <div class="coupon-right pull-right">
                                        Apply Coupon
                                    </div>
                                </div>
                            </a>
                            <button  type="submit" disabled="true" class="checkout-btn cart-main-btn  btn_checkout">Proceed to Pay</button>
                            <div class="row m-0">
                            <div class="alert alert-danger chkouterrors" style="display: none">
                            </div>
                            </div>
                            <!-- Cart Section Ends -->

                        </form>
                        @else

                        @endif

                        </div>
                    </div>
                    <!-- Checkout Right Ends -->
                    
                </div>
            </div>
        </div>
        <!-- Content Wrapper Ends -->
    </div>
    <!-- Main Warapper Ends -->
  
    <!-- Location Sidebar Ends -->
    <!-- Coupon Sidebar Starts -->
    <div class="aside right-aside coupon-sidebar" id="coupon-sidebar">
        <div class="aside-header">
            <span class="close" data-dismiss="aside"><i class="ion-close-round"></i></span>
            <h5 class="aside-tit">Coupons</h5>
        </div>
        <div class="aside-contents">
            <form class="common-form">
                <div class="input-group">
                    <input type="text" class="form-control" id="couponcode_apply" value="" placeholder="Enter Coupon" /*readonly*/>
                    <a href="javascript:void(0);" class="input-group-addon appcupon_apply">Apply</a>
                </div>
                <div class="input-group">
                    <span class="success message" ></span>
                </div>
            </form>
            <!-- Coupons List Starts -->
            <div class="coupons-list">
                <h6 class="avail-coupon-tit">OR USE AVAILABLE COUPONS</h6>
                <!-- Coupon Box Starts -->
                @forelse($Promocodes as $Promocode)
                    @if($Promocode->pusage == null)
                <div class="coupon-box">
                    <p class="coupon-name">{{$Promocode->promo_code}}</p>
                   <!--  <p class="coupon-txt">Pay via Visa Signature Cards &amp; get additional 10x Reward Points on every  $150 spent. Use Code KIU10X</p> -->
                    <div class="coupon-details">
                        <div class="coupon-det-box row m-0">
                            <div class="col-xs-6 p-l-0">
                                <p class="coupon-det-txt coupon-det-txt1"><!-- Min cart amount --></p>
                            </div>
                            <div class="col-xs-6 p-l-0">
                                <p class="coupon-det-txt coupon-det-txt2">{{currencydecimal($Promocode->discount)}}</p>
                            </div>
                        </div>
                        <div class="coupon-det-box row m-0">
                            <div class="col-xs-6 p-l-0">
                                <p class="coupon-det-txt coupon-det-txt1">Valid till</p>
                            </div>
                            <div class="col-xs-6 p-l-0">
                                <p class="coupon-det-txt coupon-det-txt2">Expires in {{date('d-m-Y',strtotime($Promocode->expiration))}}</p>
                            </div>
                        </div>
                       <!--  <div class="coupon-det-box row m-0">
                            <div class="col-xs-6 p-l-0">
                                <p class="coupon-det-txt coupon-det-txt1">Payment method</p>
                            </div>
                            <div class="col-xs-6 p-l-0">
                                <p class="coupon-det-txt coupon-det-txt2">Wallet</p>
                            </div>
                        </div> -->
                    </div>
                    <a href="javascript:void(0)" data-id="{{$Promocode->id}}" data-code="{{$Promocode->promo_code}}" data-price="{{$Promocode->discount}}" class="apply-coupon  appcupon">Apply Coupon</a>
                </div>
                    @endif
                @empty

                @endforelse 
                <!-- Coupon Box Ends -->
                
            </div>
            <!-- Coupons List Ends -->
        </div>
    </div>
    <!-- Coupon Sidebar Ends -->
    <!-- Add Card Starts -->
    <div class="aside right-aside location" id="addcard-sidebar">
        <div class="aside-header">
            <span class="close" data-dismiss="aside"><i class="ion-close-round"></i></span>
            <h5 class="aside-tit">Enter your card details</h5>
        </div>
        <div class="aside-contents">
            <!-- Login Content Starts -->
            <div class="login-content">
                @if(Setting::get('payment_mode')=='braintree')
                    @include('user.payment.partial.braintree')
                @else
                    @include('user.payment.partial.stripe')
                @endif
            </div>
            <!-- Login Content Ends -->
        </div>
    </div>
    <!-- Add Card Ends -->
    <!-- Custom Modal Starts-->
    <div class="modal fade" id="cart-custom-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{Auth::guest()?url('mycart'):url('addcart')}}" method="POST">           
                    {{csrf_field()}}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="ion-close-round"></span>
                        </button>
                        <div>
                            <div class="row m-0">
                                <img src="{{asset('assets/user/img/veg.jpg')}}" class="veg-icon">
                                <div class="food-menu-details custom-head-details">
                                    <h5 class="p_name"></h5>
                                    <p class="p_price"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <!-- Custom Head Starts -->
                       
                        <!-- Custom Head Ends -->
                        <!-- Cusom Content Starts -->
                        <div class="custom-content">
                            <!-- Custom Section Starts -->
                            
                            <!-- Custom Section Ends -->
                            <!-- Custom Section Starts -->
                            <div class="custom-section" id="custom-add-ons">
                                <h5 class="custom-block-tit">Addons <span class="optional">(Optional)</span></h5>
                                <div id="addon_list">
                                        
                                </div>
                                <!-- Custom Block Starts -->
                                
                            </div>
                            <!-- Custom Section Ends -->
                        
                        <!-- Custom Content Ends -->
                        <!-- Custom Section Starts -->
                            <div class="custom-section" id="custom-text-field">
                                <h5 class="custom-block-tit">Note</h5>
                                <textarea class="form-control" name="note" rows="3"></textarea>
                            </div>
                            <!-- Custom Section Ends -->
                            </div>
                    </div>
                    <div class="modal-footer">
                        
                        
                        <div class="">
                            <button class="total-btn row m-0">
                                <span class="pull-left t_price">Total </span>
                                <span class="pull-right">ADD ITEM</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Custom Modal Ends -->
     <!-- Cart Custom Modal Starts-->
    
    <div class="aside-backdrop"></div>
@endsection
@section('deliveryscripts')
<script type="text/javascript">
$('.payment_mode_type').on('click',function(){
    var ctype = $(this).data('id');
    var addrs = $('#user_address_id').val();
    var card_id = $('#card_id').val();
    var p_mode = $('#total_payment_mode').val();
    if(ctype=='card'){
        if(addrs!='' && card_id!=''){
            $('#total_payment_mode').val("{{Setting::get('payment_mode')}}");
            $('.btn_checkout').prop('disabled',false);
            $('.chkouterrors').hide();
            $('.chkouterrors').html('');
        }else{
            
            $(this).prop('checked',false);
            $('.btn_checkout').prop('disabled',true);
            if(addrs ==''){
                $('.chkouterrors').removeClass('alert-success');
                $('.chkouterrors').addClass('alert-danger');
                $('.chkouterrors').show();
                $('.chkouterrors').html('please select address first');
            }
            if(card_id ==''){
                $('.chkouterrors').removeClass('alert-danger');
                $('.chkouterrors').addClass('alert-success');
                $('.chkouterrors').show();
                $('.chkouterrors').html('please select one card or add new card');
            }
        }
    }
    if(ctype=='cash'){
        if(addrs!=''){
            $('#total_payment_mode').val("");
            $('#card_id').val("");
            $('.cardpay').prop('checked',false); 
            $('.btn_checkout').prop('disabled',false);
            $('.chkouterrors').hide();
            $('.chkouterrors').html('');
        }else{
            $(this).prop('checked',false);
            $('.btn_checkout').prop('disabled',true);
            $('.chkouterrors').removeClass('alert-success');
            $('.chkouterrors').addClass('alert-danger');
            $('.chkouterrors').show();
            $('.chkouterrors').html('please select address first');
        }
    }
    if(ctype=='ripple'){ 
        $('.btn_checkout').prop('disabled',true);
        if(addrs!=''){
            $('#total_payment_mode').val("ripple");
            $('#card_id').val("");
            var total_amount = $('#total_amount_pay').val();
            var now_1_xrp_usd = "{{$ripple_response->last}}";

            var total_ripple = parseFloat(total_amount/now_1_xrp_usd);
            //alert(total_ripple);
            $('#t_xrp').html(total_ripple.toFixed(5));
            //$('.cardpay').prop('checked',false); 
            //$('.btn_checkout').prop('disabled',false);
            $('.chkouterrors').hide();
            $('.chkouterrors').html('');
        }else{
            $(this).prop('checked',false);
            $('.btn_checkout').prop('disabled',true);
            //$('.chkouterrors').removeClass('alert-success');
            $('.chkouterrors').addClass('alert-danger');
            $('.chkouterrors').show();
            $('.chkouterrors').html('please select address first');
        }
    }
})

$('.add_to_basket').click(function(){ 
    var product_id = $(this).data('productid'); 
    var quantity = $('#product_price_'+product_id).val(); 
    var addons = '';
    var cart_id = $(this).data('id'); 
    var qty = 1;
    addons = '';
    if(cart_id){
        qty = $('#add-quantity_'+cart_id).val();
         addons +=' <input type="hidden" value="'+cart_id+'" name="cart_id" >';
    }
    $.ajax({
        url: "{{url('/addons/')}}/"+product_id,
        type:'GET',
        success: function(data) { 
            
             var p_price = qty*data.prices.price;
            
             addons +=' <input type="hidden" value="'+data.shop_id+'" name="shop_id" >\
                        <input type="hidden" value="'+data.id+'" name="product_id" >\
                        <input type="hidden" value="'+qty+'" name="quantity" class="form-control" placeholder="Enter Quantity" min="1" max="100">\
                        <input type="hidden" value="'+data.name+'" name="name" >\
                        <input type="hidden" value="'+data.prices.price+'" name="price" />';
            $.each( data.addons , function( key, value ) { 
                var chk='';
                if(cart_id){
                    if($('#cart_addon_'+cart_id+'_'+value.id).val()){
                        p_price = p_price+value.price;
                        chk = "checked";
                    }
                }
               addons+='<div class="custom-block">\
                                <div class="row m-0">\
                                    <img src="{{asset('assets/user/img/veg.jpg')}}" class="veg-icon">\
                                    <div class="food-menu-details custom-details">\
                                        <div class="form-check">\
                                            <input class="form-check-input chkaddon" '+chk+' type="checkbox" name="product_addons['+value.id+']" value="'+value.id+'" id="addons-'+value.id+'"  data-price="'+value.price+'">\
                                            <label class="form-check-label" for="addons-"'+value.id+'">'+value.addon.name+'({{Setting::get('currency')}}'+value.price.toFixed(2)+')</label>\
                                             <input type="hidden" value="1" class=" input-number" name="addons_qty['+value.id+']"  />\
                            <input type="hidden" name="addons_price['+value.id+']" value="'+value.price+'" />\
                             <input type="hidden" name="addons_name['+value.id+']" value="'+value.addon.name+'" />\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>';
                
            });
            addons+='<input type="hidden" id="t_price" value="'+p_price+'"  >';
            $('.p_name').html(data.name);
            $('.p_price').html("{{Setting::get('currency')}}"+p_price.toFixed(2));
            $('.t_price').html("Total {{Setting::get('currency')}}"+p_price.toFixed(2));
             /*addons+='<div class="row">\
                        <div class="col-md-4">\
                            <label>Note</label>\
                            </div>\
                            <div class="col-md-8">\
                            <textarea id="fullfilled" class="form-control counted" name="note" placeholder="Write Something" rows="5" style="margin-bottom:10px;" >\
                            </textarea>\
                        </div>\
                    </div>';*/
            $('#addon_list').html(addons);
            $.each( data.addons , function( key, value ) {

            });
            $('#cart-custom-modal').modal('show');
        },
        error:function(jqXhr,status){ 
            if( jqXhr.status === 422 ) {
                $(".print-error-msg").show();
                var errors = jqXhr.responseJSON; 

                $.each( errors , function( key, value ) { 
                    $(".print-error-msg").find("ul").append('<li>'+value[0]+'</li>');
                });
            } 
        }
    });
    
})
$('.cardpay').on('click',function(){
    var id = $(this).val(); 
    $('#card_id').val(id);
    $('#total_payment_mode').val("stripe");
    $('.payment_mode_type.card').prop('checked',true);
    $('.btn_checkout').prop('disabled',false);
    $('.chkouterrors').hide();
    $('.chkouterrors').html('');
})
$(document).on('click','.chkaddon',function(){
    var price = $(this).data('price');
    if($(this).is(':checked')){
    var total_price = parseFloat($('#t_price').val()) + parseFloat(price);
    }else{
       var total_price = parseFloat($('#t_price').val()) - parseFloat(price); 
    }
    $('#t_price').val(total_price);
    $('.t_price').html('Total {{Setting::get("currency")}}'+total_price);
});

  $('.update_addr').on('click',function(){
   $('.addr_map').html($(this).children().find('.addr-map').text());
   $('.addr_type').html($(this).children().find('.addr-type').text());
   $('#user_address_id').val($(this).children().find('.address_id').val());
  })  

$(document).ready(function() {    
$(document).on('click','.inc',function(e){
    e.preventDefault();
    var id = $(this).parent().attr('data-id');  
    var pid = $(this).parent().attr('data-pid');  
    var input = $("input[id='add-quantity_"+id+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        product_price_calculation(id,'plus');
        changeCart(id,pid,currentVal);
    } else {
        input.val(0);
    }
});
$(document).on('click','.dec',function(e){
    e.preventDefault();
    var id = $(this).parent().attr('data-id'); 
    var pid = $(this).parent().attr('data-pid');  
    var input = $("input[id='add-quantity_"+id+"']");
    var currentVal = parseInt(input.val()); 
    if (!isNaN(currentVal)) {
        if(currentVal==0){ 
            changeCart(id,pid,currentVal);
        }else{
        product_price_calculation(id,'minus'); 
        changeCart(id,pid,currentVal);  
        }
    } else { 
        input.val(0);
    }
});

  function product_price_calculation(val,type){

    if(type == 'plus'){
      var qty = $('#add-quantity_'+val).val();

      var price = $('#add-quantity_'+val).data('price');
      var tot_amt = qty*price;
      $('.total_product_'+val).html("{{Setting::get('currency')}}"+tot_amt.toFixed(2));
      ///
      var total = parseInt(price)+parseInt($('#total_price').val());
      
      var total_product_price = parseInt($('#total_product_price').val())+parseInt(price);
      $('#total_product_price').val(total_product_price);
      var total_addons_price = $('#total_addons_price').val();
      total = parseInt(total_product_price)+qty*parseInt(total_addons_price);
      $('#total_price').val(total); 
      $('.sub-total').html("{{Setting::get('currency')}}"+total.toFixed(2));
    }else{
      var qty = $('#add-quantity_'+val).val();

      var price = $('#add-quantity_'+val).data('price');
      var tot_amt = qty*price;
      $('.total_product_'+val).html("{{Setting::get('currency')}}"+tot_amt.toFixed(2));
      ///
      var total = parseInt(price)+parseInt($('#total_price').val());
      
      var total_product_price = parseInt($('#total_product_price').val())-parseInt(price);
      $('#total_product_price').val(total_product_price);
      var total_addons_price = $('#total_addons_price').val();
      total = parseInt(total_product_price)+qty*parseInt(total_addons_price);
      $('#total_price').val(total); 
      $('.sub-total').html("{{Setting::get('currency')}}"+total.toFixed(2));
    }
}
});
function changeCart(id,pid,qty){
    $.ajax({
        url: "{{url('addcart')}}",
        type:'POST',
        data:{'cart_id':id,'quantity':qty,'_token':"{{csrf_token()}}",'product_id':pid},
        success: function(res) { 
            if(qty==0){
            location.href = "{{url('restaurant/details?name='.$Shop->name)}}";
            }else{
                var net = parseInt($('#total_product_price').val()); 
               var tax = (net*({{Setting::get('tax')}}/100)).toFixed(2);
             var net_total = parseInt(net)+parseInt(tax)+parseInt({{Setting::get('delivery_charge')}}); 
             $('.to_pay').html("{{Setting::get('currency')}}"+net_total.toFixed(2));
             $('.to_tax').html("{{Setting::get('currency')}}"+tax);
            }
        },
        error:function(jqXhr,status){ 
            if( jqXhr.status === 422 ) {
                $(".print-error-msg").show();
                var errors = jqXhr.responseJSON; 

                $.each( errors , function( key, value ) { 
                    $(".print-error-msg").find("ul").append('<li>'+value[0]+'</li>');
                });
            } 
        }
    });
}
var error = 0;
function checkpayment(type){ 
    if($('#transaction_id+'+type).val() == ''){
        return false;
    }
    var myVar ;
      
        if(type=='eather'){
            var url = "{{url('checkEtherPayment')}}";
            var amount = (parseFloat($('#total_amount_pay').val())/{{$ether_response->result->ethusd}}).toFixed(6); 
        }
        if(type=='ripple'){
            var url = "{{url('checkRipplePayment')}}";
            var amount = (parseFloat($('#total_amount_pay').val())/{{$ripple_response->last}}).toFixed(6); 
        }
        if(type=='bitcoin'){
            var url = "{{url('checkBitcoinPayment')}}";
        }
    $.ajax({
      url: "https://data.ripple.com/v2/accounts/{{Setting::get('RIPPLE_KEY')}}/transactions?type=Payment&result=tesSUCCESS&limit=10",
      type: "GET",
      //data:{'payment_id':$('#transaction_id_'+type).val(),'amount':amount}
        })
      .done(function(response){ 
            console.log(response);
            var transa =1;
            var amount_ripple = $('#t_xrp').html();
            if((response.transactions).length > 0){

                $.each(response.transactions ,function(index,value){
                    
                    if(value.tx.DestinationTag == $('#transaction_id_'+type).val()){
                       transa =0;
                       console.log(value.tx.Amount/1000000 +'---'+ amount_ripple+'--'+parseFloat(amount_ripple - (value.tx.Amount/1000000)));
                       if(parseFloat(amount_ripple - (value.tx.Amount/1000000)) < 2){
                            $('#total_transaction_id').val(value.hash);
                            $('#DestinationTag').val(value.tx.DestinationTag);
                            $('#ripple_price').val(amount_ripple);
                            $("#"+type+"_form_error").html('Sucesss please proceed to Order');
                            $('.btn_checkout').prop('disabled',false);
                            $('#loader').hide();
                            $('#ripple_ord_btn').prop('disabled',false);
                            //$('#total_transaction_id').val($('#transaction_id_'+type).val());
                            //$('#total_payment_mode').val(type);
                            $('.default').prop('checked',false);
                        }else{
                            $("#"+type+"_form_error").html('Paid amount is less than the order amount. Please Repayment or contact with admin.');
                        }
                    }
                    

                });

                if(transa==1){
                    $('#loader').show();
                    $('#ord_btn').prop('disabled',true);
                    $("#"+type+"_form_error").html('Please Retry your Transaction is not found!');
                    //myVar = setTimeout(checkpayment('ripple'), 5000);
                }
                
            }
            else{
                $('#loader').show();
                $('#ord_btn').prop('disabled',true);
                $("#"+type+"_form_error").html('Please wait until your Transaction is Processing...');
                myVar = setTimeout(checkpayment('ripple'), 5000);
            }
            
        })
    .error(function(jqXhr,status){
        if(jqXhr.status === 422) {
            error =1;
            $("#ripple_form_error").html('');
            $("#ripple_form_error ").show();
            var errors = jqXhr.responseJSON;
            console.log(errors);
            $.each( errors , function( key, value ) { 
                $("#ripple_form_error").html(value);
            }); 
        } 
    
        $('#ord_btn').prop('disabled',true);
    })

    
}

function ClipBoard(id)
{
    var copyText = document.getElementById(id);

  /* Select the text field */
  copyText.select();

  /* Copy the text inside the text field */
  document.execCommand("Copy");
}


$('.appcupon').click(function(){
    var code = $(this).data('code');
    var id = $(this).data('id');
    var price = $(this).data('price');
    $('#couponcode_apply').val(code);
    //$('#promocode_id').val(id);
    $('#couponcode_apply').data('price',price);
    $('#couponcode_apply').data('id',id);
})

$('.appcupon_apply').click(function(){
    if($('#couponcode_apply').val()!=''){
        var promocode_id = $('#couponcode_apply').data('id');
        var couponcode_apply = $('#couponcode_apply').val();
        $.ajax({
            url: "{{url('wallet/promocode')}}",
            type: "POST",
            data:{'promocode_id':promocode_id,'couponcode':couponcode_apply,'_token':"{{csrf_token()}}"}
                })
            .done(function(response){ 
                $('#promocode_id').val(promocode_id);
                 var price = $('#couponcode_apply').data('price');
                 
                 var tot_blnce = (parseFloat($('#total_amount_pay').val())-price);
                 
                $('#total_amount_pay').val(tot_blnce);
                $('.to_pay').html(tot_blnce.toFixed(2))
                $('.message').html('Couponcode Added Successfully');
            })
            .error(function(jqXhr,status){
                if(jqXhr.status === 422) {
                    error =1;
                   /* $("#ripple_form_error").html('');
                    $("#ripple_form_error ").show();*/
                    var errors = jqXhr.responseJSON;
                    console.log(errors);
                    $.each( errors , function( key, value ) { 
                         $('.message').html(value);
                    }); 
                } 
            
                $('#ord_btn').prop('disabled',true);
            });
    }else{
        $('.message').html('Please Select Any Coupon Code');
    }
    
})

/*setTimeout(function(){ 
        if(error ==0){
            checkpayment('');
        }
    }, 5000);*/
    </script>
@endsection