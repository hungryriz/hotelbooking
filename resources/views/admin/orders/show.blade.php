@extends('admin.layouts.app')

@section('content')
<?php $first_transporter=0; ?>
    <div class="card">
        <ul class="nav nav-tabs row m-0 common-tab">
            <div class="col-sm-3 p-0">
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}?t=pending" class="nav-link @if(Request::get('t')=='pending') active  @endif">Pending Orders</a>
                </li>
            </div>
            <div class="col-sm-3 p-0">
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}?t=accepted" class="nav-link @if(Request::get('t')=='accepted') active  @endif">Accepted Orders</a>
                </li>
            </div>
            <div class="col-sm-3 p-0">
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}?t=ongoing" class="nav-link @if(Request::get('t')=='ongoing') active  @endif">Ongoing Orders</a>
                </li>
            </div>
            <div class="col-sm-3 p-0">
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}?t=cancelled" class="nav-link @if(Request::get('t')=='cancelled') active  @endif">Cancelled Orders</a>
                </li>
            </div>
        </ul>
        <div class="card-header">
            <h3 class="card-title">Available Delivery Peoples</h3>
        </div>
        <!-- Pending Order List Starts -->
        <div class="dispatcher row m-0">
            <!-- Dispatcher Left Starts -->
            <div class="col-md-7">
                <div class="dis-left">
                    @forelse($Transporters as $indx=>$Transporter)
                     <!-- Pending Order Block Starts -->
                     <?php if($indx==0){ $first_transporter = $Transporter->id; } ?>
                         <div class="card card-inverse pending-block row m-0 bg-primary">
                            <div class="card-block">
                                <div class="col-sm-3 card-top text-xs-center">
                                    <div class="pending-dp-img bg-img" style="background-image: url({{ asset( $Transporter->avatar ? : 'avatar.png') }});"></div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="card-btm pending-btm">
                                        <p class="card-txt">{{ $Transporter->name }}</p>
                                        <p class="card-txt"> --
                                        </p>
                                        <p class="card-txt">{{ $Transporter->phone }}</p>
                                    </div>
                                    <div class="card-btm row m-0">
                                        <form action="{{ route('admin.orders.update', $Order->id) }}" id="assign-{{ $Transporter->id }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field("PATCH") }}
                                            <input type="hidden" name="transporter_id" value="{{ $Transporter->id }}">
                                            <input type="hidden" name="status" value="ASSIGNED">
                                            <button class="btn btn-primary btn-darken-3">
                                                Assign
                                            </button>
                                        </form>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div>
                            <h4>No providers around!</h4>
                        </div>
                    @endforelse
                    <!-- Pending Order Block Ends -->
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

<!--for map -->
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/vendors/js/charts/gmaps.min.js')}}" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL JS-->
<script src="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/js/scripts/charts/gmaps/maps.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL JS-->
<script>

    var locations = [
        @forelse(@$Transporters as $indx => $addr)
            ["{{$addr->name}}", {{$addr->latitude}}, {{$addr->longitude}}, "{{$addr->id}}"],
        @empty
        @endforelse
    ];

    function initialize() {

        var myOptions = {
          center: new google.maps.LatLng(33.890542, 151.274856),
          zoom: 17,
          mapTypeId: google.maps.MapTypeId.ROADMAP

        };
        var map = new google.maps.Map(document.getElementById("basic-map1"),
            myOptions);

        setMarkers(map,locations)

    }



    function setMarkers(map,locations){

        var marker, i

        for (i = 0; i < locations.length; i++)
         {  

         var loan = locations[i][0]
         var lat = locations[i][1]
         var long = locations[i][2]
         var add =  locations[i][3]

         latlngset = new google.maps.LatLng(lat, long);

          var marker = new google.maps.Marker({  
                  map: map, title: loan , position: latlngset  
                });
                map.setCenter(marker.getPosition())


                var content = '<a href="javascript:void(0)" data-id="'+add+'" class="assignorder" > ' + loan +  '</a>';    

          var infowindow = new google.maps.InfoWindow()

        google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
                return function() {
                   infowindow.setContent(content);
                   infowindow.open(map,marker);
                };
            })(marker,content,infowindow)); 

          }
    }
initialize();
$(document).on('click','.assignorder',function(){
    var id= $(this).data('id');
    $('#assign-'+id).submit();
});

@if(@Request::get('p')) 
    @if($first_transporter!=0)
        $('#assign-'+{{$first_transporter}}).submit();
    @endif
@endif
</script>
@endsection