@extends('user.layouts.app')

@section('content')
  <!-- Content Wrapper Starts -->
        <div class="content-wrapper">
            <div class="profile blue-bg">
                <!-- Profile Head Starts -->
                 @include('user.layouts.partials.user_common')
                <!-- Profile Head Ends -->
                <!-- Profile Content Starts -->
                <div class="profile-content">
                    <div class="container-fluid">
                        <!-- Profile Inner Starts -->
                        <div class="profile-inner row">
                            <!-- Profile Left Starts -->
                            @include('user.layouts.partials.sidebarhelp')
                            <!-- Profile Left Ends -->
                            <!-- Profile Right Starts -->
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="profile-right">
                                    <div class="profile-right-head">
                                        <h4>Addresses</h4>
                                    </div>
                                    <div class="profile-address">
                                        <!-- Profile Address Block Starts -->
                                        <div class="profile-address-block row">
                                        <?php $add_type = ['home'=> 'home','work'=> 'work','other'=> 'other']; ?>
                                        @forelse($user_address as $Address)

                                        <?php if($Address->type!='other'){
                                                unset($add_type[$Address->type]);
                                            } ?>
                                            <!-- Saved Address Starts -->
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="saved-address-box row m-0">
                                                    <div class="save-add-left pull-left">
                                                        <i class="ion-ios-location-outline save-add-icon"></i>
                                                    </div>
                                                    <div class="save-add-right ">
                                                        <h6 class="save-add-tit">{{$Address->type}}</h6>
                                                        <p class="save-add-txt">{{$Address->map_address}}</p>
                                                        
                                                        <div data-id="{{$Address->id}}">
                                                            <input type="hidden" value="{{$Address->latitude}}" class="latitude" />
                                                            <input type="hidden" value="{{$Address->longitude}}" class="longitude" />
                                                             <input type="hidden" value="{{$Address->type}}" class="type" />
                                                            <input type="hidden" value="{{$Address->map_address}}" class="mapaddrs" />
                                                            <input type="hidden" value="{{$Address->building}}" class="building" />
                                                            <input type="hidden" value="{{$Address->landmark}}" class="landmark" />
                                                            <a href="#" class="theme-link myaddress show-btn" onclick="$('#location-sidebar').asidebar('open')">Edit</a>
                                                            
                                                            <button class="theme-link show-btn" onclick="return confirm('Do You want To Remove This Address?');" form="resource-delete-{{ $Address->id }}">Delete</button>
                                                            
                                                            <form id="resource-delete-{{ $Address->id }}" action="{{ route('useraddress.destroy',$Address->id)}}" method="POST">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <input type="hidden" value="{{$Address->id}}" name="banner_id" />
                                                                <input type="hidden" value="{{$Address->status}}" name="status" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Saved Address Ends -->
                                            @empty
                              
                                            @endforelse
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="#" class="address-cmn-box add-new-address row m-0" onclick="$('#location-sidebar').asidebar('open')">
                                            <div class="address-box-left pull-left">
                                                <i class="ion-ios-location-outline address-icon"></i>
                                            </div>
                                            <div class="address-box-right">
                                                <h6 class="address-tit">Add New Address</h6>
                                                <p class="address-txt">{{Session::get('search_loc')}}</p>
                                                <button class="address-btn">Add New</button>
                                            </div>
                                        </a>
                                    </div>
                                        </div>
                                        <!-- Profile Address Block Ends -->
                                       
                                    </div>
                                </div>
                            </div>
                            <!-- Profile Right Ends -->
                        </div>
                        <!-- Profile Inner Ends -->
                    </div>
                </div>
                <!-- Profile Content Ends -->
            </div>
        </div>
        <!-- Content Wrapper Ends -->
         <!-- Location Sidebar Starts -->
    <div class="aside location" id="location-sidebar">
        <div class="aside-header">
            <span class="close" data-dismiss="aside"><i class="ion-close-round"></i></span>
            <h5 class="aside-tit">Save Address</h5>
        </div>
        <div class="aside-contents">
            <form action="{{route('useraddress.store')}}" method="POST" id="comon-form" class="common-form">
                 {{ csrf_field() }}
                <div class="" id="my_map" style="width: 100%; height: 200px;"></div>
                <div class="input-section">
                    <div class="form-group">
                        <label>Address</label>
                        <input class="form-control addr-mapaddrs" id="pac-input" name="map_address" type="text" value="{{Session::get('search_loc')}}" placeholder="enter your address">
                        <input type="hidden" id="latitude" name="latitude" value="{{ Session::get('latitude') }}" readonly required>
                        <input type="hidden" id="longitude" name="longitude" value="{{ Session::get('longitude') }}" readonly required>
                    </div>
                    <div class="form-group">
                        <label>Door / Flat no.</label>
                        <input class="form-control addr-building" name="building" type="text" value="">
                    </div>
                    <div class="form-group">
                        <label>Landmark</label>
                        <input class="form-control addr-landmark" name="landmark" type="text">
                    </div>
                    <div class="form-group">
                        <label>Address Type</label>
                        <select class="form-control addr-type" name="type">
                        @foreach($add_type as $item)
                        <option value="{{$item}}">{{$item}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <button class="add-address-btn">Save &amp; Proceed</button>
            </form>
        </div>
    </div>
    <!-- Location Sidebar Ends -->
    <div class="aside-backdrop"></div>
     @include('user.layouts.partials.footer')
@endsection
@section('styles')
<style>
    .pac-container {
        z-index: 9999999999999999999 !important;
    }
</style>
@endsection
@section('scripts')
<script>
$('.myaddress').on('click',function(){
    var id = $(this).parent().data('id');
    $('.addr-building').val($(this).parent().find('.building').val());
    $('.addr-landmark').val($(this).parent().find('.landmark').val());
    $('#latitude').val($(this).parent().find('.latitude').val());
    $('#longitude').val($(this).parent().find('.longitude').val());
    var type = $(this).parent().find('.type').val();
    if(type!='other'){
        $(".addr-type").append("<option value='"+type+"'>"+type+"</option>");
    }
    $(".addr-type option[value='"+type+"']").prop('selected', true);
    $('.addr-mapaddrs').val($(this).parent().find('.mapaddrs').val());
    $('#comon-form').attr('action',"{{url('useraddress')}}"+'/'+id);
    $('#comon-form').append('<input name="_method" value="PATCH" type="hidden">');
})
   

 
</script>

 @endsection
