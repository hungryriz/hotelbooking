@extends('user.layouts.app')

@section('content')
 <!-- Content ================================================== -->
    <div class="container margin_60_35">
        <div class="row">
            <div class="col-md-3">
                <p>
                    <a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" style="display:none">View on map</a>
                </p>
                <div id="filters_col">
                    <form action="" method="get" id="shop_filter">
                    <input type="hidden" id="v" value="grid" name="v">
                        <a data-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" id="filters_col_bt">Filters <i class="icon-plus-1 pull-right"></i></a>
                        <div class="collapse" id="collapseFilters">
                            <div class="filter_type">
                               <!--  <h6>Distance</h6>
                                <input type="text" id="range" value="" name="range"> -->
                                <input type="hidden"   value="{{Setting::get('search_distance')}}" name="range" />
                                @if(Request::has('latitude'))
                                 <input type="hidden"   value="{{Request::get('latitude')}}" name="latitude" id="latitude1" />
                                @endif
                                @if(Request::has('longitude'))
                                 <input type="hidden"   value="{{Request::get('longitude')}}" name="longitude" id="longitude1" />
                                @endif
                                @if(Request::has('search_loc'))
                                 <input type="hidden"   value="{{Request::get('search_loc')}}" name="search_loc" />
                                @endif
                                <h6>Type</h6>
                                <ul>
                                    <li>
                                        <label>
                                            <input type="checkbox" @if(!Request::get('range')) checked @endif class="icheck  search_shop">All <small>(49)</small></label>
                                    </li>
                                    @foreach($Cuisines as $key=>$Cuisine)
                                    <?php $selcusine = Request::get('cuisine'); ?>
                                    <li class="search_shop">
                                        <label>
                                            <input type="checkbox" name="cuisine[{{$key}}]" value="{{$Cuisine->id}}" @if(@$selcusine[$key]==$Cuisine->id) checked @endif  class="icheck search_shop"> {{$Cuisine->name}}<!-- <small>(12)</small> --></label><i class="color_1"></i>
                                    </li>
                                    @endforeach
                                    <li>
                                        <label>
                                            <input type="checkbox" name="pure_veg" value="1" @if(Request::get('pure_veg')==1) checked @endif  class="icheck search_shop">Pure Veg <!-- <small>(5)</small> --></label><i class="color_2"></i>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="offer" value="1" class="icheck search_shop" @if(Request::get('offer')==1) checked @endif >OFFERS <!-- <small>(7)</small> --></label><i class="color_3"></i>
                                    </li>
                                </ul>
                            </div>
                        <div class="filter_type" style="display:none">
                            <h6>Rating</h6>
                            <ul>
                                <li>
                                    <label>
                                        <input type="checkbox" class="icheck"><span class="rating">
                            <i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i>
                            </span></label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" class="icheck"><span class="rating">
                            <i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
                            </span></label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" class="icheck"><span class="rating">
                            <i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i><i class="icon_star"></i>
                            </span></label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" class="icheck"><span class="rating">
                            <i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i>
                            </span></label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" class="icheck"><span class="rating">
                            <i class="icon_star voted"></i><i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i>
                            </span></label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--End collapse -->
                    </form>
                </div>
                <!--End filters col-->
            </div>
            <!--End col-md -->
            <div class="col-md-9">
                <div id="tools">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="styled-select">
                                <select name="sort_rating" id="sort_rating">
                                    <option value="" selected>Sort by ranking</option>
                                    <option value="lower">Lowest ranking</option>
                                    <option value="higher">Highest ranking</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-9 hidden-xs">
                           <a href="{{(Request::getPathInfo() . (Request::getQueryString() ? ('?' . trim(Request::getQueryString(),'&v=map')).'&v=grid' : ''))}}" class="bt_filters"><i class="icon-th"></i></a>
                            <a href="{{(Request::getPathInfo() . (Request::getQueryString() ? ('?' . trim(Request::getQueryString(),'&v=map')) : ''))}}" class="bt_filters"><i class="icon-list"></i></a>
                        </div>
                    </div>
                </div>
                <!--End tools -->
                <div class="row">
                    <!-- Position -->
                        <div class="collapse" id="collapseMap">
                            <div id="map" class="map"></div>
                        </div>
                  </div>
            </div>
            <!-- End col-md-9-->
        </div>
        <!-- End row -->
    </div>
    <!-- End container -->
