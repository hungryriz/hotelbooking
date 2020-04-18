@extends('user.layouts.app')

@section('content')

<!-- status -->
<section style="background:#efefe9;">
    <div class="container">
        <div class="row">
            @include('include.alerts')  
            <div class="board">
                <h2>Delivery Tracking<!-- <sup>™</sup> --></h2>
                    <div class="board-inner">
                        <ul class="nav nav-tabs" id="myTab">
                            <div class="liner"></div>
                            <li class="ORDERED @if(@$Order->status == 'ORDERED') active @endif " >
                                <a href="#home" data-toggle="tab" title="Order Placed">
                                    <span class="round-tabs one">
                                        <i class="glyphicon glyphicon-heart"></i>
                                    </span> 
                                </a>
                                <br> 
                                <p class="track-tab">Order Placed</p>
                            </li> 

                            <li class="RECEIVED @if($Order->status == 'RECEIVED') active @endif" >
                                <a href="#profile" data-toggle="tab" title="Order Confirmed">
                                    <span class="round-tabs two">
                                        <i class="glyphicon glyphicon-ok"></i>
                                    </span> 
                                </a>
                                <br> 
                                <p class="track-tab">Order Confirmed</p>
                            </li>
                            <li class="ASSIGNED @if($Order->status == 'ASSIGNED') active @endif " >
                                <a href="#messages" data-toggle="tab" title="Order Assigned">
                                     <span class="round-tabs three">
                                          <i class="glyphicon glyphicon-inbox"></i>
                                     </span> 
                                </a>
                                <br> 
                                <p class="track-tab">Order Assigned</p>
                            </li>
                            <li class="PROCESSING @if($Order->status == 'PROCESSING') active @endif " >
                                <a href="#settings" data-toggle="tab" title="Order Processing">
                                     <span class="round-tabs four">
                                          <i class="glyphicon glyphicon-hourglass"></i>
                                     </span> 
                                </a>
                                <br> 
                                <p class="track-tab">Order Processing</p>
                            </li>
                            <li class="REACHED @if($Order->status == 'REACHED') active @endif">
                                <a href="#settings" data-toggle="tab" title="Order Reached">
                                    <span class="round-tabs four">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span> 
                                </a>
                                <br> <p class="track-tab">Order Reached</p>
                            </li>
                            <li class="PICKEDUP @if($Order->status == 'PICKEDUP') active @endif ">
                                <a href="#settings" data-toggle="tab" title="Order Pickedup">
                                    <span class="round-tabs four">
                                        <i class="glyphicon glyphicon-export"></i>
                                    </span> 
                                </a>
                                <br> <p class="track-tab">Order Pickedup</p>
                            </li> 
                            <li class="ARRIVED @if($Order->status == 'ARRIVED') active @endif ">
                                <a href="#settings" data-toggle="tab" title="Order Arrived">
                                    <span class="round-tabs four">
                                        <i class="glyphicon glyphicon-flag"></i>   
                                    </span> 
                                </a>
                                <br><p class="track-tab">Order Arrived</p>
                            </li>
                            <li class="COMPLETED @if($Order->status == 'COMPLETED') active @endif" >
                                <a href="#doner" data-toggle="tab" title="Order Completed">
                                     <span class="round-tabs five">
                                        <i class="glyphicon glyphicon-thumbs-up"></i>
                                    </span> 
                                </a>
                                <br> <p class="track-tab">Order Completed</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> 
        </div>   
