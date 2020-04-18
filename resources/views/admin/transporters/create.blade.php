@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('transporter.create.title')</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form class="form-horizontal" id="transporter_form" role="form" method="POST" action="{{ route('admin.transporters.store') }}">
                {{ csrf_field() }}
               
                <div class="form-group col-xs-12 mb-2">
                     <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="@lang('transporter.create.name')" autofocus>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="@lang('transporter.create.email')" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif  
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <input id="password" type="password" class="form-control" name="password" required  placeholder="@lang('transporter.create.password')">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-2">
                     <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="@lang('transporter.create.confirm_password')" required>
                </div>
                 <div class="form-group col-xs-12 mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Address:</label>
                            <input id="pac-input" type="text" class="form-control" name="address"  required placeholder="Address" value="{{old('address')}}"  />
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly required>
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly required>
                            @if ($errors->has('home_address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('home_address') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Profile Image:</label>
                    
                           <input type="file" accept="image/*" name="avatar" class="dropify form-control" id="avatar" aria-describedby="fileHelp" >

                            @if ($errors->has('document'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('document') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="map" style="height:400px;"></div>
                    </div>
                    
                </div>
                <div class="form-group col-xs-12 mb-2 contact-repeater">
                    <div data-repeater-list="repeater-group">
                        <div class="input-group" data-repeater-item>
                        <div class="col-md-2 no-pad">
                                <input id="country_code" class="form-control country_div"  name="country_code" autocomplete="off" style="padding: 10px;" type="tel" value="{{ old('country_code') }}" required placeholder="@lang('transporter.create.country_code')">
                                </div>
                                
                                 <div class="col-md-10  no-pad">
                                <input id="phone1" type="text" class="form-control phone-number phone_fileds" name="phone_number" value="{{ old('phone_number') }}" placeholder="@lang('transporter.create.phone')" required autofocus>
                                 <input id="phone" type="hidden"  name="phone" value="{{ old('phone') }}"  >
                                 
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 mb-2">
                    <a href="{{ route('admin.transporters.index') }}" class="btn btn-warning mr-1">
                        <i class="ft-x"></i> Cancel
                    </a>
                    <button type="button" onclick="return usercreate();" class="btn btn-primary">
                        <i class="fa fa-check-square-o"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/dropify/dist/css/dropify.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/easy-autocomplete.min.css')}}">
<style type="text/css">
    .easy-autocomplete-container ul { max-height: 200px !important; overflow: auto !important; }
    .phone_fileds {
        margin-left: 0px !important;
        border-left: 1px solid #ccc !important;
        width: 100% !important
    }
    .no-pad{
        padding: 0px !important;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/admin/plugins/dropify/dist/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.easy-autocomplete.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('.dropify').dropify();
    function usercreate(){
            var phone = $('#country_code').val()+$('#phone1').val();
            $('#phone').val(phone);
        $('#transporter_form').submit();
    }
    var options = {

      url: "{{asset('assets/js/countryCodes.json')}}",

      getValue: "name",

      list: {
        match: {
          enabled: true
        },
        onClickEvent: function() {
                var value = $("#country_code").getSelectedItemData().dial_code;

                $("#country_code").val(value).trigger("change");
            },
        maxNumberOfElements: 1000
      },

      template: {
        type: "custom",
        method: function(value, item) {
          return "<span class='flag flag-" + (item.dial_code).toLowerCase() + "' ></span>" +value+"("+item.dial_code+")";
        }
      },

      theme: "round"
    };
    $("#country_code").easyAutocomplete(options);
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

        map = new google.maps.Map(document.getElementById('map'), {
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
<script src="https://maps.googleapis.com/maps/api/js?key={{Setting::get('GOOGLE_MAP_KEY')}}&libraries=places&callback=initMap" async defer></script>
@endsection