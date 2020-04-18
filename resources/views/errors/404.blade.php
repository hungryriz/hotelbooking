
<!DOCTYPE html> 
<html lang="en-us" class="no-js"> 
<head> 
	<meta charset="utf-8"> 
	<title>Page Not Found - {{Setting::get('site_title')}}</title> 
	<meta name="description" content=""> 
	<meta name="viewport" content="width=device-width,initial-scale=1"> 
	<meta name="author" content="">  
	<link rel="stylesheet" href="{{asset('assets/404/css/style.min.css')}}"> 
</head> 
<body> 
<div class="image" style="background-image:url('{{asset('assets/404/img/image.jpg')}}');background-position:center;"></div> 
<a href="{{url('/')}}" class="logo-link" title="back home"> 
                        <img src="{{ Setting::get('site_logo',asset('assets/user/img/logo.png'))}}" class="logo" alt="Company's logo" style="height:50px;width:100px">
<!-- <img src="{{asset('assets/404/img/logo.png')}}" class="logo" alt="Company's logo" style="height:50px;width:100px">  -->
</a> 
<div class="content"> 
	<div class="content-box"> 
	<div class="big-content" style="display:none"> 
	<div class="list-square"> 
	<span class="square"></span> 
	<span class="square"></span> 
	<span class="square"></span> 
</div> 
<div class="list-line"> 
	<span class="line"></span> 
	<span class="line"></span> 
	<span class="line"></span> 
	<span class="line"></span> 
	<span class="line"></span> 
	<span class="line"></span> 
	</div> 
	<i class="fa fa-search" aria-hidden="true"></i> 
	<div class="clear"></div> 
</div> 
<h1>Oops! 404 - Page Not Found</h1> 
<p>The page you were looking for doesn't exist.</p> 
</div> 
</div> 

<script src="{{asset('assets/404/js/jquery.min.js')}}"></script> 
<script src="{{asset('assets/404/js/bootstrap.min.js')}}"></script> 

</body> 

</html>