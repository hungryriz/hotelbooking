<div class="profile-head row m-0">
    <div class="col-md-8 col-sm-8 col-xs-12">
        <h4 class="profile-head-tit">{{Auth::user()->name}}</h4>
        <p class="profile-head-txt">
            <span>{{Auth::user()->phone}}</span>
            <span class="dot">.</span>
            <span>{{Auth::user()->email}}</span>
        </p>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12 text-right">
        <a href="#" class="edit-profile" onclick="$('#edit-profile-sidebar').asidebar('open')">Edit Profile</a>
    </div>
</div>