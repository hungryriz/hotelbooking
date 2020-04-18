@extends('user.layouts.app')

@section('content')
<?php //dd($Orders); ?>
  <!-- Content Wrapper Starts -->
        <div class="content-wrapper">
            <div class="profile blue-bg">
                <!-- Profile Head Starts -->
                 @include('user.layouts.partials.user_common')
                <!-- Profile Head Ends -->
                <!-- Profile Content Starts -->
                <div class="profile-content">
                    <div class="container-fluid">
                        <!-- Profile Inner Starts -->
                        <div class="profile-inner row">
                            <!-- Profile Left Starts -->
                            @include('user.layouts.partials.sidebar')
                            <!-- Profile Left Ends -->
                            <!-- Profile Right Starts -->
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="profile-right">
                                    <!-- Profile Right Head Starts -->
                                    <div class="profile-right-head">
                                        <h4>Payments</h4>
                                    </div>
                                    <!-- Profile Right Head Ends -->
                                    <div class="profile-right-content payments-section">
                                        <!-- Wallet Money Starts -->
                                        <div class="wallet-money row">
                                            <div class="col-md-6">
                                                <div class="wallet-money-inner row m-0">
                                                    <div class="foodie-money pull-left">
                                                        <span>Foodie Money : 0</span>
                                                    </div>
                                                    <div class="statement pull-right">
                                                        <a href="#statement-modal" class="theme-link state-link" data-toggle="modal" data-target="#statement-modal">View Statement</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Wallet Money Ends -->
                                        <!-- Saved Cards Starts -->
                                        <div class="saved-cards">
                                            <h6>Saved Cards</h6>
                                            <div class="saved-cards-block row">
                                                <!-- Saved Cards Box Starts -->
                                                <div class="col-md-6">
                                                    <div class="saved-cards-box row m-0">
                                                        <div class="saved-cards-box-left pull-left">
                                                            <i class="fa fa-cc-visa"></i>
                                                        </div>
                                                        <div class="saved-cards-box-center pull-left">
                                                            <p class="card-number">8799 XXXXXXXX 9807</p>
                                                            <p class="valid">Valid Till 10/2022</p>
                                                        </div>
                                                        <div class="saved-cards-box-right pull-right">
                                                            <a href="#" class="card-delete theme-link" data-toggle="modal" data-target="#delete-modal">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Saved Cards Box Ends -->
                                                <!-- Saved Cards Box Starts -->
                                                <div class="col-md-6">
                                                    <div class="saved-cards-box row m-0">
                                                        <div class="saved-cards-box-left pull-left">
                                                            <i class="fa fa-cc-mastercard"></i>
                                                        </div>
                                                        <div class="saved-cards-box-center pull-left">
                                                            <p class="card-number">8799 XXXXXXXX 9807</p>
                                                            <p class="valid">Valid Till 10/2022</p>
                                                        </div>
                                                        <div class="saved-cards-box-right pull-right">
                                                            <a href="#" class="card-delete theme-link" data-toggle="modal" data-target="#delete-modal">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Saved Cards Box Ends -->
                                                <!-- Saved Cards Box Starts -->
                                                <div class="col-md-6">
                                                    <div class="saved-cards-box row m-0">
                                                        <div class="saved-cards-box-left pull-left">
                                                            <i class="fa fa-cc-mastercard"></i>
                                                        </div>
                                                        <div class="saved-cards-box-center pull-left">
                                                            <p class="card-number">8799 XXXXXXXX 9807</p>
                                                            <p class="valid">Valid Till 10/2022</p>
                                                        </div>
                                                        <div class="saved-cards-box-right pull-right">
                                                            <a href="#" class="card-delete theme-link" data-toggle="modal" data-target="#delete-modal">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Saved Cards Box Ends -->
                                            </div>
                                        </div>
                                        <!-- Saved Cards Ends -->
                                        <!-- Saved Cards Starts -->
                                        <div class="saved-cards">
                                            <h6>Linked Wallets</h6>
                                            <div class="saved-cards-block row">
                                                <!-- Saved Cards Box Starts -->
                                                <div class="col-md-6">
                                                    <div class="saved-cards-box row m-0">
                                                        <div class="saved-cards-box-left pull-left">
                                                            <div class="wallet-img bg-img" style="background-image: url(img/paypal.png);"></div>
                                                            <!-- <img src="img/paypal.png" class="wallet-img"> -->
                                                        </div>
                                                        <div class="saved-cards-box-center pull-left">
                                                            <p class="card-number">Paypal</p>
                                                            <p class="valid">Balance: $2304.289</p>
                                                        </div>
                                                        <div class="saved-cards-box-right pull-right">
                                                            <a href="#" class="card-delete theme-link" data-toggle="modal" data-target="#delete-modal">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Saved Cards Box Ends -->
                                                <!-- Saved Cards Box Starts -->
                                                <div class="col-md-6">
                                                    <div class="saved-cards-box row m-0">
                                                        <div class="saved-cards-box-left pull-left">
                                                            <div class="wallet-img bg-img" style="background-image: url(img/bitcoin-logo.png);"></div>
                                                        </div>
                                                        <div class="saved-cards-box-center pull-left">
                                                            <p class="card-number">XXX XXX XXXX {{$card->last_four}}</p>
                                                            <p class="valid">Balance: $2304.289</p>
                                                        </div>
                                                        <div class="saved-cards-box-right pull-right">
                                                            <a href="#" class="card-delete theme-link" data-toggle="modal" data-target="#delete-modal">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Saved Cards Box Ends -->
                                                <!-- Saved Cards Box Starts -->
                                                <div class="col-md-6">
                                                    <div class="saved-cards-box row m-0">
                                                        <div class="saved-cards-box-left pull-left">
                                                            <div class="wallet-img bg-img" style="background-image: url(img/ripple-logo.png);"></div>
                                                        </div>
                                                        <div class="saved-cards-box-center pull-left">
                                                            <p class="card-number">XXX XXX XXXX {{$card->last_four}}</p>
                                                            <p class="valid">Balance: $2304.289</p>
                                                        </div>
                                                        <div class="saved-cards-box-right pull-right">
                                                            <a href="#" class="card-delete theme-link" data-toggle="modal" data-target="#delete-modal">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Saved Cards Box Ends -->
                                            </div>
                                        </div>
                                        <!-- Saved Cards Ends -->
                                    </div>
                                </div>
                            </div>
                            <!-- Profile Right Ends -->
                        </div>
                        <!-- Profile Inner Ends -->
                    </div>
                </div>
                <!-- Profile Content Ends -->
            </div>
        </div>
        <!-- Content Wrapper Ends -->
        
