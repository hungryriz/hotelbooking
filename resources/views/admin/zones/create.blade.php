@extends('admin.layouts.app')

@section('content')
<div class="card-box table-responsive">
    <h4 class="m-t-0 header-title">
        <b>Create Zone</b>
    </h4>
    <hr/>
    <div class="row">
        <div class="col-sm-12">
            <input tabindex="2" id="pac-input" class="controls form-control" type="text" placeholder="Enter a Zone" name="name">
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

    <form id="district" class="form-horizontal" action="{{ route('admin.zones.store') }}" method="post" role="form">
        {{csrf_field()}}
        <input type="hidden" id="name" name="name" value="{{old('name')}}" readonly required>
        <input type="hidden" id="north_east_lat" name="north_east_lat" value="{{old('north_east_lat')}}" readonly required>
        <input type="hidden" id="north_east_lng" name="north_east_lng" value="{{old('north_east_lng')}}" readonly required>
        <input type="hidden" id="south_west_lat" name="south_west_lat" value="{{old('south_west_lat')}}" readonly required>
        <input type="hidden" id="south_west_lng" name="south_west_lng" value="{{old('south_west_lng')}}" readonly required>
    </form>
</div>
@endsection

@section('scripts')
<script>
    var map;
    var input = document.getElementById('pac-input');
    var address = document.getElementById('name');
    var north_east_lat = document.getElementById('north_east_lat');
    var north_east_lng = document.getElementById('north_east_lng');
    var south_west_lat = document.getElementById('south_west_lat');
    var south_west_lng = document.getElementById('south_west_lng');
    var geocode_bouning_box;

    function initMap() {

        var userLocation = new google.maps.LatLng(
                22.33728,
                114.14737549999995
            );

        map = new google.maps.Map(document.getElementById('map'), {
            center: userLocation,
            zoom: 15
        });

        var service = new google.maps.places.PlacesService(map);
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);

        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });

        var rectangle = new google.maps.Rectangle({
            editable: true,
            draggable: true
        });

        marker.setVisible(true);
        marker.setPosition(userLocation);

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
                if (!results || status != google.maps.GeocoderStatus.OK) {
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
                        
                        point = l.geometry.location;

                        if (marker) {
                            marker.setMap(null);
                        }

                        marker = new google.maps.Marker({
                            position: point,
                            map: map,
                            title: "Searched Address"
                        });

                        if (geocode_bouning_box)  {
                            geocode_bouning_box.setMap(null);
                        }

                        console.log(l.geometry.location.lat(), l.geometry.location.lng());
                        console.log(l.geometry.bounds);

                        map.setCenter(l.geometry.location);

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

                            var sw = new google.maps.LatLng(bounds.south, bounds.west);
                            var ne = new google.maps.LatLng(bounds.north, bounds.east);
                        } else {
                            var bounds = {
                                north: l.geometry.location.getLatLng().lat() + 1,
                                south: l.geometry.location.getLatLng().lat() - 1,
                                east: l.geometry.location.getLatLng().lng() + 1,
                                west: l.geometry.location.getLatLng().lat() - 1
                            };                            

                            var sw = new google.maps.LatLng(bounds.south, bounds.west);
                            var ne = new google.maps.LatLng(bounds.north, bounds.east);
                        }

                        console.log(bounds);

                        rectangle.setMap(null);
                        rectangle.setBounds(bounds);
                        rectangle.setMap(map);

                        // Add an event listener on the rectangle.
                        rectangle.addListener('bounds_changed', showNewRect);

                        // var geocode_bouning_box_coords = [
                        //     new google.maps.LatLng(ne.lat(), ne.lng()),
                        //     new google.maps.LatLng(ne.lat(), sw.lng()),
                        //     new google.maps.LatLng(sw.lat(), sw.lng()),
                        //     new google.maps.LatLng(sw.lat(), ne.lng()),
                        //     new google.maps.LatLng(ne.lat(), ne.lng())
                        // ];
                        // geocode_bouning_box = new google.maps.Polyline({
                        //     path: geocode_bouning_box_coords,
                        //     geodesic: false,
                        //     strokeColor: '#FF0000',
                        //     strokeOpacity: 1.0,
                        //     strokeWeight: 2
                        // });
                        // geocode_bouning_box.setMap(map);
                        updateForm(ne,sw);

                        if (l.geometry.bounds) {
                            map.fitBounds(l.geometry.bounds);
                        } else {
                            console.log(map);
                            map.setCenter(point);
                            map.setZoom(15);
                        }
                    }
                }
            );
        }

        function showNewRect(event) {
            var ne = rectangle.getBounds().getNorthEast();
            var sw = rectangle.getBounds().getSouthWest();

            updateForm(ne, sw);
        }

        // function drawRec() {
        //     //Setting options for the Drawing Tool. In our case, enabling Polygon shape.
        //     var drawingManager = new google.maps.drawing.DrawingManager();

        //     drawingManager.setOptions({
        //         drawingMode : google.maps.drawing.OverlayType.RECTANGLE,
        //         drawingControl : true,
        //         drawingControlOptions : {
        //             position : google.maps.ControlPosition.TOP_CENTER,
        //             drawingModes : [ google.maps.drawing.OverlayType.RECTANGLE ]
        //         },
        //         rectangleOptions : {
        //             strokeColor : '#6c6c6c',
        //             strokeWeight : 3.5,
        //             fillColor : '#926239',
        //             fillOpacity : 0.6,
        //             editable: true,
        //           draggable: true
        //         }   
        //     });
        //     // Loading the drawing Tool in the Map.
        //     drawingManager.setMap(map);
        // }

        function updateForm(ne, sw) {
            console.log(ne.lat(), ne.lng(), sw.lat(), sw.lng());
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