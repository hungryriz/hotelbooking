@extends('admin.layouts.app')

@section('content')
<div class="card-box table-responsive">
    <h4 class="m-t-0 header-title">
        <b>Edit Zone</b>
    </h4>
    <hr/>

    <div class="row">
        <div class="col-sm-12">
            <input tabindex="2" id="pac-input" class="form-control" type="text" placeholder="Enter a Zone" name="name" value="{{ old('name', $Zone->name) }}">
        </div>
        <div class="col-xs-12 m-t-10">
            <div id="map"></div>
        </div>
    </div>

    <div class="row m-t-5">
        <div class="col-xs-6 col-md-3 text-center">
            <a href="{{ route('admin.zones.index') }}" class="btn btn-danger btn-block">
                Cancel
            </a>
        </div>
        <div class="col-xs-6 col-md-3 col-md-offset-6 text-center">
            <button class="btn btn-success btn-block" type="submit" form="district">Submit</button>
        </div>
    </div>

    <form id="Zone" class="form-horizontal" action="{{ route('admin.zones.update', $Zone->id) }}" method="post" role="form">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <input type="hidden" id="address" name="name" value="{{old('address')}}" readonly required>
        <input type="hidden" id="north_east_lat" name="north_east_lat" value="{{ old('north_east_lat', $Zone->north_east_lat) }}" readonly required>
        <input type="hidden" id="north_east_lng" name="north_east_lng" value="{{ old('north_east_lng', $Zone->north_east_lng) }}" readonly required>
        <input type="hidden" id="south_west_lat" name="south_west_lat" value="{{ old('south_west_lat', $Zone->south_west_lat) }}" readonly required>
        <input type="hidden" id="south_west_lng" name="south_west_lng" value="{{ old('south_west_lng', $Zone->south_west_lng) }}" readonly required>
    </form>
</div>
@endsection

@section('scripts')
<script>
    var map;
    var input = document.getElementById('pac-input');
    var address = document.getElementById('address');
    var north_east_lat = document.getElementById('north_east_lat');
    var north_east_lng = document.getElementById('north_east_lng');
    var south_west_lat = document.getElementById('south_west_lat');
    var south_west_lng = document.getElementById('south_west_lng');

    function initMap() {

        var userLocation = {
            lat: 22.33728,
            lng: 114.14737549999995
        };

        var userLocation = new google.maps.LatLng(userLocation);

        map = new google.maps.Map(document.getElementById('map'), {
            center: userLocation,
            zoom: 15
        });

        var service = new google.maps.places.PlacesService(map);
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);

        var rectangle = new google.maps.Rectangle({
            editable: true,
            draggable: true
        });

        autocomplete.addListener('place_changed', function(event) {
            var place = autocomplete.getPlace();
            searchAddress(input.value);
        });

        function searchAddress(address) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                    'address': address
                },
                function(response, status) {
                    if (!response || status != google.maps.GeocoderStatus.OK) {
                        alert(address + " not found");
                    } else {
                        console.log('Search Response', response);
                        console.log('Selected Response', response[0]);

                        var l = response[0]; //choose first location

                        if(l.geometry.bounds) {
                            var sw = l.geometry.bounds.getSouthWest();
                            var ne = l.geometry.bounds.getNorthEast();

                            var bounds = {
                                north: ne.lat(),
                                south: sw.lat(),
                                east: ne.lng(),
                                west: sw.lng()
                            };
                        } else if(l.geometry.viewport) {
                            var bounds = {
                                north: l.geometry.viewport.f.f,
                                south: l.geometry.viewport.f.b,
                                east: l.geometry.viewport.b.f,
                                west: l.geometry.viewport.b.b
                            };
                        } else {
                            var bounds = {
                                north: l.geometry.location.getLatLng().lat() + 1,
                                south: l.geometry.location.getLatLng().lat() - 1,
                                east: l.geometry.location.getLatLng().lng() + 1,
                                west: l.geometry.location.getLatLng().lat() - 1
                            };                            
                        }

                        showRect(bounds);
                    }
                }
            );
        }

        function showRect(bounds) {
            rectangle.setMap(null);
            rectangle.setBounds(bounds);
            rectangle.setMap(map);
            rectangle.addListener('bounds_changed', showNewRect);

            var sw = new google.maps.LatLng(bounds.south, bounds.west);
            var ne = new google.maps.LatLng(bounds.north, bounds.east);
            var bounds = new google.maps.LatLngBounds();

            bounds.extend(sw);
            bounds.extend(ne);
            map.fitBounds(bounds);

            updateForm(ne,sw);
        }

        function showNewRect(event) {
            var ne = rectangle.getBounds().getNorthEast();
            var sw = rectangle.getBounds().getSouthWest();

            updateForm(ne, sw);
        }

        showRect({
            north: {{ $Zone->north_east_lat }},
            south: {{ $Zone->south_west_lat }},
            east: {{ $Zone->north_east_lng }},
            west: {{ $Zone->south_west_lng }}
        });

        function updateForm(ne, sw) {
            console.log('Form Updated', ne.lat(), ne.lng(), sw.lat(), sw.lng());
            north_east_lat.value = ne.lat();
            north_east_lng.value = ne.lng();
            south_west_lat.value = sw.lat();
            south_west_lng.value = sw.lng();
            address.value = input.value;
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=geometry,places,drawing&callback=initMap" async defer></script>
@endsection