@endsection
@section('scripts')
<script type="text/javascript" >
 $('.itemlist').on('click',function(){
        var id = $(this).data('id');
         $.ajax({
                url: "{{url('orders')}}/"+id,
                type:'GET',
                success: function(data) { 
                    var item_list="";
                    if($.isEmptyObject(data.error)){
                        $.each( data.items, function( key, value ) {
                        item_list +="<tr>\
                                <td class='text-left'>\
                                    <figure class='thumb_menu_list'><img src='"+value.product.images[0].url+"' alt='thumb'></figure>\
                                    <h5>"+value.product.name+"</h5>\
                                    <p>"+value.product.description+"</p>\
                                </td>\
                                <td>"+value.quantity+"</td>\
                                <td>\
                                    <strong>{{Setting::get('currency')}} "+value.product.prices.price.toFixed(2)+"</strong>\
                                </td>\
                                <td>\
                                    <p>{{Setting::get('currency')}} "+(value.product.prices.price*value.quantity).toFixed(2)+"</p>\
                                </td>\
                            </tr>";
                                 $.each(value.cart_addons, function( key, valuee ) { console.log(valuee.quantity);
                                        item_list +="<tr>\
                                        <td class='text-left'>\
                                            <figure class='thumb_menu_list'><img src='{{asset("assets/user/img/menu-thumb-15.jpg")}}' alt='thumb'></figure>\
                                            <h5>"+valuee.addon_product.addon.name+"</h5>\
                                            <p>(Addons)</p>\
                                        </td>\
                                        <td>"+value.quantity+"X"+valuee.quantity+"</td>\
                                        <td>\
                                            <strong>{{Setting::get('currency')}} "+valuee.addon_product.price.toFixed(2)+"</strong>\
                                        </td>\
                                        <td>\
                                            <p>{{Setting::get('currency')}} "+(value.quantity*valuee.addon_product.price*valuee.quantity).toFixed(2)+"</p>\
                                        </td>\
                                    </tr>";  
                                });


                        });
                        $('.item_list').html(item_list);
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
        $('#product-list').modal('show');
    });
</script>
<script src=https://cdn.pubnub.com/sdk/javascript/pubnub.4.0.11.min.js></script>
 @forelse($Orders as $Index => $Order)
<?php $user_id = $Order->user->id; ?>
<script type="text/javascript">
    var total_chat = 0;
    var chatRequestId = 0;
    var chatUserId = 0;
    var chatload = 0;
    var initialized = false;
    var socketClient;
    initChat();
    updateChatParam({{$Order->id}}, {{$user_id}});

    function updateChatParam(pmrequestid, pmuserid) {
        console.log('Chat Params', pmrequestid, pmuserid);
        chatRequestId = pmrequestid;
        chatUserId = pmuserid;
        if(initialized == false) {
            socketClient.channel = pmrequestid;
            socketClient.initialize();
            socketClient.channel = pmrequestid;
            socketClient.pubnub.subscribe({channels:[socketClient.channel]});
            initialized = true;            
        }  
    }
    function initChat(){
        chatBox = document.getElementById('chat-box');
        chatInput = document.getElementById('chat-input');
        chatSend = document.getElementById('chat-send');
        chatSockets = function () {}
        chatSockets.prototype.initialize = function() { 
            this.pubnub = new PubNub({ 
                publishKey : '{{ Setting::get('PUBNUB_PUB_KEY') }}',
                subscribeKey : '{{ Setting::get('PUBNUB_SUB_KEY') }}'
            });
            console.log('Connect Channel', this.channel);
            this.pubnub.addListener({
                message: function(data) {  //beepOne.play();
                    console.log("New Message :: "+JSON.stringify(data));
                    if(data.message){
                        total_chat++;
                        console.log(total_chat);
                        $('#chat_{{$Order->id}}').html(total_chat);
                    }
                }
            });
        }

       

        socketClient = new chatSockets();

       

    }
</script>
@empty
@endforelse
@endsection
