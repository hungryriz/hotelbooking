@extends('user.layouts.app')

@section('content')
 <!-- Content ================================================== -->
    <div class="container margin_60_35">
        <div class="row">
            <div class="profile-left-col col-md-3 ">
                @include('user.layouts.partials.sidebar')
            </div>
            <!--End col-md -->
            <div class="profile-right-col col-md-9 white_bg">
                <div class="profile-right white_bg row">
                    <div class="prof-head">
                        <h3 class="prof-tit">Upcoming Orders</h3>
                    </div>
                    <div class="prof-content">
                        <!-- Strip List -->
                        @forelse($Orders as $Index => $Order)
                        <div class="strip_list wow fadeIn" data-wow-delay="0.1s">
                            <div class="row">
                                <div class="col-md-9 col-sm-9">
                                    <div class="desc">
                                        <div class="thumb_strip">
                                            <a href="#"><img src="{{$Order->shop->avatar}}" alt=""></a>
                                        </div>
                                        <div class="rating">
                                            <i class="icon_star voted"></i>
                                            <i class="icon_star voted"></i>
                                            <i class="icon_star voted"></i>
                                            <i class="icon_star voted"></i>
                                            <i class="icon_star"></i> (
                                            <small><a href="#0">98 reviews</a></small>)
                                        </div>
                                        <h3>{{$Order->shop->name}}</h3>
                                        <button class="pur-link submit itemlist" data-id="{{$Order->id}}">Purchasing List</button>
                                        <p class="order-txt">Ordered on {{$Order->created_at}}</p>
                                        <p class="order-txt">Delivery on --</p>
                                        <ul>
                                            <li>{{$Order->status}}<i class="icon_check_alt2 ok"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <div class="go_to">
                                        <div>
                                             <a   href="{{url('user/chat?order_id='.$Order->id)}}" target="_blank" class="btn_1">Chat<span class="chatbtn" id="chat_{{$Order->id}}">0</span></a>
                                        <br/><br/><br/><br/>
                                            <a href="{{url('track/order/'.$Order->id)}}" class="btn_1">Track</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End row-->
                        </div>
                        @empty
                        <div> No Order Found!</div>
                        @endforelse
                        <!-- End strip_list-->
                    </div>
                </div>
            </div>
        </div>
        <!-- End row -->
    </div>
    <!-- End container -->
        <!--  Add Purchase Items modal -->
    <div class="modal fade" id="product-list" tabindex="-1" role="dialog" aria-labelledby="product-list" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-popup" style="background-color: #fff;">
                <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
                <form action="#" class="">
                    <h3 class="pop-tit">Product List</h3>
                    <table class="table table-striped cart-list ">
                        <thead>
                            <tr>
                                <th>
                                    Item
                                </th>
                                <th>
                                    Qty
                                </th>
                                <th>
                                    Price
                                </th>
                                <th>
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody class="item_list">
                            
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add Address modal -->
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
                            console.log(value.addons);
                            //alert(data.items.addons.length);
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
                            $('.item_list').html(item_list);
                        });
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
