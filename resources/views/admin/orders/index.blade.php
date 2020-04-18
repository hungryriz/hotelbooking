@extends('admin.layouts.app')

@section('content')
<?php $shop = $myorder = [];?>
 <div class="card"> 
    <ul class="nav nav-tabs row m-0 common-tab">
        <div class="col-sm-3 p-0">
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}?t=pending" class="nav-link @if(Request::get('t')=='pending') active  @endif">@lang('order.dispatcher.pending_title')</a>
            </li>
        </div>
        <div class="col-sm-3 p-0">
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}?t=accepted" class="nav-link @if(Request::get('t')=='accepted') active  @endif">@lang('order.dispatcher.accept_title')</a>
            </li>
        </div>
        <div class="col-sm-3 p-0">
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}?t=ongoing" class="nav-link @if(Request::get('t')=='ongoing') active  @endif">@lang('order.dispatcher.ongoing_title')</a>
            </li>
        </div>
        <div class="col-sm-3 p-0">
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}?t=cancelled" class="nav-link @if(Request::get('t')=='cancelled') active  @endif">@lang('order.dispatcher.cancel_title')</a>
            </li>
        </div>
    </ul>
    <div class="card-header">
        @if(Request::get('t')=='pending')
            <h3 class="card-title">@lang('order.dispatcher.order_pending')</h3>
        @endif
        @if(Request::get('t')=='accepted')
            <h3 class="card-title">@lang('order.dispatcher.order_accept')</h3>
        @endif
         @if(Request::get('t')=='ongoing')
            <h3 class="card-title">@lang('order.dispatcher.order_ongoing')</h3>
        @endif
         @if(Request::get('t')=='cancelled')
            <h3 class="card-title">@lang('order.dispatcher.order_cancel')</h3>
        @endif
    </div>
    @if(Request::get('t')=='pending')
    <div class="row">
        <form action="{{url('admin/orders?t=pending')}}" method="GET" class="popup-form">
            <div class="col-md-6">
                <input type="hidden" name="t" class="form-control " value="pending" >
                <input type="text" name="delivery_date" class="form-control datepicker" placeholder="Date" readonly >
             </div>
             <div class="col-md-6">
                  <button class="btn-success">Search</button>
             </div>
         </form>
         <input type="hidden" name="order_track_id" id="order_track_id" />
     </div>
    @endif
    <!-- Pending Order List Starts -->
    <div class="dispatcher row m-0">
        <!-- Dispatcher Left Starts -->
        <div class="col-md-7">
            <div class="dis-left" id="container">
            @if(Request::get('t')=='pending')
            <?php 
                if(@Request::get('delivery_date')){
                    $cur_date=\Carbon\Carbon::parse(Request::get('delivery_date'));
                    $last_date=\Carbon\Carbon::parse(Request::get('delivery_date'))->addDay();  
                    $dataorder = $Orders->whereBetween('delivery_date',[$cur_date,$last_date])->orderBy('delivery_date','ASC')->incoming();
                }else{
                    $dataorder = $Orders->orderBy('delivery_date','ASC')->incoming();
                }
            ?>
                <!-- Pending Order Block Starts -->  
                @forelse($dataorder as $Order) 
                <?php 
                $shop[$Order->shop->id]=$Order->shop;
                $myorder[$Order->shop->id][]=$Order->id;  
                $today=\Carbon\Carbon::tomorrow();
                    if($Order->delivery_date>=$today){
                        $order_now = 1;
                    }else{
                       $order_now = 0; 
                    }
                //dd($Orders);?>   

                    <div class="card card-inverse pending-block row m-0 @if($order_now == 1)  bg-primary @elseif($Order->status == 'RECEIVED') bg-danger  @else bg-success @endif">
                        <div class="card-block">
                            <div class="col-sm-3 card-top text-xs-center">
                                <div class="pending-dp-img bg-img" style="background-image: url({{ asset($Order->user->avatar ? : 'avatar.png') }});"></div>
                            </div>
                            <div class="col-sm-9">
                                <div class="card-btm pending-btm">
                                    <p class="card-txt"><b>#{{ $Order->id }}</b></p>
                                    <p class="card-txt">{{ $Order->user->name }}</p>
                                    <p class="card-txt">{{ $Order->user->phone }}</p>
                                </div>
                                <div class="card-btm row m-0">
                                    <button class="btn @if($order_now == 1)  btn-primary @elseif($Order->status == 'RECEIVED') btn-danger   @else btn-success @endif btn-darken-3 orderlist" data-id="{{$Order->id}}" >Order List</button>
                                    @if($Order->status == 'RECEIVED')
                                        @if($order_now == 0)
                                            @if(Setting::get('manual_assign')==1)
                                                <a href="{{ route('admin.orders.show', $Order->id) }}?t=pending&p=auto" class="btn btn-danger btn-darken-3">@lang('order.dispatcher.assign')</a>
                                            @else
                                                <a href="{{ route('admin.orders.show', $Order->id) }}?t=pending" class="btn btn-danger btn-darken-3">@lang('order.dispatcher.assign')</a>
                                            @endif
                                        @else
                                            <span class="tag batch">@lang('order.dispatcher.waiting')</span>
                                        @endif
                                    @elseif($Order->dispute == 'CREATED')
                                        <span class="tag batch">@lang('order.dispatcher.dispute')</span>
                                    @else
                                        <span class="tag batch">@lang('order.dispatcher.incoming_request')</span>

                                    @endif

                                     <a href="{{ url('admin/chat?order_id='.$Order->id) }}" class="btn btn-danger btn-darken-3" target="_blank"  >Chat</a>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="delete-block">
                            <!-- <a href="#" class="del-icon"><i class="ft-trash-2"></i></a> -->
                            <form action="{{ route('admin.orders.update', $Order->id) }}" id="assign-{{ $Order->id }}" class="form-horizontal" method="POST">
                                {{ csrf_field() }}
                                {{ method_field("PATCH") }}
                                <input type="hidden" name="status" value="CANCELLED">
                                <button class="btn @if($Order->status == 'CANCELLED') btn-success  @else btn-danger @endif btn-darken-3 del-icon">
                                   <i class="ft-trash-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>  
                @empty
                    <div class="col-xs-12">
                        <h4>@lang('order.dispatcher.order_not_found')</h4>
                    </div>
                @endforelse                   
                <!-- Pending Order Block Ends -->
            @elseif(Request::get('t')=='accepted')

                <!-- Pending Order Block Starts -->  
                @forelse($Orders->assigned() as $Order) 
                <?php 
                    $shop[$Order->shop->id]=$Order->shop;
                    $myorder[$Order->shop->id][]=$Order->id;  
                //dd($Orders);?>  
                    <div class="card card-inverse pending-block row m-0 bg-danger">
                        <div class="card-block">
                            <div class="col-sm-3 card-top text-xs-center">
                                <div class="pending-dp-img bg-img" style="background-image: url({{ asset($Order->user->avatar ? : 'avatar.png') }});"></div>
                            </div>
                            <div class="col-sm-9">
                                <div class="card-btm pending-btm">
                                    <p class="card-txt"><b>#{{ $Order->id }}</b></p>
                                        <p class="card-txt">{{ @$Order->transporter->name }}</p>
                                        <p class="card-txt">{{ @$Order->transporter->phone }}</p>
                                   
                                </div>
                                <div class="card-btm row m-0">
                                    <button class="btn btn-danger btn-darken-3 orderlist" data-id="{{$Order->id}}" >Order List</button>
                                    @if($Order->status=='PROCESSING')
                                        <span class="tag batch">@lang('order.dispatcher.packed')</span>
                                    @else
                                        <span class="tag batch">@lang('order.dispatcher.assigned')</span>
                                    @endif
                                    <a href="{{ url('admin/chat?order_id='.$Order->id) }}" class="btn btn-danger btn-darken-3" target="_blank"  >Chat</a>
                                </div>
                            </div>
                        </div>
                        <div class="delete-block">
                            <form action="{{ route('admin.orders.update', $Order->id) }}" id="assign-{{ $Order->id }}" class="form-horizontal" method="POST">
                                {{ csrf_field() }}
                                {{ method_field("PATCH") }}
                                <input type="hidden" name="status" value="CANCELLED">
                                <button class="btn @if($Order->status == 'CANCELLED') btn-success  @else btn-danger @endif btn-darken-3 del-icon">
                                   <i class="ft-trash-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>  
                @empty
                    <div class="col-xs-12">
                        <h4>@lang('order.dispatcher.order_not_found')</h4>
                    </div>
                @endforelse                  
                <!-- Pending Order Block Ends -->
            @elseif(Request::get('t')=='ongoing')

                <!-- Pending Order Block Starts -->  
                @forelse($Orders->ongoing() as $Order) 
                <?php 
                    $shop[$Order->shop->id]=$Order->shop;
                    $myorder[$Order->shop->id][]=$Order->id;  
                //dd($Orders);?>    
                    <div class="card card-inverse pending-block row m-0 bg-danger">
                        <div class="card-block">
                            <div class="col-sm-3 card-top text-xs-center">
                                <div class="pending-dp-img bg-img" style="background-image: url({{ asset($Order->user->avatar ? : 'avatar.png') }});"></div>
                            </div>
                            <div class="col-sm-9">
                                <div class="card-btm pending-btm">
                                    <p class="card-txt"><b>#{{ $Order->id }}</b></p>
                                        <p class="card-txt">{{ $Order->transporter->name }}</p>
                                        <p class="card-txt">{{ $Order->transporter->phone }}</p>
                                   
                                </div>
                                <div class="card-btm row m-0">
                                    <button class="btn btn-danger btn-darken-3 orderlist" data-id="{{$Order->id}}" >Order List</button>
                                     @if($Order->status=='PROCESSING')
                                        <form action="{{ route('admin.orders.update', $Order->id) }}" id="assign-{{ $Order->id }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field("PATCH") }}
                                            <input type="hidden" name="status" value="REACHED">
                                            <button class="btn @if($Order->status == 'RECEIVED') btn-success  @else btn-danger @endif btn-darken-3">
                                                @lang('order.dispatcher.reached')
                                            </button>
                                        </form>
                                    @endif
                                     @if($Order->status=='REACHED')
                                        <form action="{{ route('admin.orders.update', $Order->id) }}" id="assign-{{ $Order->id }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field("PATCH") }}
                                            <input type="hidden" name="status" value="PICKEDUP">
                                            <button class="btn @if($Order->status == 'RECEIVED') btn-success  @else btn-danger @endif btn-darken-3">
                                                @lang('order.dispatcher.packup')
                                            </button>
                                        </form>
                                    @endif
                                     @if($Order->status=='PICKEDUP')
                                        <form action="{{ route('admin.orders.update', $Order->id) }}" id="assign-{{ $Order->id }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field("PATCH") }}
                                            <input type="hidden" name="status" value="ARRIVED">
                                            <button class="btn @if($Order->status == 'RECEIVED') btn-success  @else btn-danger @endif btn-darken-3">
                                                @lang('order.dispatcher.arrived')
                                            </button>
                                        </form>
                                    @endif
                                    @if($Order->status=='ARRIVED')
                                        <form action="{{ route('admin.orders.update', $Order->id) }}" id="assign-{{ $Order->id }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field("PATCH") }}
                                            <input type="hidden" name="status" value="COMPLETED">
                                            <button class="btn @if($Order->status == 'RECEIVED') btn-success  @else btn-danger @endif btn-darken-3">
                                                @lang('order.dispatcher.arrived')
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ url('admin/chat?order_id='.$Order->id) }}" class="btn btn-danger btn-darken-3" target="_blank"  >Chat</a>
                                </div>
                            </div>
                        </div>
                        <div class="delete-block">
                            <form action="{{ route('admin.orders.update', $Order->id) }}" id="assign-{{ $Order->id }}" class="form-horizontal" method="POST">
                                {{ csrf_field() }}
                                {{ method_field("PATCH") }}
                                <input type="hidden" name="status" value="CANCELLED">
                                <button class="btn @if($Order->status == 'CANCELLED') btn-success  @else btn-danger @endif btn-darken-3 del-icon">
                                   <i class="ft-trash-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>  
                @empty
                    <div class="col-xs-12">
                        <h4>@lang('order.dispatcher.order_not_found')</h4>
                    </div>
                @endforelse                  
                <!-- Pending Order Block Ends -->

            @else

                <!-- Pending Order Block Starts -->  
                @forelse($Orders->cancelled() as $Order) 
                <?php 
                    $shop[$Order->shop->id]=$Order->shop;
                    $myorder[$Order->shop->id][]=$Order->id;  
                //dd($Orders);?>   
                    <div class="card card-inverse pending-block row m-0 bg-danger">
                        <div class="card-block">
                            <div class="col-sm-3 card-top text-xs-center">
                                <div class="pending-dp-img bg-img" style="background-image: url({{ asset($Order->user->avatar ? : 'avatar.png') }});"></div>
                            </div>
                            <div class="col-sm-9">
                                <div class="card-btm pending-btm">
                                    <p class="card-txt"><b>#{{ $Order->id }}</b></p>
                                        <p class="card-txt">{{ $Order->user->name }}</p>
                                        <p class="card-txt">{{ $Order->user->phone }}</p>
                                   
                                </div>
                                <div class="card-btm row m-0">
                                    <button class="btn btn-danger btn-darken-3 orderlist" data-id="{{$Order->id}}" >Order List</button>
                                    <a href="{{ url('admin/chat?order_id='.$Order->id) }}" target="_blank" class="btn btn-danger btn-darken-3">Chat</a>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="delete-block">
                            <a href="#" class="del-icon"><i class="ft-trash-2"></i></a>
                        </div> -->
                    </div>  
                @empty
                    <div class="col-xs-12">
                        <h4>@lang('order.dispatcher.order_not_found')</h4>
                    </div>
                @endforelse                  
                <!-- Pending Order Block Ends -->

            @endif
            </div>
        </div>
        <!-- Dispatcher Left Ends -->
         <!-- Dispatcher Left Ends -->
        <audio id="beep-one" controls preload="auto" style="display:none">
            <source src="{{asset('assets/audio/beep.mp3')}}" controls></source>
            <source src="{{asset('assets/audio/beep.ogg')}}" controls></source>
            Your browser isn't invited for super fun audio time.
        </audio>
        <!-- Dispatcher Right Starts -->
        <!-- Dispatcher Right Starts -->
        <div class="col-md-5">
            @if(count($shop)>0)
            <div id="basic-map1" class="dis-right"></div>
            @else
            <div id="basic-map" class="dis-right"></div>
            @endif
        </div>
        <!-- Dispatcher Right Ends -->
    </div>
    <!-- Pending Order List Ends -->
