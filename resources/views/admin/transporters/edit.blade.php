@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('transporter.edit.title')</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.transporters.update', $User->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group col-xs-12 mb-2">
                    <label>@lang('transporter.index.name')</label>
                     <input id="name" type="text" class="form-control" name="name" value="{{ old('name',$User->name) }}" required placeholder="@lang('transporter.create.name')" autofocus>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <label>@lang('transporter.index.email')</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email',$User->email) }}" placeholder="@lang('transporter.create.email')" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif  
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <label>@lang('transporter.index.rating')</label>
                    <input id="rating" type="number" class="form-control" name="rating" value="{{ old('rating',$User->rating) }}" placeholder="@lang('transporter.create.rating')" required>

                    @if ($errors->has('rating'))
                        <span class="help-block">
                            <strong>{{ $errors->first('rating') }}</strong>
                        </span>
                    @endif  
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <label>@lang('transporter.create.password')</label>
                    <input id="password" type="password" class="form-control" name="password"   placeholder="@lang('transporter.create.password')">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <label>@lang('transporter.create.confirm_password')</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="@lang('transporter.create.confirm_password')" >
                </div>
                
                <div class="form-group col-xs-12 mb-2 contact-repeater">
                    <label>@lang('transporter.create.phone')</label>
                    <div data-repeater-list="repeater-group">
                        <div class="input-group mb-1" data-repeater-item>
                            <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone',$User->phone) }}" placeholder="@lang('transporter.create.phone')" required autofocus>

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                            <span class="input-group-btn" id="button-addon2">
                                <button class="btn btn-danger" type="button" data-repeater-delete><i class="ft-x"></i></button>
                            </span>
                        </div>
                    </div>
                   <!--  <button type="button" data-repeater-create class="btn btn-primary">
                        <i class="icon-plus4"></i> Add new phone number
                    </button> -->
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('transporter.create.address')</label>
                            <input id="pac-input" type="text" class="form-control" name="address"  required placeholder="Address" value="{{old('address',$User->address)}}"  />
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly required>
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly required>
                            @if ($errors->has('home_address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('home_address') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>@lang('transporter.create.profile_image')</label>
                    
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
                    <label>@lang('transporter.create.status')</label>
                    <div data-repeater-list="repeater-group">
                        <div class="input-group mb-1" data-repeater-item>
                            <select name="status" class="form-control">
                                 <option value=""  >NO CHANGE</option>
                                <option value="unsettled" @if($User->status == 'unsettled') selected @endif > @lang('transporter.create.unsettle')</option>
                                <option value="offline"  @if($User->status == 'offline') selected @endif > @lang('transporter.create.settle')</option>
                            </select>

                            @if ($errors->has('status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group col-xs-12 mb-2">
                    <textarea rows="5" class="form-control" name="Address" placeholder="Address"></textarea>
                </div> -->
                <div class="col-xs-12 mb-2">
                    <a href="{{ route('admin.transporters.index') }}" class="btn btn-warning mr-1">
                        <i class="ft-x"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
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
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/admin/plugins/dropify/dist/js/dropify.min.js') }}"></script>
<script type="text/javascript">
    $('.dropify').dropify();
</script>
<script>
    var map;
    var input = document.getElementById('pac-input');
    var latitude = document.getElementById('latitude');
    var longitude = document.getElementById('longitude');
    var address = document.getElementById('address');

    function initMap() {

        var userLocation = new google.maps.LatLng(
                {{ $User->latitude }},
                {{ $User->longitude }}
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