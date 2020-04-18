@extends('shop.layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Dispatcher</h4>
        <br>
    </div>
</div>
<div class="row">
    <div class="col-md-4">

        <div class="card-box">
        	<h4 class="m-t-0 m-b-20 header-title"><b>User Details</b></h4>
            <div class="search-item">
                <div class="media">
                    <div class="media-left">
                    	<img class="media-object img-circle" src="{{ asset($Order->user->avatar ? : 'avatar.png') }}">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                    		{{ $Order->user->first_name }} {{ $Order->user->last_name }}
                        </h4>
                        <p>
                            <b>Phone:</b> 
                            <br>
                            <span>{{ $Order->user->phone }}</span>
                        </p>
                        <p>
                            <b>Email:</b> 
                            <br>
                            <span>{{ $Order->user->email }}</span>
                        </p>
                        <p>
                            <b>Delivery Address:</b>
                            <br>
                            <span class="text-muted">{{ $Order->address->map_address }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-box">
            <h4 class="m-t-0 m-b-20 header-title"><b>Order</b></h4>
            
            <div class="inbox-widget nicescroll" style="overflow: hidden; outline: none; height: 200px;" tabindex="5000">
                @forelse($Order->items as $Item)
                <a href="{{ route('shop.products.show', $Item->id) }}">
                    <div class="inbox-item">
                        <div class="inbox-item-img">
                        	<img src="{{ asset($Item->product->images->isEmpty() ? 'avatar.png' : $Item->product->images[0]->url) }}">
                        </div>
                        <p class="inbox-item-author">{{ $Item->product->parent->name }}</p>
                        <p class="inbox-item-author">{{ $Item->product->name }}</p>
                        <p class="inbox-item-date">Qty : {{ $Item->quantity }}</p>
                    </div>
                </a>
                @empty
                <h4>No Items here, Looks like an invalid order</h4>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="box bg-white steps">
            <div class="box-block">
                <div class="s-numbers">
                    <div class="row">
                        <div class="col-xs-2">
                            <div class="s-number complete" id="step-1">
                                <span class="sn-icon">
                                    <i class="ti-check"></i>
                                </span>
                                <div class="sn-text">RECEIVED</div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="s-number text-xs-center" id="step-2">
                                <span class="sn-icon">2</span>
                                <div class="sn-text">PROCESSING</div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="s-number text-xs-center" id="step-3">
                                <span class="sn-icon">3</span>
                                <div class="sn-text">REACHED SHOP</div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="s-number text-xs-center" id="step-4">
                                <span class="sn-icon">4</span>
                                <div class="sn-text">PICKEDUP ORDER</div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="s-number text-xs-center" id="step-5">
                                <span class="sn-icon">5</span>
                                <div class="sn-text">ORDER ARRIVED</div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="s-number text-xs-right" id="step-6">
                                <span class="sn-icon">6</span>
                                <div class="sn-text">COMPLETED</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(in_array($Order->status, ['PROCESSING','REACHED','PICKEDUP','ARRIVED']) && status_next($Order->status))
                <hr>
                <h4>Update Status</h4>
                <form action="{{ route('admin.orders.update', $Order->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field("PATCH") }}
                    <input type="hidden" name="status" value="{{ status_next($Order->status) }}">
                    <button class="btn btn-info btn-block">
                        {{ status_next($Order->status) }}
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        @if(in_array($Order->status, ['RECEIVED']))
        <div class="card-box" style="max-height: 300px; overflow: auto;">
            <h4 class="m-t-0 m-b-20 header-title"><b>Transporters Nearby</b></h4>
            @forelse($Transporters as $Transporter)
            <div class="card-box inbox-widget col-xl-3 col-md-6 col-sm-6 col-xs-12" style="background-color: honeydew;">
                <div class="inbox-item" style="border: 0;">
                    <div class="col-xs-9">
                        <div class="inbox-item-img">
                            <img src="{{ asset( $Transporter->avatar ? : 'avatar.png') }}" class="img-circle" alt="" />
                        </div>
                        <p class="inbox-item-author">{{ $Transporter->first_name }} {{ $Transporter->last_name }}</p>
                        <p class="inbox-item-text">{{ $Transporter->email }}</p>
                        <p class="inbox-item-text">{{ $Transporter->phone }}</p>
                    </div>
                    <div class="col-xs-3">
                        <form action="{{ route('shop.orders.update', $Order->id) }}" id="assign-{{ $Transporter->id }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field("PATCH") }}
                            <input type="hidden" name="transporter_id" value="{{ $Transporter->id }}">
                            <button class="btn btn-info">
                                <i class="fa fa-2x fa-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div>
                <h4>No providers around!</h4>
            </div>
            @endforelse
        </div>
        @else
        <div class="card-box">
            <h4 class="m-t-0 m-b-20 header-title"><b>Transporter Details</b></h4>
            <div class="search-item">
                <div class="media">
                    <div class="media-left">
                        <a href="{{ route('shop.transporters.show', $Order->transporter->id) }}">
                            <img class="media-object img-circle" src="{{ asset($Order->transporter->avatar ? : 'avatar.png') }}">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="{{ route('shop.transporters.show', $Order->transporter->id) }}">
                                {{ $Order->transporter->first_name }} {{ $Order->transporter->last_name }}
                            </a>
                        </h4>
                        <p>
                            <b>Phone:</b> 
                            <br>
                            <span>{{ $Order->transporter->phone }}</span>
                        </p>
                        <p>
                            <b>Email:</b> 
                            <br>
                            <span>{{ $Order->transporter->email }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="card-box">
            <h4 class="m-t-0 m-b-20 header-title"><b>Map</b></h4>
            
            <div id="gmaps" class="gmaps"></div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style type="text/css">
	.media-object.img-circle {
		width: 64px;
		height: 64px;
	}
</style>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/admin/js/order-map.js') }}"></script>
<script type="text/javascript">
    var trip = {!! json_encode($Order) !!};
    function initMap() {
        if(['PROCESSING', 'REACHED', 'PICKEDUP', 'ARRIVED'].indexOf(trip.status) != -1) {
            ongoingInitialize(trip);
        } else if(trip.status == 'RECEIVED') {
            providers = {!! json_encode($Transporters) !!};
            assignProviderMap(providers, trip);
        } else {
            addressMapInitialize(trip);
        }
    }

    function updateStatus(status) {

        var step1 = $("#step-1");
        var step2 = $("#step-2");
        var step3 = $("#step-3");
        var step4 = $("#step-4");
        var step5 = $("#step-5");
        var step6 = $("#step-6");

        $('.s-number').each(function(index, element) {
            if($(element).hasClass('active')) {
                $(element).removeClass('active');
            }
            if($(element).hasClass('complete')) {
                $(element).removeClass('complete');
            }
        });

        switch(status) {
            case 'RECEIVED':
                complete([step1]);
                step2.addClass('active');
                break;
            case 'CANCELLED':
                complete([step1]);
                step2.addClass('active');
                break;
            case 'PROCESSING':
                complete([step1, step2]);
                step3.addClass('active');
                break;
            case 'REACHED':
                complete([step1, step2, step3]);
                step4.addClass('active');
                break;
            case 'PICKEDUP':
                complete([step1, step2, step3, step4]);
                step5.addClass('active');
                break;
            case 'ARRIVED':
                complete([step1, step2, step3, step4, step5]);
                step6.addClass('active');
                break;
            case 'COMPLETED':
                complete([step1, step2, step3, step4, step5, step6]);
                break;
            default:
                complete([step1]);
                step2.addClass('active');
        }

        function complete(elements) {
            $(elements).each(function(index, element) {
                $(element).addClass('complete');
                $(element).find('.sn-icon').html('<i class="ti-check"></i>');
            })
        }

    }
    updateStatus(trip.status);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initMap" async defer></script>
@endsection