</div>
<!-- Order List Modal Starts -->
<div class="modal fade text-xs-left" id="order-list">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="myModalLabel1">Order List  </h2>
                <!-- <div><p id="order_timer"></p></div> -->
            </div>
            <div class="modal-body">
                <div class="row m-0">
                    <dl class="order-modal-top">
                        <div class="row m-0">
                            <dt class="col-sm-3 order-txt p-0">Order ID</dt> 
                            <dd class="col-sm-9 order-txt orderid"></dd>
                        </div>
                        <div class="row m-0">
                            <dt class="col-sm-3 order-txt p-0">Restaurant Name</dt>
                            <dd class="col-sm-9 order-txt rest_name"><span>: </span> Burger King</dd>
                        </div>
                        <div class="row m-0">
                            <dt class="col-sm-3 order-txt p-0">Customer Name</dt>
                            <dd class="col-sm-9 order-txt cust_name"><span>: </span> William Hawings</dd>
                        </div>
                        <div class="row m-0">
                            <dt class="col-sm-3 order-txt p-0">Address</dt>
                            <dd class="col-sm-9 order-txt address">
                                <span>: </span> 20B, Northeasrt Street,
                                <br> Newuork City,
                                <br> United States.
                            </dd>
                        </div>
                        <div class="row m-0">
                            <dt class="col-sm-3 order-txt p-0">Phone Number</dt>
                            <dd class="col-sm-9 order-txt cust_phone"><span>: </span> +12 445 8878 989</dd>
                        </div>
                        <div class="row m-0">
                            <dt class="col-sm-3 order-txt p-0">Delivery Date</dt>
                            <dd class="col-sm-9 order-txt cust_delivery_date"></dd>
                        </div>
                         <div class="row m-0">
                            <dt class="col-sm-3 order-txt p-0">Note</dt>
                            <dd class="col-sm-9 order-txt cust_order_note"></dd>
                        </div>
                        
                        <div class="row m-0">
                            <dt class="col-sm-3 order-txt p-0">Total Amount</dt>
                            <dd class="col-sm-9 order-txt tot_amt"><span>: </span> $1600</dd>
                            <br/>
                            <br/>
                        </div>
                         <div class="row m-0" >
                            <dt class="col-sm-3 order-txt p-0 ">Status</dt>
                            <dt class="col-sm-9 order-txt ">Time</dt>
                        </div>
                         <div class="row m-0" id="order_status_list">
                            <dt class="col-sm-3 order-txt p-0">INCOMING</dt>
                            <dd class="col-sm-9 order-txt ">  -- </dd>
                        </div>
                    </dl>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Note</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody class="cartstbl">

                            </tbody>
                            <tfoot>
                                 <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Discount</th>
                                    <th class="discount"> {{Setting::get("currency")}} 1600</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Delivery Charge</th>
                                    <th class="delivery_charge"> {{Setting::get("currency")}} 1600</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Tax</th>
                                    <th class="tax"> {{Setting::get("currency")}} 1600</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th class="tot_amt"> {{Setting::get("currency")}} 1600</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Order List Modal Ends -->
