@extends('shop.layouts.app')

@section('content')
  <div class="card">
    <div class="card-header">
        <h4 class="card-title">Deliveries</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form>
            <input type="hidden" name="list" value="true" />
            <input type="hidden" name="all" value="{{Request::get('all')}}" />
            <div class="form-group col-xs-12 mb-2">
                
                    <label>Delivery People</label>
                    <select id="user_name" name="dp" class="form-control">
                         <option value=""   >Select</option>
                        @forelse($Providers as $id=>$name)
                            <option value="{{$id}}"  @if(Request::get('dp')==$id) selected  @endif  >{{$name}}</option>
                        @empty
                        @endforelse
                    </select>
                
            </div>
            <div class="form-group col-xs-12 ">
                <div class="form-group col-xs-6 ">
                    <label>Start Date</label>
                    <input type="text" id="date" required  readonly name="start_date" value="{{Request::get('start_date')}}" class="form-control datepicker"/>
                </div>
                <div class="form-group col-xs-6 ">
                    <label>End Date</label>
                    <input type="text" id="date" required  readonly name="end_date" value="{{Request::get('end_date')}}" class="form-control datepicker"/>
                </div>
            </div>
            <button class="pull-right btn btn-success">Search</button>
            </form>
        </div>
        <?php $total_earning = $total_gross = $total_delivery = 0; ?>
        <div class="card-block card-dashboard table-responsive">
            <table class="table table-striped table-bordered file-export">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Customer Name</th>
                        <th>Delivery People</th>
                        <th>Restaurant</th>
                        <th>Address</th>
                        <th>Cost</th>
                        <th>Status</th>
                        <th>Order List</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($Orders as $Index => $Order)
                    <?php $total_earning +=$Order->invoice->net;
                          $total_gross +=$Order->invoice->gross;
                          $total_delivery +=$Order->invoice->delivery_charge;
                     ?>
                    <tr>
                        <td>{{ $Index + 1 }}</td>
                        <td>{{ $Order->user->name }}</td>
                        <td>
                            {{ @$Order->transporter->name }}
                        </td>
                        <td>{{ @$Order->shop->name }}</td>
                        <td>{{ @$Order->address->building }}</td>
                        <td>{{Setting::get('currency')}}{{ @$Order->invoice->net }}</td>
                        <td><span class="tag tag-success">{{$Order->status}}</span></td>
                        <td>
                            <button class="btn btn-primary btn-darken-3 tab-order orderlist" data-id="{{$Order->id}}" >Order List</button>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-block">
        <h3>Total Earning:- </h3>
        @if(count($Orders)>0)
        <?php 

            $total_food_commision = $total_gross*(Setting::get('COMMISION_OVER_FOOD')/100);
            $total_delivery_commision = $total_delivery*(Setting::get('COMMISION_OVER_DELIVERY_FEE')/100);
        ?>
            <div class="row m-0">
                <dt class="col-sm-3 order-txt p-0">Total Earning</dt>
                <dd class="col-sm-9 order-txt "><span>: {{currencydecimal($total_earning)}}</span></dd>
            </div>
            <div class="row m-0">
                <dt class="col-sm-3 order-txt p-0">Commision from Food Items</dt>
                <dd class="col-sm-9 order-txt "><span>: {{currencydecimal($total_food_commision)}}</span> </dd>
            </div>
            <div class="row m-0">
                <dt class="col-sm-3 order-txt p-0">Commision from Delivery Charge</dt>
                <dd class="col-sm-9 order-txt "><span>: {{currencydecimal($total_delivery_commision)}}</span> </dd>
            </div>
            <div class="row m-0">
                <dt class="col-sm-3 order-txt p-0">Total Commision </dt>
                <dd class="col-sm-9 order-txt "><span>: {{currencydecimal($total_food_commision+$total_delivery_commision)}}</span> </dd>
            </div>
        @endif
        </div>
    </div>
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
                                    <th></th>
                                    <th>Discount</th>
                                    <th class="discount"> {{Setting::get("currency")}} 1600</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Delivery Charge</th>
                                    <th class="delivery_charge"> {{Setting::get("currency")}} 1600</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Tax</th>
                                    <th class="tax"> {{Setting::get("currency")}} 1600</th>
                                </tr>
                                <tr>
                                    <th></th>
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
<script type="text/javascript" src="{{ asset('assets/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
 <script src="{{ asset('assets/js/jquery.time-to.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$('.datepicker').datepicker();
$('.orderlist').on('click',function(){ 
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
</script> 

@endsection

@section('styles')


@endsection