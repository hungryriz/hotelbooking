@extends('shop.layouts.app')
@section('content')
 <div class="card"> 
    <ul class="nav nav-tabs row m-0 common-tab">
        <div class="col-sm-3 p-0">
            <li class="nav-item">
                <a href="{{ url('shop/orders') }}?t=pending" class="nav-link @if(Request::get('t')=='pending') active  @endif">Incoming Orders</a>
            </li>
        </div>
        <div class="col-sm-3 p-0">
            <li class="nav-item">
                <a href="{{ url('shop/orders') }}?t=accepted" class="nav-link @if(Request::get('t')=='accepted') active  @endif">Accepted Orders</a>
            </li>
        </div>
        <div class="col-sm-3 p-0">
            <li class="nav-item">
                <a href="{{ url('shop/orders') }}?t=ongoing" class="nav-link @if(Request::get('t')=='ongoing') active  @endif">Ongoing Orders</a>
            </li>
        </div>
        <div class="col-sm-3 p-0">
            <li class="nav-item">
                <a href="{{ url('shop/orders') }}?t=cancelled" class="nav-link @if(Request::get('t')=='cancelled') active  @endif">Cancelled Orders</a>
            </li>
        </div>
    </ul>
    <div class="card-header">
        @if(Request::get('t')=='pending')
            <h3 class="card-title">Customer Pending List</h3>
        @endif
        @if(Request::get('t')=='accepted')
            <h3 class="card-title">Delivery People List</h3>
        @endif
         @if(Request::get('t')=='ongoing')
            <h3 class="card-title">Ongoing Orders</h3>
        @endif
         @if(Request::get('t')=='cancelled')
            <h3 class="card-title">Cancelled Orders</h3>
        @endif
    </div>
    @if(Request::get('t')=='pending')
    <div class="row">
        <form action="{{url('shop/orders?t=pending')}}" method="GET" class="popup-form">
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
           
                <!-- Pending Order Block Starts -->  
                @forelse($Orders as $Order) 
                <?php 
                    $today=\Carbon\Carbon::tomorrow();
                    if($Order->delivery_date>=$today){
                        $order_now = 1;
                    }else{
                       $order_now = 0; 
                    }
                //dd($Orders);?>        
                    <div class="card card-inverse pending-block row m-0 @if($Order->status == 'RECEIVED') bg-success @elseif($order_now ==1) bg-primary   @else bg-danger @endif">
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
                                    <div class="form-group col-sm-4">
                                        <button class="btn @if($Order->status == 'RECEIVED') btn-success  @elseif($order_now ==1) btn-primary @else btn-danger @endif btn-darken-3 orderlist" data-id="{{$Order->id}}" >Order List</button>
                                    </div>
                                    @if($Order->status=='ORDERED' && $Order->dispute!='CREATED')
                                        <div class="form-group col-sm-2">
                                            <form action="{{ route('shop.orders.update', $Order->id) }}" id="assign-{{ $Order->id }}" class="form-horizontal" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field("PATCH") }}
                                                <input type="hidden" name="status" value="RECEIVED">
                                                <button type="button" class="btn @if($Order->status == 'RECEIVED') btn-success  @else btn-danger @endif btn-darken-3">
                                                    <i class="fa fa-check-square-o"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="form-group col-sm-2">
                                            <form action="{{ route('shop.orders.update', $Order->id) }}" id="assign-{{ $Order->id }}" class="form-horizontal" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field("PATCH") }}
                                                <input type="hidden" name="status" value="CANCELLED">
                                                <button class="btn @if($Order->status == 'CANCELLED') btn-success  @else btn-danger @endif btn-darken-3">
                                                    <i class="ft-x"></i>
                                                </button>
                                            </form>
                                           <!--  <form action="{{ route('shop.dispute.store') }}" id="assign-{{ $Order->id }}" class="form-horizontal" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="order_id" value="{{ $Order->id }}">
                                                <input type="hidden" name="description" value="Order Product Not Available">
                                                <input type="hidden" name="dispute_type" value="CANCELLED">
                                                <input type="hidden" name="created_by" value="shop">
                                                <input type="hidden" name="created_to" value="user">
                                                <button class="btn @if(@$Order->status == 'RECEIVED') btn-success  @else btn-danger @endif btn-darken-3">
                                                    <i class="ft-x"></i>
                                                </button>
                                            </form> -->
                                        </div>
                                    @endif
                                    <div class="form-group col-sm-2">
                                        @if($Order->dispute=='CREATED')
                                           <span class="tag batch btn">Dispute</span>
                                        @endif
                                        @if($Order->status=='PROCESSING')
                                           <span class="tag batch btn">Packed</span>
                                        @endif
                                        @if($Order->status=='ASSIGNED')
                                           <span class="tag batch btn ">@lang('order.dispatcher.assigned')</span>
                                        @endif
                                         @if($Order->status=='REACHED' || $Order->status=='PICKEDUP' || $Order->status=='ARRIVED' )
                                           <span class="tag batch btn">{{$Order->status}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="delete-block">
                            <a href="#" class="del-icon"><i class="ft-trash-2"></i></a>
                        </div> -->
                    </div>  
                @empty
                    <div class="col-xs-12">
                        <h4>No Incoming Requests at the moment!</h4>
                    </div>
                @endforelse                   
              
            </div>
        </div>
        <!-- Dispatcher Left Ends -->
        <!-- Dispatcher Right Starts -->
        <div class="col-md-5">
            <div id="basic-map1" class="dis-right"></div>
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
                <h2 class="modal-title" id="myModalLabel1">Order List</h2>
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
                            <dt class="col-sm-3 order-txt p-0">Status</dt>
                            <dt class="col-sm-9 order-txt ">Time</dt>
                        </div>
                         <div class="row m-0" id="order_status_list">
                            <dt class="col-sm-3 order-txt p-0">INCOMING</dt>
                            <dd class="col-sm-9 order-txt ">  {{date("Y-m-d H:i:s")}}</dd>
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
<!-- Order List Modal Starts -->
<div class="modal fade text-xs-left" id="order-ready-time">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="myModalLabel1">Order Ready Time(Minutes)</h2>
                <!-- <div><p id="order_timer"></p></div> -->
            </div>
            <div class="modal-body">
                <form action={`{{url('shop/orders/')}}/${item.id}`} id={`cancel-${item.id}`} class="form-horizontal" method="POST">
                       <input type="hidden" name="_token" value="{{csrf_token()}}" />
                        <input type="hidden" name="_method" value="PATCH" />
                        <input type="hidden" name="status" value="RECEIVED" />
                        <input type="number" min="1" max="900000" class="form-control" name="order_ready_time" id="order_ready_time" />
                        <hr/>
                        <button class="btn btn-primary btn-darken-3">
                            Next
                        </button>
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Order List Modal Ends -->
<audio id="beep-one" controls preload="auto" style="display:none">
    <source src="{{asset('assets/audio/beep.mp3')}}" controls></source>
    <source src="{{asset('assets/audio/beep.ogg')}}" controls></source>
    Your browser isn't invited for super fun audio time.
</audio>
@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/timeTo.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/user/css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('scripts')
 <!--for map -->
    <script type="text/javascript" src="{{ asset('assets/user/js/bootstrap-datetimepicker.min.js') }}"></script>
   <!--  <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}" type="text/javascript"></script> -->
   <!--  <script src="{{ asset('assets/admin/vendors/js/charts/gmaps.min.js')}}" type="text/javascript"></script> -->
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- <script src="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/js/scripts/charts/gmaps/maps.min.js" type="text/javascript"></script> -->
    <!-- END PAGE LEVEL JS-->
    <script src="{{ asset('assets/js/jquery.time-to.js') }}" type="text/javascript"></script>
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
$(document).on("click", ".received",function(){ 
    var id =$(this).data('id');
    var act_url ="{{url('shop/orders/')}}/"+id;
    $('#order-ready-time form').attr('action',act_url);

    $('#order-ready-time').modal('show');
});
$(document).on("click", ".orderlist",function(){ 
    var order_id = $(this).data('id');
    var order_date;
    $.ajax({
        url: "{{url('shop/orders')}}/"+order_id,
        success: function(result){
            $('#order_timer').timeTo({
                timeTo: order_date,
                theme: "black",
                displayCaptions: true,
                fontSize: 30,
                captionSize: 10
            });
            order_date = new Date(new Date(result.Order.created_at));
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
            $('.tot_amt').html("<span>: </span> {{Setting::get('currency')}}"+result.Order.invoice.net);
            $('.discount').html("<span>: </span> {{Setting::get('currency')}}"+result.Order.invoice.discount);
            $('.delivery_charge').html("<span>: </span> {{Setting::get('currency')}}"+result.Order.invoice.delivery_charge);
            $('.tax').html("<span>: </span> {{Setting::get('currency')}}"+result.Order.invoice.tax);
            $('#order-list').modal('show');
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
})

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/react.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/JSXTransformer.js"></script>

    <script type="text/jsx">
        var total_order = 0 ; var curstatus = '';
       var beepOne = $("#beep-one")[0];
        var dataitems=[];
        var MainComponent = React.createClass({
            getInitialState: function () {
                    return {data: [], currency : "{{Setting::get('currency')}}"};
                },
            componentDidMount: function(){
                $.ajax({
                  url: "{{url('shop/orders?t='.Request::get('t'))}}",
                  type: "GET",
                  data:{'delivery_date':"{{Request::get('delivery_date')}}"}
                  })
                  .done(function(response){
                   
                    dataitems = response;
                        this.setState({
                            data:response.Orders
                        });

                    }.bind(this));

                    setInterval(this.checkRequest, 5000);
            },
            checkRequest : function(){
                $.ajax({
                  url: "{{url('shop/orders?t='.Request::get('t'))}}",
                  type: "GET",
                  data:{'delivery_date':"{{Request::get('delivery_date')}}"}
                  })
                  .done(function(response){
                        dataitems = response;
                         if(total_order==0){
                          total_order = response.Orders.length;
                        } 
                        if(total_order < response.Orders.length){
                         beepOne.play();
                         total_order = response.Orders.length;
                        }
                        this.setState({
                            data:response.Orders
                        });
                        $('#tot_incom_order').html(response.tot_incom_resp);
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
                if(item.status=='ORDERED'){
                    var message = "";
                    if(item.schedule_status==1){
                        var bgcol ="card card-inverse pending-block row m-0  bg-primary  ";
                        var btncol ="btn     btn-danger    btn-darken-3 orderlist";
                        var btncol_rcv ="btn  received   btn-danger    btn-darken-3 ";
                        var btncol_cnl ="btn     btn-danger    btn-darken-3 ";
                    }else{
                        var bgcol ="card card-inverse pending-block row m-0  bg-danger  ";
                        var btncol ="btn   btn-danger    btn-darken-3 orderlist";
                        var btncol_rcv ="btn  received   btn-danger    btn-darken-3 ";
                        var btncol_cnl ="btn     btn-danger    btn-darken-3 ";
                    }
                    
                    var assign =<form action={`{{url('shop/orders/')}}/${item.id}`} id={`assign-${item.id}`} className="form-horizontal" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <input type="hidden" name="_method" value="PATCH" />
                        <input type="hidden" name="status" value="RECEIVED" />
                        <button type="button" data-id={item.id} className={btncol_rcv}>
                            <i className="fa fa-check-square-o"></i>
                        </button>
                    </form>;
              
                var cancel=<form action={`{{url('shop/orders/')}}/${item.id}`} id={`assign-${item.id}`} className="form-horizontal" method="POST">
                       <input type="hidden" name="_token" value="{{csrf_token()}}" />
                        <input type="hidden" name="_method" value="PATCH" />
                        <input type="hidden" name="status" value="CANCELLED" />
                        <button className={btncol_cnl}>
                            <i className="ft-x"></i>
                        </button>
                    </form>;
                    
                }else if(item.status=='READY'){
                    var bgcol ="card card-inverse pending-block row m-0  bg-primary  ";
                    var btncol ="btn   btn-primary    btn-darken-3 orderlist";
                    var assign ='';
                    var message = "{{trans('order.dispatcher.waiting')}}";
                    var cancel ='';
                }else if(item.status=='PROCESSING'){
                    var message = "{{trans('order.dispatcher.packed')}}";
                    var bgcol ="card card-inverse pending-block row m-0  bg-primary  ";
                    var btncol ="btn   btn-primary    btn-darken-3 orderlist";
                    var cancel ='';
                    var assign =<form action={`{{url('shop/orders/')}}/${item.id}`} id={`assign-${item.id}`} className="form-horizontal" method="POST">
                       <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <input type="hidden" name="_method" value="PATCH"/>
                        <input type="hidden" name="status" value="READY"/>
                        <button className={btncol}>
                            <i className="fa fa-check-square-o"></i>
                        </button>
                    </form>;
                }else if(item.status=='CANCELLED'){
                    
                    var bgcol ="card card-inverse pending-block row m-0  bg-primary  ";
                    var btncol ="btn   btn-primary    btn-darken-3 orderlist";
                    var assign ='';
                    var cancel ='';
                }else{
                    var bgcol ="card card-inverse pending-block row m-0  bg-success  ";
                    var btncol ="btn   btn-success    btn-darken-3 orderlist";
                    //var message = "{{trans('order.dispatcher.assigned')}}";
                    var assign ='';
                    var cancel ='';
                }
                if(item.dispute=='CREATED'){
                var message = "{{trans('order.dispatcher.dispute')}}";
                var assign ='';
                var cancel ='';
                }
                    return (
                        <div key={item.id} className={bgcol} id={`btn-info_${item.id}`} >
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
                                    {item.id?<div className="form-group col-sm-4">
                                         <button className={btncol} data-id={item.id}>Order List</button>
                                    </div>:''}
                                        {assign?<div className="form-group col-sm-2">
                                        {assign}</div>:''}
                                        {cancel?<div className="form-group col-sm-2">
                                        {cancel}</div>:''}
                                        {message?<div className="form-group col-sm-2">
                                        <span className="tag batch">{message}</span>
                                        </div>:''}
                                </div>
                            </div>
                        </div>
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