@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/timeTo.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/user/css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/js/jquery.time-to.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">
$(function () {
    $('.datepicker').datetimepicker({
        weekStart: 1,
        todayBtn:  0,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        format: 'yyyy-mm-dd',
        startDate:new Date()
    });
});

$(document).on("click", ".orderlist",function(){ 
    var order_id = $(this).data('id');
    var order_date;
    $.ajax({
        url: "{{url('admin/orders')}}/"+order_id,
        success: function(result){
            $('#order_timer').timeTo({
                timeTo: order_date,
                theme: "black",
                displayCaptions: true,
                fontSize: 30,
                captionSize: 10
            });
            order_date = new Date(new Date(result.Order.created_at));
            $('#order-list').modal('show');
            $('.orderid').html('<span>: </span>'+result.Order.id);
            $('.rest_name').html('<span>: </span>'+result.Order.shop.name);
            $('.cust_name').html('<span>: </span>'+result.Order.user.name);
            $('.cust_phone').html('<span>: </span>'+result.Order.user.phone);
            if(result.Order.delivery_date){
                $('.cust_delivery_date').html('<span>: </span>'+result.Order.delivery_date);
            }else{
                $('.cust_delivery_date').html('<span>: </span>'+result.Order.created_at);
            }
            if(result.Order.note){
                $('.cust_order_note').html('<span>: </span>'+result.Order.note);
            }else{
               $('.cust_order_note').html('<span>: -- </span>'); 
            }
            $('.address').html('<span>: </span>'+result.Order.address.map_address);
            $('.tot_amt').html('<span>: </span> {{Setting::get("currency")}}'+result.Order.invoice.net.toFixed(2));
            $('.discount').html("<span>: </span> {{Setting::get('currency')}}"+result.Order.invoice.discount.toFixed(2));
            $('.delivery_charge').html("<span>: </span> {{Setting::get('currency')}}"+result.Order.invoice.delivery_charge.toFixed(2));
            $('.tax').html("<span>: </span> {{Setting::get('currency')}}"+result.Order.invoice.tax.toFixed(2));
            var statuslist='';
            $.each( result.Order.ordertiming, function( key, value ) {
                statuslist+='<dd class="col-sm-3 order-txt p-0">'+value.status+'</dd>\
                <dd class="col-sm-9 order-txt "> '+value.created_at+'</dd>';
            });
            $('#order_status_list').html(statuslist);
            var table = '';
            console.log(result.Cart);
            $.each( result.Cart, function( key, value ) {
            table +='<tr>';
                if(value.product.images.length>0){
                table +='<td><div class="bg-img order-img" style="background-image: url('+value.product.images[0].url+');"></div></td>';
                }else{
                    table +='<td></td>';
                }
                table +='<td>'+value.product.name+'</td><td>'+value.note+'</td><td>{{Setting::get('currency')}}'+value.product.prices.price.toFixed(2)+'</td><td>'+value.quantity+'</td><td>{{Setting::get('currency')}}'+(value.quantity*value.product.prices.price).toFixed(2)+'</td></tr>';
                    $.each(value.cart_addons, function( key, valuee ) { console.log(valuee.quantity);
                            table +="<tr>\
                            <td class='text-left'>\
                                <h5>"+valuee.addon_product.addon.name+"</h5>\
                                <p>(Addons)</p>\
                            </td>\
                            <td>\
                                <strong>{{Setting::get('currency')}}"+valuee.addon_product.price.toFixed(2)+"</strong>\
                            </td>\
                            <td>"+value.quantity+"X"+valuee.quantity+"</td>\
                            <td>\
                                <p>{{Setting::get('currency')}}"+(value.quantity*valuee.addon_product.price*valuee.quantity).toFixed(2)+"</p>\
                            </td>\
                        </tr>";  
                     });
                
            });
            $('.cartstbl').html(table);
        }
    });
});


    function initialize() {

        var fenway = { lat: 42.345573, lng: -71.098326 };
        var map = new google.maps.Map(document.getElementById('basic-map1'), {
            center: fenway,
            zoom: 14
        });
        var panorama = new google.maps.StreetViewPanorama(
            document.getElementById('map'), {
                position: fenway,
                pov: {
                    heading: 34,
                    pitch: 10
                }
            });
        map.setStreetView(panorama);

    }
     function ongoingInitialize(trip) {
        map = new google.maps.Map(document.getElementById('basic-map1'), {
            center: {lat: 0, lng: 0},
            zoom: 2,
        });

        var bounds = new google.maps.LatLngBounds();

        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            icon: '/assets/img/marker-start.png'
        });

        var markerSecond = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            icon: '/assets/img/marker-end.png'
        });
        source = new google.maps.LatLng(trip.shop.latitude, trip.shop.longitude);
        destination = new google.maps.LatLng(trip.address.latitude, trip.address.longitude);

        marker.setPosition(source);
        markerSecond.setPosition(destination);

        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
        directionsDisplay.setMap(map);

        directionsService.route({
            origin: source,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                console.log('8888'+result);
                directionsDisplay.setDirections(result);

                marker.setPosition(result.routes[0].legs[0].start_location);
                markerSecond.setPosition(result.routes[0].legs[0].end_location);
            }
        });

        if(trip.transporter) {
            var markerProvider = new google.maps.Marker({
                map: map,
                icon: "/assets/img/marker-car.png",
                anchorPoint: new google.maps.Point(0, -29)
            });

            provider = new google.maps.LatLng(trip.transporter.latitude, trip.transporter.longitude);
            markerProvider.setVisible(true);
            markerProvider.setPosition(provider);
            console.log('Provider Bounds', markerProvider.getPosition());
            bounds.extend(markerProvider.getPosition());
        }
        
        bounds.extend(marker.getPosition());
        bounds.extend(markerSecond.getPosition());
        map.fitBounds(bounds);
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{Setting::get('GOOGLE_MAP_KEY')}}&callback=initialize" type="text/javascript"></script>
<script type="text/javascript">
    
    function assignorder(){ 
        $.ajax({
        url: "{{url('admin/orders?t=pending')}}&p=auto&ajax=1&auto=1",
        success: function(result){
           setTimeout(function(){ assignorder(); }, 3000);
            }
        });
    }
    assignorder();
