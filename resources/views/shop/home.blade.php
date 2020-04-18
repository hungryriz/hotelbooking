@extends('shop.layouts.app')

@section('content')
 <!-- Stats -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-xs-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="p-2 text-xs-center box-primary bg-primary bg-darken-2 media-left media-middle" style="background-color: #ff6d00 !important;">
                                        <i class="fa fa-cart-arrow-down font-large-2 white"></i>
                                    </div>
                                    <div class="p-2 bg-gradient-x-primary white media-body">
                                        <h5>Orders Received</h5>
                                        <h5 class="text-bold-400"><i class="ft-plus"></i> {{$OrderReceivedToday}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-xs-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="p-2 text-xs-center bg-danger bg-darken-2 media-left media-middle">
                                        <i class="fa fa-cart-plus font-large-2 white"></i>
                                    </div>
                                    <div class="p-2 bg-gradient-x-danger white media-body">
                                        <h5>Orders Delivered</h5>
                                        <h5 class="text-bold-400"><i class="ft-arrow-up"></i>{{$OrderDeliveredToday}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-xs-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="p-2 text-xs-center bg-warning bg-darken-2 media-left media-middle">
                                        <i class="icon-basket-loaded font-large-2 white"></i>
                                    </div>
                                    <div class="p-2 bg-gradient-x-warning white media-body">
                                        <h5>Today Earnings</h5>
                                        <h5 class="text-bold-400"><i class="ft-arrow-down"></i> ${{$OrderIncomeToday}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-xs-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="p-2 text-xs-center bg-success bg-darken-2 media-left media-middle">
                                        <i class="icon-wallet font-large-2 white"></i>
                                    </div>
                                    <div class="p-2 bg-gradient-x-success white media-body">
                                        <h5>Monthly Earnings</h5>
                                        <h5 class="text-bold-400"><i class="ft-arrow-up"></i> ${{$OrderIncomeMonthly}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Stats -->
                <!--Product sale & buyers -->
                <div class="row match-height">
                    <div class="col-xl-8 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Products Sales</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block">
                                    <div id="products-sales" class="height-300"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Recent Deliveries</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body px-1">
                                <div id="recent-buyers" class="list-group height-300 position-relative">
                                    @forelse($DeliveryOrders as $Order)
                                    <a href="#" class="list-group-item list-group-item-action media no-border">
                                        <div class="media-left">
                                            <span class="avatar avatar-md avatar-online"><img class="media-object rounded-circle" src="{{asset('assets/admin/images/portrait/small/avatar-s-7.png')}}" alt="Generic placeholder image"><i></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="list-group-item-heading">{{$Order->user->name}} <span class="font-medium-4 float-xs-right pt-1">${{$Order->invoice->net}}</span></h6>
                                            <p class="list-group-item-text">
                                                <span class="tag tag-primary">Delivered</span>
                                            </p>
                                        </div>
                                    </a>
                                    @empty
                                    <a href="#">No Order Found!</a>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Product sale & buyers -->
                <!--Recent Orders & Monthly Salse -->
                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Recent Orders</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-block">
                                    <!-- <p>Total paid invoices <span>$240</span>, unpaid <span>$150</span>. <span class="float-xs-right"><a href="#" target="_blank">Invoice Summary <i class="ft-arrow-right"></i></a></span></p> -->
                                </div>
                                <div class="table-responsive">
                                    <table id="recent-orders" class="table table-hover mb-0 ps-container ps-theme-default">
                                        <thead>
                                            <tr>
                                                <th>@lang('admin.dashboard.order_id')</th>
                                                <th>@lang('admin.dashboard.customer_name')</th>
                                                <th>@lang('admin.dashboard.restaurant')</th>
                                                <th>@lang('admin.dashboard.delivery_people')</th>
                                                <th>@lang('admin.dashboard.status')</th>
                                                <th>@lang('admin.dashboard.amount')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($RecentOrders as $Order)
                                            <tr>
                                                <td class="text-truncate">{{$Order->id}}</td>
                                                <td class="text-truncate">{{$Order->user->name}}</td>
                                                <td class="text-truncate">{{$Order->shop->name}}</td>
                                                <td class="text-truncate">{{@$Order->transporter->name}}</td>
                                                <td class="text-truncate"><span class="tag tag-default tag-success">{{$Order->status}}</span></td>
                                                <td class="text-truncate">$ {{$Order->invoice->net}}</td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="6">No Order Found!</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/Recent Orders & Monthly Salse -->
@endsection
@section('scripts')
 <!-- BEGIN PAGE LEVEL JS-->
   
    <script type="text/javascript">
        var data = [ 
            @foreach($complete_cancel as $k=>$v)
                @if($v->shop_id)
                    {
                        month: "{{$v->month}}",  delivered: {{$v->delivered}}, cancelled: {{$v->cancelled}}
                    },
                @else 
                     {
                        month: "{{$v->month}}",  delivered: 0, cancelled: 0
                    },
                @endif
            @endforeach
        ];
    </script>
     <script src="{{ asset('assets/admin/js/scripts/pages/dashboard-ecommerce.min.js') }}" type="text/javascript"></script>
@endsection