</section>
                   
    <!-- /status -->
    <!-- Content ================================================== -->
    <div class="container margin_60_35">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
              
                <!-- End box_style_1 -->
                    <div class="theiaStickySidebar">
                        <div id="cart_box">
                            <h3>Your order <i class="icon_cart_alt pull-right"></i></h3>
                            <table class="table table_summary">
                                <thead>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Per Price</th>
                                    <th>Price</th>
                                </thead>
                                <tbody>
                                    @forelse($Order->items as $key=>$item)
                                    <tr>
                                        <td>
                                             {{$item->product->name}}
                                             <p>{{$item->note}}</p>
                                        </td>
                                        <td>
                                              <strong>{{$item->quantity}}</strong>
                                        </td>
                                        <td>
                                             <strong>{{currencydecimal($item->product->prices->price)}}
                                        </td>
                                        <td>
                                            <strong class="pull-right">{{currencydecimal($item->quantity*$item->product->prices->price)}}</strong>
                                        </td>
                                    </tr>

                                        @forelse(@$item->cart_addons as $cartaddon)
                                    <tr>
                                        <td>
                                             {{$cartaddon->addon_product->addon->name}}(@lang('user.addons'))
                                        </td>
                                         <td>
                                              <strong>{{$item->quantity}}X{{$cartaddon->quantity}}</strong>
                                        </td>
                                        <td>
                                             <strong>{{currencydecimal($cartaddon->addon_product->price)}}
                                        </td>
                                         <td>
                                            
                                            <strong class="pull-right">{{currencydecimal($item->quantity*$cartaddon->quantity*$cartaddon->addon_product->price)}}</strong>
                                        </td>
                                     </tr>
                                        @empty
                                        @endforelse


                                    @empty
                                    @endforelse
                                    
                                </tbody>
                            </table>
                            <hr>
                            <a href="{{ url('user/chat?order_id='.$Order->id) }}" class="btn btn-danger btn-darken-3" target="_blank"  >Chat</a>
                            @if($Order->status == 'CANCELLED')
                            <p>{{$Order->status}}</p>
                            @endif
                            <!-- Edn options 2 -->
                            <hr>
                            <table class="table table_summary">
                                <tbody>
                                    <tr>
                                        <td>
                                            Order Custom Note:- 
                                            <span class="pull-right">{{$Order->note}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Order Delivery Date:- 
                                            <span class="pull-right">{{$Order->delivery_date}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Subtotal <span class="pull-right">{{currencydecimal($Order->invoice->gross)}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Tax <span class="pull-right">{{currencydecimal($Order->invoice->tax)}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Delivery fee <span class="pull-right">{{currencydecimal(Setting::get('delivery_charge'))}}</span>
                                        </td>
                                    </tr>
                                    <tr>@if($Order->invoice->tax != '')
                                <td >
                                    Wallet Detection
                                     <span class="pull-right">{{currencydecimal($Order->invoice->wallet_amount)}}</span>
                                </td>
        
                                @endif
                            </tr>
                                    <tr>
                                        <td>
                                            Discount <span class="pull-right">-{{currencydecimal($Order->invoice->discount)}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="total">
                                            TOTAL <span class="pull-right">{{currencydecimal($Order->invoice->net - $Order->invoice->wallet_amount)}}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                             @if($Order->status == 'ARRIVED' && $Order->invoice->payment_mode!='cash')
                            <a class="btn_full" href="{{url('payment')}}?order_id={{$Order->id}}">Pay Now</a>
                            @endif
                            
                        </div>
                        <!-- End cart_box -->
                    </div>
            </div>

        </div>
            <!-- End col-md-6 -->
            <div class="col-md-6" id="sidebar">
                <div class="theiaStickySidebar">
                    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}"  >
                    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}"  >
                    <input  id="pac-input" type="hidden" />
                    <div id="map_1" class="col-md-12" style="height:500px;"></div>
                </div>
                <!-- End theiaStickySidebar -->
                <div id="container"></div>
                <div class="col-md-12"  id="rating_review" @if(@$Order->reviewrating)  @else style="display:none" @endif >
                    
                    @if(@$Order->reviewrating && @$Order->reviewrating->shop_id)
                       
                        @else
                            <div class="col-md-6">
                                <form  method="post"  action="{{url('rating')}}" >
                                {{csrf_field()}}
                                <input type="hidden" name="order_id" value="{{$Order->id}}" />
                                <input type="hidden" name="type" value="shop" />
                                <b>Give Review & Rating To "{{$Order->shop->name}}"</b>
                                <div class="form-group">
                                <label>Review</label>
                                <textarea class="form-control" name="comment"></textarea>
                                </div>
                                <div class="form-group">
                                <label>Rating</label>
                                <input type="number" min="1" max="5" value="" name="rating" class="form-control" />
                                </div>
                                <button type="submit" class="btn btn-primary pull-right" >Submit</button>
                                </form>
                            </div> 
                        
                    @endif 
                    @if(@$Order->reviewrating && @$Order->reviewrating->transporter_id)
                       
                        @else
                            <div class="col-md-6">
                                <form  method="post"  action="{{url('rating')}}" >
                                {{csrf_field()}}
                                <input type="hidden" name="order_id" value="{{$Order->id}}" />
                                <input type="hidden" name="type" value="transporter" />
                                <b>Give Review & Rating To "{{@$Order->transporter->name}}"</b>
                                <div class="form-group">
                                <label>Review</label>
                                <textarea class="form-control" name="comment"></textarea>
                                </div>
                                <div class="form-group">
                                <label>Rating</label>
                                <input type="number" min="1" max="5" name="rating" class="form-control" />
                                </div>
                                <button type="submit" class="btn btn-primary pull-right" >Submit</button>
                                </form>
                            </div> 
                        
                    @endif 
                </div>
            </div>
            <!-- End col-md-3 -->
    </div>
        <!-- End row -->
</div>
    <!-- End container -->
    <input type="button" id="routebtn" value="route"  />
    <!-- End Content =============================================== -->
@endsection
@section('scripts')


    <script>
    var order = '';  var curstatus = '';
    function mapLocation() {
    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;

    function initialize() {
        directionsDisplay = new google.maps.DirectionsRenderer();
        var chicago = new google.maps.LatLng({{$Order->address->latitude}},
                {{$Order->address->longitude}});
        var mapOptions = {
            zoom: 14,
            center: chicago
        };
        map = new google.maps.Map(document.getElementById('map_1'), mapOptions);
        directionsDisplay.setMap(map);
       
        google.maps.event.addDomListener(document.getElementById('routebtn'), 'click', calcRoute);
        google.maps.event.addDomListener(document.getElementById('map_1'), 'load', calcRoute);
    }

    function calcRoute() {
        console.log('order');
        @if($Order->status == 'CANCELLED' || $Order->status == 'COMPLETED')
            var start = new google.maps.LatLng({{$Order->shop->latitude}},{{$Order->shop->longitude}});
        @else
            if(order.transporter == null){
            var start = new google.maps.LatLng(order.shop.latitude,order.shop.longitude);
            }else{
            var start = new google.maps.LatLng(order.transporter.latitude,order.transporter.longitude);
            }
        @endif
        var end = new google.maps.LatLng({{$Order->address->latitude}},
                {{$Order->address->longitude}});
        var bounds = new google.maps.LatLngBounds();
        bounds.extend(start);
        bounds.extend(end);
        map.fitBounds(bounds);
        var request = {
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                directionsDisplay.setMap(map);
            } else {
                alert("Directions Request from " + start.toUrlValue(6) + " to " + end.toUrlValue(6) + " failed: " + status);
            }
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
}
//mapLocation();
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{Setting::get('GOOGLE_MAP_KEY')}}&libraries=places&callback=mapLocation" ></script>
    @if($Order->status == 'CANCELLED' || $Order->status == 'COMPLETED')
        <script type="text/javascript">
            window.onload = function() {
                setTimeout(function() {
                    $('#routebtn').trigger('click');
                }, 3000);
                
             };
        </script>
    @else
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/react.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/JSXTransformer.js"></script>

    <script type="text/jsx">
        var MainComponent = React.createClass({
            getInitialState: function () {
                    return {data: [], currency : "{{Setting::get('currency')}}"};
                },
            componentDidMount: function(){
                $.ajax({
                  url: "{{url('track/order/'.Request::segment(3))}}",
                  type: "GET"})
                  .done(function(response){

                        this.setState({
                            data:response.data
                        });

                    }.bind(this));

                    setInterval(this.checkRequest, 5000);
            },
            checkRequest : function(){
                $.ajax({
                  url: "{{url('track/order/'.Request::segment(3))}}",
                  type: "GET"})
                  .done(function(response){
                  
                        this.setState({
                            data:response
                        });

                    }.bind(this));
            },
            render: function(){
                return (
                    <div>
                        <SwitchState checkState={this.state.data} currency={this.state.currency} />
                    </div>
                );
            }
        });

        

        var SwitchState = React.createClass({

            componentDidMount: function() {
                this.changeLabel;
            },

            changeLabel : function(){
                if(this.props.checkState == undefined){
                   // window.location.reload();
                }else if(this.props.checkState != ""){ 
                    order = this.props.checkState;
                    if(curstatus != this.props.checkState.status){
                     $('#routebtn').trigger('click');
                     curstatus = this.props.checkState.status;
                    }
                    $('#myTab li').removeClass('active');
                    $("."+this.props.checkState.status).addClass("active");
                    if(this.props.checkState.status=='COMPLETED'){
                        $('#rating_review').show();
                    }else{
                        $('#rating_review').hide();
                    }
                    setTimeout(function(){
                        //$('.rating').rating();
                    },400);

                }else{
                    $("#ride_status").text('Text will appear here');
                }
            },
            render: function(){

               

                    this.changeLabel();
                   
                    return ( 
                        <p></p>
                     );
                
            }
        });
        React.render(<MainComponent/>,document.getElementById("container"));

    @endif
    </script>


@endsection