</script>
<script>
    $(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/react.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/JSXTransformer.js"></script>

    <script type="text/jsx">
         var total_order = 0 ;var curstatus = ''; ;
        var beepOne = $("#beep-one")[0];
        var dataitems=[];
        var MainComponent = React.createClass({
            getInitialState: function () {
                    return {data: [], currency : "{{Setting::get('currency')}}"};
                },
            componentDidMount: function(){
                $.ajax({
                  url: "{{url('admin/orders?t='.Request::get('t'))}}&q=1",
                  type: "GET"})
                  .done(function(response){
                    console.log(response);
                    dataitems = response;
                        this.setState({
                            data:response
                        });

                    }.bind(this));

                    setInterval(this.checkRequest, 5000);
            },
            checkRequest : function(){
                $.ajax({
                  url: "{{url('admin/orders?t='.Request::get('t'))}}&q=1",
                  type: "GET"})
                  .done(function(response){
                        dataitems = response;
                        if(total_order==0){
                            total_order = response.length;
                        } 
                        if(total_order < response.length){
                            beepOne.play();
                            total_order = response.length;
                        }
                        this.setState({
                            data:response
                        });

                    }.bind(this));
            },
            render: function(){
                var listItems = this.state.data.map(function(item) { 
                var message = item.status;
                $(document).on("click", '#btn-info_'+item.id+'' , function() {
                            ongoingInitialize(item);
                            $('#order_track_id').val(item.id);
                });
                if($('#order_track_id').val() == item.id){
                    if(curstatus != item.status){ 
                        $('#btn-info_'+item.id+'').trigger('click');
                        curstatus = item.status;
                    }
                }
                var cancel_div =<div className="delete-block">
                            <form action={`{{url('admin/orders/')}}/${item.id}`} id="assign-item.id" className="form-horizontal" method="POST">
                               <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <input type="hidden" name="_method" value="PATCH" />
                                <input type="hidden" name="status" value="CANCELLED" />
                                <button className="btn  btn-danger  btn-darken-3 del-icon">
                                   <i className="ft-trash-2"></i>
                                </button>
                            </form>
                        </div>;
                if(item.status=='RECEIVED'){
                    var message = "";
                    var bgcol ="card card-inverse pending-block row m-0  bg-danger  ";
                    var btncol ="btn   btn-danger    btn-darken-3 orderlist";
                    @if(Setting::get('manual_assign')==1)
                    var assign='';
                    var message = "{{trans('order.dispatcher.waiting')}}";
                    var assign1 =<a href={`{{url('admin/orders/')}}/${item.id}?t=pending&p=auto`} className="btn btn-danger btn-darken-3">{{trans("order.dispatcher.assign")}}</a>;
                    @else
                    var assign =<a href={`{{url('admin/orders/')}}/${item.id}?t=pending`} className="btn btn-danger btn-darken-3">{{trans("order.dispatcher.assign")}}</a>;
                    @endif
                }else if(item.status=='READY'){
                    var bgcol ="card card-inverse pending-block row m-0  bg-primary  ";
                    var btncol ="btn   btn-primary    btn-darken-3 orderlist";
                    var assign ='';
                    var message = "{{trans('order.dispatcher.waiting')}}";
                }else if(item.status=='PROCESSING'){
                    var message = "{{trans('order.dispatcher.packed')}}";
                    var bgcol ="card card-inverse pending-block row m-0  bg-primary  ";
                    var btncol ="btn   btn-primary    btn-darken-3 orderlist";
                    var assign ='';
                }else if(item.status=='CANCELLED'){
                    var message = "";
                    var bgcol ="card card-inverse pending-block row m-0  bg-primary  ";
                    var btncol ="btn   btn-primary    btn-darken-3 orderlist";
                    var assign ='';
                    var cancel_div = "";
                }else{
                    var bgcol ="card card-inverse pending-block row m-0  bg-success  ";
                    var btncol ="btn   btn-success    btn-darken-3 orderlist";
                    var assign ='';
                    if(item.status=='ORDERED'){
                        var message = "{{trans('order.dispatcher.incoming_request')}}";
                    }
                    if(item.status=='ASSIGNED'){
                        var message = "{{trans('order.dispatcher.assigned')}}";
                    }
                }
                if(item.dispute=='CREATED'){
                var message = "{{trans('order.dispatcher.dispute')}}";
                var assign ='';
                }
                if(item.dispute=='CREATED' && item.status=='CANCELLED'){
                var message = "";
                var assign ='';
                }
                    return (
                        <div key={item.id} className={bgcol} id={`btn-info_${item.id}`}>
                        <div className="card-block">
                            <div className="col-sm-3 card-top text-xs-center">
                                <div className="pending-dp-img bg-img"  >
                                    <img src={item.user.avatar} className="pending-dp-img bg-img" styles="height:50px;width:50px" />
                                </div>
                            </div>
                            <div className="col-sm-9">
                                <div className="card-btm pending-btm">
                                    <p className="card-txt"><b>#{item.id}</b></p>
                                    <p className="card-txt">{item.user.name}</p>
                                    <p className="card-txt">{item.user.phone}</p>
                                </div>
                                <div className="card-btm row m-0">
                                    <button className={btncol} data-id={item.id}>Order List</button>
                                    @if(Setting::get('manual_assign')==1)
                                               <span>{assign}</span>
                                            @else
                                                <span>{assign}</span>
                                            @endif
                                    <span className="tag batch">{message}</span>
                                    <a href={`chat?order_id=${item.id}`} className="btn btn-danger btn-darken-3" target="_blank">Chat</a>   
                                </div>
                            </div>
                        </div>
                       {cancel_div}
                    </div>
                    );
                });

                return (
                    <div>
                    {listItems}    
                    </div>  
                );
            }
        });

         
        React.render(<MainComponent  />,document.getElementById("container"));
    </script>
@endsection