@endsection
@section('scripts')
<script type="text/javascript">
    $('input').on('ifChanged', function (event) {  $('#shop_filter').submit(); })
</script>
<script>
    var map;
    var input = document.getElementById('pac-input');
    var latitude = document.getElementById('latitude');
    var longitude = document.getElementById('longitude');
    var address = document.getElementById('address');

    function initMap() { 

        var userLocation = new google.maps.LatLng(
                13.0796758,
                80.2696968
            );

        map = new google.maps.Map(document.getElementById('my_map'), {
            center: userLocation,
            zoom: 15
        });

        var service = new google.maps.places.PlacesService(map);
        var autocomplete = new google.maps.places.Autocomplete(input);
        var infowindow = new google.maps.InfoWindow();

        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow({
            content: "Shop Location",
        });

        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });

        marker.setVisible(true);
        marker.setPosition(userLocation);
        infowindow.open(map, marker);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(location) {
                var userLocation = new google.maps.LatLng(
                    location.coords.latitude,
                    location.coords.longitude
                );
                marker.setPosition(userLocation);
                map.setCenter(userLocation);
                map.setZoom(13);
            });
        }

        google.maps.event.addListener(map, 'click', updateMarker);
        google.maps.event.addListener(marker, 'dragend', updateMarker);

        function updateMarker(event) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': event.latLng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        input.value = results[0].formatted_address;
                        updateForm(event.latLng.lat(), event.latLng.lng(), results[0].formatted_address);
                    } else {
                        alert('No Address Found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });

            marker.setPosition(event.latLng);
            map.setCenter(event.latLng);
        }

        autocomplete.addListener('place_changed', function(event) {
            marker.setVisible(false);
            var place = autocomplete.getPlace();

            if (place.hasOwnProperty('place_id')) {
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }
                updateLocation(place.geometry.location);
            } else {
                service.textSearch({
                    query: place.name
                }, function(results, status) {
                    if (status == google.maps.places.PlacesServiceStatus.OK) {
                        updateLocation(results[0].geometry.location, results[0].formatted_address);
                        input.value = results[0].formatted_address;
                    }
                });
            }
        });

        function updateLocation(location) {
            map.setCenter(location);
            marker.setPosition(location);
            marker.setVisible(true);
            infowindow.open(map, marker);
            updateForm(location.lat(), location.lng(), input.value);
        }

        function updateForm(lat, lng, addr) {
            console.log(lat,lng, addr);
            latitude.value = lat;
            longitude.value = lng;
            address.value = addr;
        }
    }

</script>
<script>
    markersData = {
        @forelse($Shops as $Shop)
            '{{$Shop->id}}': [
            {
                name: '{{$Shop->name}}',
                location_latitude: {{$Shop->latitude}}, 
                location_longitude: {{$Shop->longitude}},
                map_image_url: '',
                name_point: '{{$Shop->name}}',
                type_point: '{{$Shop->veg==1?"Veg":"Non-Veg"}}',
                @if(@$Shop->timings[0]->day == 'ALL')
                description_point: '{{$Shop->address}}<br><strong>Opening time</strong>: {{$Shop->timings[0]->start_time}}-{{$Shop->timings[0]->end_time}}',
                @else
                description_point: '{{$Shop->address}}<br><strong>Opening time</strong>: {{$Shop->timings[0]->start_time}}-{{$Shop->timings[0]->end_time}}',
                @endif
                url_point: '{{url("restaurant/details?name=".$Shop->name)}}'
            }
            ],
        @empty

        @endforelse
    };
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{Setting::get('GOOGLE_MAP_KEY')}}&libraries=places&callback=initMap" ></script>
<script src="{{ asset('assets/user/js/map.js')}}"></script>
<script src="{{ asset('assets/user/js/infobox.js')}}"></script>
<script type="text/javascript">
    $( ".btn_map" ).trigger( "click" );
</script>
@endsection