@extends('user.layouts.app')

@section('content')
 <!-- Content ================================================== -->
    <div class="container margin_60_35">
        <div class="row">
            <div class="profile-left-col col-md-3 ">
                @include('user.layouts.partials.sidebar')
            </div>
            <!--End col-md -->
            <div class="profile-right-col col-md-9 white_bg">
                 @include('include.alerts')
                <div class="profile-right white_bg">
                    <h3 class="prof-tit">Personal Information</h3>
                    <div class="prof-content">
                        <form action="{{url('/profile')}}" method="POST" enctype= "multipart/form-data" >
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label class="col-sm-2">Name</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2">Email</label>
                                <div class="col-sm-5">
                                    <input type="email" name="email" class="form-control" value="{{Auth::user()->email}}">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2">Image</label>
                                <div class="col-sm-5">
                                    <input type="file" accept="image/*" name="avatar" class="dropify form-control" id="avatar" aria-describedby="fileHelp" >
                                        @if ($errors->has('avatar'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('avatar') }}</strong>
                                            </span>
                                        @endif
                                </div>
                                @if(Auth::user()->avatar!='')
                                    <div class="col-sm-5">
                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{Auth::user()->avatar}}">
                                    </div>
                                @endif
                            </div>
                            
                            <button class="submit">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End row -->
    </div>
    <!-- End container -->
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/dropify/dist/css/dropify.min.css') }}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/admin/plugins/dropify/dist/js/dropify.min.js') }}"></script>
<script type="text/javascript">
    $('.dropify').dropify();
</script>
@endsection