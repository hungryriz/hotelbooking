@extends('admin.layouts.app')

@section('content')
<div class="row m-0 col-md-12">
    <form>
        <div class="form-group col-md-6">
            <label>Order Id</label>
            <input type="number" name="order_id" value="{{Request::get('order_id')}}" class="form-control"/>
        </div>
        <div class="form-group col-md-6">
            <label>Status</label>
            <select class="form-control" name="status" id="dispute_order_status">
                <option value="CANCELLED" @if(Request::get('status')=='CANCELLED') selected @endif  >Cancelled</option>
                <option value="REFUND" @if(Request::get('status')=='REFUND') selected @endif  >Refund</option>
                <option value="COMPLAINED" @if(Request::get('status')=='COMPLAINED') selected @endif >Complained</option>
            </select>
        </div>
        <input type="submit" class="btn btn-success" value="Search"  />
        <a href="{{Request::url()}}" class="btn btn-success"  />Reset</a>
    </form>
</div>
<!-- stat timeline and feed  -->
                <div class="row m-0 @if(Request::segment(3) == 'user') user-bg @elseif(Request::segment(3) == 'shop') restaurant-bg @else  deliver-bg  @endif">
                    <div class="col-md-6 p-0">
                        <div class="widgets-container dis-tab order-list-section win-height row m-0">
                            <div class="col-md-4">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item @if(Request::get('status')=='CANCELLED') active @endif " >
                                        <a class="nav-link " id="li_tab-1" data-toggle="tab" href="#tab-1" role="tab">Cancelled</a>
                                    </li>
                                    @if(Request::segment(3) == 'user')
                                    <li class="nav-item @if(Request::get('status')=='REFUND') active @endif ">
                                        <a class="nav-link" id="li_tab-2" data-toggle="tab" href="#tab-2" role="tab">Refund</a>
                                    </li>
                                    @endif
                                    <li class="nav-item dropdown   @if(Request::get('status')=='COMPLAINED') active @endif">
                                        <a class="nav-link" id="li_tab-3" data-toggle="tab" href="#tab-3" role="tab">Complaints</a>
                                    </li>
                                </ul>
                            </div>
                             <?php $can_inx = $ref_inx = $comp_inx =0; ?>
                            <div class="col-md-8">
                                <div class="tab-content dis-tab-content">
                                    <div class="tab-pane active" id="tab-1">
                                        <div class="tab-head">
                                            <h3 class="tab-head-tit">Cancelled Orders</h3>
                                        </div>
                                        <div class="order-box-section">
                                            @foreach($OrderDispute as $Dispute)
                                                @if($Dispute->type == 'CANCELLED')
                                                <?php $can_inx++; ?>
                                                    <!-- Order Details Row Starts -->
                                                    <a href="javascript:void(0);"  data-id="{{$Dispute->id}}" class="disputedetails order-box @if($can_inx==1) active @endif">
                                                    <br/>
                                                        <h3>{{$Dispute->order->user->name}}</h3>
                                                        <p>#{{$Dispute->order->id}}</p>
                                                        <p class="order-box-txt">{{$Dispute->description}} </p>
                                                        <button class="tab-btn theme-btn orderlist" data-id="{{$Dispute->order_id}}" >Order Details</button>
                                                        <span class="order-badge label red-bg">{{$Dispute->type}}</span>
                                                    </a>
                                                    <!-- Order Details Row Ends -->
                                                @endif
                                            @endforeach
                                            @if($can_inx==0)
                                            <div> No Dispute Order!</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-2">
                                        <div class="tab-head">
                                            <h3 class="tab-head-tit">Refund Orders</h3>
                                        </div>
                                        <div class="order-box-section">
                                            @foreach($OrderDispute as $Dispute)
                                                @if($Dispute->type == 'REFUND')
                                                    <?php $ref_inx++; ?>
                                                    <!-- Order Details Row Starts -->
                                                    <a href="javascript:void(0);"  data-id="{{$Dispute->id}}" class="disputedetails order-box @if($ref_inx==1) active @endif">
                                                    <br/>
                                                        <h3>{{$Dispute->order->user->name}}</h3>
                                                        <p>#{{$Dispute->order->id}}</p>
                                                        <p class="order-box-txt">{{$Dispute->description}} </p>
                                                        <button class="tab-btn theme-btn orderlist" data-id="{{$Dispute->order_id}}">Order Details</button>
                                                        <span class="order-badge label red-bg">{{$Dispute->type}}</span>
                                                    </a>
                                                    <!-- Order Details Row Ends -->
                                                @endif
                                            @endforeach
                                             @if($ref_inx==0)
                                            <div> No Dispute Order!</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-3">
                                        <div class="tab-head">
                                            <h3 class="tab-head-tit">Complaints</h3>
                                        </div>
                                        <div class="order-box-section">
                                            @foreach($OrderDispute as $Dispute)
                                                @if($Dispute->type == 'COMPLAINED')
                                                    <?php $comp_inx++; ?>
                                                    <!-- Order Details Row Starts -->
                                                    <a href="javascript:void(0);"  data-id="{{$Dispute->id}}" class="disputedetails order-box @if($comp_inx==1) active @endif">
                                                    <br/>
                                                        <h3>{{$Dispute->order->user->name}}</h3>

                                                        <p>#{{$Dispute->order->id}}</p>
                                                        <p class="order-box-txt">{{$Dispute->description}} </p>
                                                        <button class="tab-btn theme-btn orderlist" data-id="{{$Dispute->order_id}}">Order Details</button>
                                                        <span class="order-badge label red-bg">{{$Dispute->type}}</span>
                                                    </a>
                                                    <!-- Order Details Row Ends -->
                                                @endif
                                            @endforeach
                                             @if($comp_inx==0)
                                            <div> No Dispute Order!</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Order Details Section Starts -->
                    <div class="col-md-3 p-0" id="orderdetails_disputes">
                        <div class="widget order-details-section win-height">
                            <div class="sec-head">
                                <h3 class="com-tit">Order Details</h3>
                            </div>
                            <div class="order-det-top">
                                <a href="#" class="arrow-btn arrow-btn1">{{Request::segment(3)}}</a>
                                <a href="#" class="arrow-btn arrow-btn2 dis_to"></a>
                            </div>
                            <!-- Order Details Section Center Starts -->
                            <div class="order-det-center">
                                <div>
                                    <h4 class="order-det-tit">Customer Name</h4>
                                    <p class="order-det-txt cust_name">John Doe</p>
                                </div>
                                <div>
                                    <h4 class="order-det-tit">Delivery Name</h4>
                                    <p class="order-det-txt deli_name">Paul Wesley</p>
                                </div>
                                <div>
                                    <h4 class="order-det-tit">Restaurant</h4>
                                    <p class="order-det-txt rest_name">Burger King</p>
                                </div>
                                <div>
                                    <a class="order-det-txt chat" target="_blank" href="">Click To Chat</a>
                                </div>
                                <div>
                                    <h4 class="order-det-tit">Address</h4>
                                    <p class="order-det-txt address">71,Pilgrim Avenue
                                        <br> Chevy Chase,
                                        <br> MD 20815</p>
                                </div>
                            </div>
                            <div class="note-block m-b-15">
                                <h4 class="com-txt">Note:</h4>
                                <p class="com-txt dis_message">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                            <!-- / ibox-title -->
                            <div id="demo1" class="ibox-content collapse show m-b-15">
                                <h4 class="com-txt">Invoice</h4>
                                <div class="table-scrollable">
                                    <table class="table table-hover invoice_mylist">
                                        <tbody>
                                            <tr>
                                                <td> Burger </td>
                                                <td> $220 </td>
                                            </tr>
                                            <tr>
                                                <td> Cheese Pizza </td>
                                                <td> $220 </td>
                                            </tr>
                                            <tr>
                                                <td> Sandwich </td>
                                                <td> $220 </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b>$660</b></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- Order Details Section Center Ends -->
                        </div>
                    </div>
                    <!-- Order Details Ends -->
                    <!-- Change Order Section Starts -->
                    <div class="col-md-3 p-0" id="handle_dispute">
                        <div class="widget order-change-section win-height">
                            <div class="sec-head">
                                <h3 class="com-tit">Handle Dispute</h3>
                            </div>
                            <div class="handle-block">
                                <form method="POST" action="1">
                                    <h4 class="com-txt"> Order Status</h4>
                                    <div class="form-group">
                                        <select name="status" id="order_status" class="form-control">
                                            <option value="ORDERED">ORDERED</option>
                                            <option value="RECEIVED">RECEIVED</option>
                                            <option value="ASSIGNED">ASSIGNED</option>
                                            <option value="PROCESSING">PROCESSING</option>
                                            <option value="REACHED">REACHED</option>
                                            <option value="PICKEDUP">PICKEDUP</option>
                                            <option value="ARRIVED">ARRIVED</option>
                                            <option value="COMPLETED">COMPLETED</option>
                                            <option value="CANCELLED">CANCELLED</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-danger">Change Status</button>
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <input type="hidden" value="" name="dispute_id" class="dispute_id" >
                                </form>
                            </div>
                            <div class="handle-block">
                                <form method="POST" action="2">
                                    <h4 class="com-txt">Refund</h4>
                                    <div class="form-group">
                                        <input type="number" name="price" class="form-control" value="" />
                                    </div>
                                    <button class="btn theme-btn">Cancel & Refund</button><br>
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <span class="note-txt">The money added to user wallet</span>
                                    <input type="hidden" value="" name="dispute_id" class="dispute_id" >
                                </form>
                            </div>
                            <div class="handle-block">
                                <form method="POST" action="3">
                                    <h4 class="com-txt">Order Edit Note</h4>
                                    <div class="form-group">
                                        <textarea class="form-control" name="description" rows="3"></textarea>
                                    </div> 
                                    <button class="btn theme-btn">Update</button>
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <input type="hidden" value="" name="dispute_id" class="dispute_id" >
                                </form>
                            </div>
                            <div class="handle-block">
                                <form method="POST" action="4">
                                    <h4 class="com-txt">Complaint Status</h4>
                                    <button class="btn btn-success">Resolved</button>
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <input type="hidden" value="RESOLVED" name="dispute_status" class="dispute_id" >
                                    <input type="hidden" value="" name="dispute_id" class="dispute_id" >
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Change Order section Ends -->
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
                                    <dd class="col-sm-9 order-txt ">  -- </dd>
                                </div>
                            </dl>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
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
@endsection
@section('scripts')
<script src="{{ asset('assets/js/jquery.time-to.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('.disputedetails').on('click',function(){
        var dispute_id = $(this).data('id');
         $('.order-box').removeClass('active');
         $(this).addClass('active');
        $.ajax({
                url: "{{url('admin/dispute')}}/"+dispute_id,
                type:'GET',
                //data:{ phone : countryCode+''+phoneNumber,'_token':csrf },
                success: function(data) { 
                    var orderstatuslist = ["ORDERED","RECEIVED","ASSIGNED","PROCESSING","REACHED","PICKEDUP","ARRIVED","COMPLETED"];
                    $('#handle_dispute').show();
                    $('#orderdetails_disputes').show();
                    $('.cust_name').html(data.order.user.name);
                    var status_order ='';
                    $.each( orderstatuslist, function( key, value ) {
                        if(orderstatuslist.length>0){
                            if(data.order.status == value){
                                status_order += "<option value='"+value+"' >"+value+"</option>";
                               orderstatuslist = [];
                            }else{
                                status_order += "<option value='"+value+"' >"+value+"</option>";
                                
                            }
                        }
                    });
                    status_order += "<option value='CANCELLED' >CANCELLED</option>";
                    $('#order_status').html(status_order);
                    if(data.order.transporter){
                        $('.deli_name').html(data.order.transporter.name);
                    }else{
                        $('.deli_name').html('--');
                    }
                    $('.rest_name').html(data.order.shop.name);
                    $('.chat').attr('href','{{url("admin/chat?dispute_id=")}}'+dispute_id);
                    $('.address').html(data.order.address.building+'<br/>'+data.order.address.map_address);
                    $('.dis_message').html(data.description); 
                    $('.dispute_id').val(data.id);
                    $('#order_status option[value="'+data.order.status+'"]').attr('selected', true);
                    $('.dis_to').html(data.created_to);
                    $('#handle_dispute').find('form').each(function(){
                        $(this).attr('action','{{url("admin/dispute/")}}/'+data.id);
                    });
                   
                },
                error:function(jqXhr,status){ 
                   /* if( jqXhr.status === 422 ) {
                        $(".print-error-msg").show();
                        var errors = jqXhr.responseJSON; 

                        $.each( errors , function( key, value ) { 
                            $(".print-error-msg").find("ul").append('<li>'+value[0]+'</li>');
                        });
                    } */
                }
            });
    });

    $('.orderlist').on('click',function(){ 
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
            $('.tot_amt').html('<span>: </span> {{Setting::get("currency")}}'+result.Order.invoice.net);
            $('.discount').html("<span>: </span> {{Setting::get('currency')}}"+result.Order.invoice.discount);
            $('.delivery_charge').html("<span>: </span> {{Setting::get('currency')}}"+result.Order.invoice.delivery_charge);
            $('.tax').html("<span>: </span> {{Setting::get('currency')}}"+result.Order.invoice.tax);
            var statuslist='';
            $.each( result.Order.ordertiming, function( key, value ) {
                statuslist+='<dd class="col-sm-3 order-txt p-0">'+value.status+'</dd>\
                <dd class="col-sm-9 order-txt "> '+value.created_at+'</dd>';
            });
            $('#order_status_list').html(statuslist);
            var table = '';
            $.each( result.Cart, function( key, value ) {
                /*<div class="bg-img order-img" style="background-image: url('+value.product.images[0].url+');"></div>*/
                table += '<tr><td>'+value.product.name+'</td><td>'+value.product.prices.price+'</td><td>'+value.quantity+'</td><td>'+(value.quantity*value.product.prices.price)+'</td></tr>';
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
</script>

<script>
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('#handle_dispute').hide();
        $('#orderdetails_disputes').hide();
        var target = $(e.target).attr("href") // activated tab

        $(target).find(".disputedetails").eq(0).trigger("click");
        if(target == '#tab-3'){  
            $('#dispute_order_status').find('option[value="COMPLAINED"]').prop("selected",true);
        }
        if(target == '#tab-2'){  
            $('#dispute_order_status').find('option[value="REFUND"]').prop("selected",true);
        }
        if(target == '#tab-1'){  
            $('#dispute_order_status').find('option[value="CANCELLED"]').prop("selected",true);
        }
    });
    @if(Request::get('status')=='COMPLAINED')
        $('#li_tab-3').trigger("click");
    @elseif(Request::get('status')=='CANCELLED')
        $('#li_tab-1').trigger("click");
    @elseif(Request::get('status')=='REFUND')
        $('#li_tab-2').trigger("click");
    @else
        $('#li_tab-1').trigger("click");
    @endif

    @if($can_inx==0)
        $('#handle_dispute').hide();
        $('#orderdetails_disputes').hide();
    @endif

</script>



@endsection
