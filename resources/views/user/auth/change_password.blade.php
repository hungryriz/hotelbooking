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
                    <h3 class="prof-tit">Change Password</h3>
                    <div class="prof-content">
                        <form method="POST" action="{{url('/setpassword')}}">
                        {{csrf_field()}}
                            <div class="form-group row">
                                <label class="col-sm-2">Old Password</label>
                                <div class="col-sm-5">
                                    <input type="password" name="password_old" required class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2">New Password</label>
                                <div class="col-sm-5">
                                    <input type="password" name="password" required class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2">Confirm Password</label>
                                <div class="col-sm-5">
                                    <input type="password" name="password_confirmation" required class="form-control" value="">
                                </div>
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
