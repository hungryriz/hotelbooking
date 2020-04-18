@extends('user.layouts.app')

@section('content')

<!-- Content Wrapper Starts -->
        <div class="content-wrapper">
            <!-- Intro Banner Starts -->
            <div class="restaurant-banner-outer">
                <div class="container">
                    <div class="restaurant-banner row">
                        <!-- Restaurant Banner Left Starts -->
                        <div class="res-banner-left col-md-3">
                            <div class="res-banner-img bg-img" style="background-image: url({{$Shop->avatar}});"></div>
                        </div>
                        <!-- Restaurant Banner Left Ends -->
                        <!-- Restaurant Banner Center Starts -->
                        <div class="res-banner-center col-md-7">
                            <h4 class="res-banner-tit">{{$Shop->name}}</h4>
                            <p class="res-banner-txt">{{$Shop->maps_address}}</p>
                            <p class="res-banner-txt">{{$Shop->name}}</p>
                            <!-- Restaurant Banner Ratings Starts -->
                            <div class="res-banner-ratings row">
                                <div class="res-banner-rate-block col-md-2 col-xs-4">
                                    <p class="res-banner-rate-txt1"><i class="fa fa-star"></i>{{$Shop->rating}}</p>
                                    <p class="res-banner-rate-txt2">Ratings</p>
                                </div>
                                <div class="res-banner-rate-block col-md-2 col-xs-4">
                                    <p class="res-banner-rate-txt1">{{$Shop->estimated_delivery_time}}Mins</p>
                                    <p class="res-banner-rate-txt2">Delivery Time</p>
                                </div>
                               <!--  <div class="res-banner-rate-block col-md-2 col-xs-4">
                                    <p class="res-banner-rate-txt1">$200</p>
                                    <p class="res-banner-rate-txt2">Cost of Two</p>
                                </div> -->
                            </div>
                            <!-- Restaurant Banner Ratings Ends -->
                            <!-- Restaurant Banner Search Starts -->
                            <div class="res-banner-search-block row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <form id="prod_search_form">
                                    <div class="res-banner-search input-group search-box">
                                        
                                            @if(Request::has('name'))
                                            <input type="hidden" name="name" value="{{Request::get('name')}}" />
                                            @endif
                                            @if(Request::has('prodtype'))
                                            <input type="hidden" name="prodtype" value="{{Request::get('prodtype')}}" />
                                            @endif
                                            <!-- <div class="input-group"> -->
                                                <span class="input-group-addon prodsearch"><i class="ion-android-search"></i></span>
                                                <input type="text" name="prodname" class="form-control" placeholder="Search for dishes">
                                                <i class="ion-android-close search-close"></i> ESC
                                            <!-- </div> -->
                                       
                                    </div>
                                     </form>
                                    
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="form-check search-box1 search-box">
                                    <form id="veg_check_form">
                                        @if(Request::has('name'))
                                        <input type="hidden" name="name" value="{{Request::get('name')}}" />
                                        @endif
                                        @if(Request::has('prodname'))
                                        <input type="hidden" name="prodname" value="{{Request::get('prodname')}}" />
                                        @endif
                                        <input type="checkbox" name="prodtype"  @if(Request::get('prodtype')) checked  @endif  value="veg" class="form-check-input" id="veg-check">
                                        <label class="form-check-label " for="veg-check">Veg Only</label>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    
                                    @if(Auth::guest())
                                    <div class="search-box1 search-box res-favourite shopfav ">
                                        <i class="ion-ios-heart-outline "></i><span class="fav">Favourite</span>
                                    </div>
                                    @else
                                    <div class="search-box1 search-box res-favourite shopfav ">
                                        @if(\App\Favorite::where('shop_id',$Shop->id)->count()>0)
                                            <i class="ion-ios-heart active"></i> <span class="fav">Favourited</span>
                                        @else
                                            <i class="ion-ios-heart-outline "></i><span class="fav">Favourite</span>
                                        @endif
                                    </div>
                                    @endif
                                    
                                </div>
                            </div>
                            <!-- Restaurant Banner Search Ends -->
                        </div>
                        <!-- Restaurant Banner Center Ends -->
                         <!-- Restaurant Banner Right Starts -->
                        <div class="res-banner-right col-md-2">
                            @if($Shop->offer_percent)
                            <div class="banner-offer">
                                
                                <h5><i class="mdi mdi-tag"></i> Offers</h5>
                                <p class="banner-offer-txt">Get {{$Shop->offer_percent}} % off on all orders on all items </p>
                                
                            </div>
                            @endif
                        </div>
                        <!-- Restaurant Banner Right Starts -->
                    </div>
                </div>
            </div>
            <!-- Intro Banner Ends -->
            <!-- Food Section Starts -->
            <div class="food-section-outer">
                <div class="container-fluid">
                    <div class="food-section row" id="filter-menu">
                        <!-- Food Section Left Starts -->

                        <div class="food-sec-left col-md-3 col-sm-12 col-xs-12">
                            <!-- Restaurant Filters Starts -->
                            <div class="food-filters">
                                <a href="#recommend" class="food-filters-item filter-scroll-menu active">Recommended</a>
                                @forelse($Shop->categories as $key=>$Category)
                                <a href="#{{str_replace(' ', '_', $Category->name)}}" class="food-filters-item filter-scroll-menu">{{$Category->name}}</a>
                                @empty
                                @endforelse
                                
                            </div>
                            <!-- Restaurant Filters Ends -->
                        </div>
                        <!-- Food Section Left Ends -->
                        <!-- Food Section Right Starts -->
                        <div class="food-sec-right col-md-6 col-sm-12 col-xs-12">
                            <!-- Restaurant Food List Starts -->
                            <div class="restaurant-food-list" id="recommend">
                                <!-- Restaurant Filter Head Starts -->
                                <div class="res-filter-list-head">
                                    <h5>Recommended</h5>
                                    <p class="food-item-txt">{{count($FeaturedProduct)}} Items</p>
                                </div>
                                <!-- Restaurant Filter Head Ends -->
                                <!-- Food List Section Starts -->
                                <div class="food-list-section row">
                                @forelse($FeaturedProduct as $key=>$img)
                                <?php //dd($img); ?>
                                @if(count($img->featured_images)>0)
                                    <!-- Food List Section Box Starts -->
                                    <div class="food-item-box col-lg-6 col-md-6 col-sm-12 col-xs-12 @if($img->food_type=='veg') veg @else nonveg @endif">
                                        <div class="food-img bg-img" style="background-image: url({{image(@$img->featured_images)}});"></div>
                                        <div class="food-details">
                                            <h6 class="food-det-tit">{{$img->name}}</h6>
                                            <p class="food-det-txt">{{@$img->categories[0]->name}}</p>
                                            <div class="food-other-details row">
                                                <div class="col-xs-5">
                                                    @if($img->prices->discount)
                                                    <span class="food-price">
                                                    <strike>{{currencydecimal($img->prices->price)}}</strike>
                                                    {{currencydecimal($img->prices->orignal_price)}}
                                                    </span>
                                                    @else
                                                    <span class="food-price">{{currencydecimal($img->prices->price)}}</span>
                                                    @endif
                                                </div>
                                                <div class="col-xs-7 text-right">
                                                    <div class="add-btn-wrap text-right">
                                                        <form  action="{{Auth::guest()?url('mycart'):url('addcart')}}" method="POST">
                                                                {{csrf_field()}}
                                                                <!-- <label>Select Quantity</label> -->
                                                            <input type="hidden" value="{{$img->shop_id}}" name="shop_id" >
                                                            <input type="hidden" value="{{$img->id}}" name="product_id" >
                                                            <input type="hidden" value="1" name="quantity" class="form-control" placeholder="Enter Quantity" readonly min="1" max="100">
                                                            <input type="hidden" value="{{$img->name}}" name="name" >
                                                            <input type="hidden" value="{{@$img->prices->price}}" name="price" />
                                                            
                                                            @if(Auth::user())
                                                                @if($img->out_of_stock=='NO')
                                                                    @if(count($img->addons)==0)
                                                                    <button type="submit" class="add-btn">@lang('user.add_to_cart')</button>
                                                                    @else
                                                                     <button type="button" class="custom-add-btn add_to_basket" data-productid="{{$img->id}}" data-foodtype="{{$img->food_type}}">
                                                                        @lang('user.add_to_cart')<i class="ion-android-add custom-plus"></i>
                                                                    </button>
                                                                    <span class="custom-txt">Customisable</span>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                <a href="#" class="login-item add-btn" onclick="$('#login-sidebar').asidebar('open')">@lang('user.add_to_cart')</a>
                                                           
                                                            @endif
                                                        </form>
                                                        <!-- <a href="javascript:void(0);" class="add-btn">
                                                            Add
                                                        </a> -->
                                                        <!-- <a href="javascript:void(0);" class="add-btn1">
                                                            <div class="numbers-row">
                                                                <input type="text" name="add-quantity" class="add-sec" id="add-quantity" value="1">
                                                            </div>
                                                        </a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Food List Section Box Starts -->
                                @endif
                                @empty
                                @endforelse
                                    
                                </div>
                                <!-- Food List Section Ends -->
                            </div>
                             @include('user.shop.partial.category')
                        </div>
                        <!-- Food Section Right Ends -->
                        <!-- Cart Section Starts -->

                        @if(isset($Cart['carts']) && @$Cart['carts'][0]->product->shop_id == $Shop->id)
                        <div class="cart col-md-3 col-sm-12 col-xs-12">
                            <!-- Cart Head Starts -->
                            <div class="cart-head">
                                <h4 class="cart-tit">Cart</h4>
                                <p class="cart-txt">from <a href="{{url('/restaurant/details')}}?name={{$Shop->name}}" class="cart-link">{{$Shop->name}}</a></p>
                                <p class="cart-head-txt">{{count($Cart['carts'])}} Items</p>
                            </div>
                            <!-- Cart Head Ends -->
                            <!-- Cart Empty Section Starts -->
                            <!-- <div class="cart-empty">
                                <div class="cart-empty-img"></div>
                                <p class="cart-empty-txt">Good food is always cooking! Go ahead, order some yummy items from the menu.</p>
                            </div> -->
                            <!-- Cart Empty Section Ends -->
                            <!-- Cart Section Starts -->
                            <div class="cart-section table-responsive">
                                <table class="table table-responsive">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    <?php $tot_gross=0;?>
                                    @forelse($Cart['carts'] as $item)
                                        <tr>
                                            <th scope="row">
                                                <div class="row m-0">
                                                    @if($item->product->food_type=='veg')
                                                    <img src="{{asset('assets/user/img/veg.jpg')}}" class="veg-icon">
                                                    @else
                                                    <img src="{{asset('assets/user/img/non-veg.jpg')}}" class="veg-icon">
                                                    @endif
                                                    <div class="food-menu-details">
                                                        <h5>{{$item->product->name}}</h5>
                                                        @if(count($item->cart_addons)>0)
                                                        <a href="#" class="custom-txt add_to_basket" 
                                                        data-id="{{$item->id}}"
                                                        data-productid="{{$item->product->id}}">Customize <i class="ion-chevron-right"></i></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </th>
                                            <td>
                                                <button class="cart-add-btn">
                                                    <div class="numbers-row" data-id="{{$item->id}}" data-pid="{{$item->product->id}}">
                                                        <input type="number" min="1" data-price="{{$item->product->prices->price}}" name="add-quantity" class="add-sec" id="add-quantity_{{$item->id}}" value="{{$item->quantity}}">
                                                    </div>
                                                </button>
                                            </td>
                                            <td>
                                             <?php $tot_gross += $item->quantity*$item->product->prices->price;  ?>
                                                <p class="total_product_{{$item->id}}">{{currencydecimal($item->quantity*$item->product->prices->price)}}</p>
                                                
                                            </td>
                                        
                                        
                                        @forelse($item->cart_addons as $cartaddon)
                                        <?php //print_r($cartaddon); ?>
                                            <input type="hidden" value="{{$cartaddon->quantity}}" id="cart_addon_{{$cartaddon->user_cart_id}}_{{$cartaddon->addon_product_id}}" />
                                            <?php $tot_gross += $item->quantity*$cartaddon->quantity*$cartaddon->addon_product->price;  ?>
                                           
                                        @empty
                                             
                                        @endforelse
                                    @empty
                                    </tr>
                                    <tr><td colspan="2">@lang('user.empty_cart')</td></tr>
                                    @endforelse
                                        
                                    </tbody>
                                    <tfoot>
                                        <th></th>
                                        <th>Subtotal</th>
                                        <th class="sub-total">{{currencydecimal($tot_gross)}}

                                        </th>
                                        
                                    </tfoot>
                                </table>
                                <input type="hidden" id="total_price" value="{{$tot_gross}}"/>
                                <input type="hidden" id="total_addons_price" value="0"/>
                                <input type="hidden" id="total_product_price" value="{{$tot_gross}}"/>
                            </div>
                            <a href="{{url('restaurant/details')}}?name={{$Shop->name}}&myaddress=home" class="checkout-btn">Checkout <i class="ion-ios-arrow-thin-right"></i></a>
                            <!-- Cart Section Ends -->
                        </div>
                        <!-- Cart Section Ends -->
                        @else
                            <div class="cart col-md-3 col-sm-12 col-xs-12">
                            <!-- Cart Head Starts -->
                            <div class="cart-head">
                                <h4 class="cart-tit">Cart</h4>
                               
                            </div>
                            <div>@lang('user.empty_cart')</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Food Section Ends -->
        </div>
        <!-- Content Wrapper Ends -->
        <!-- Footer Starts -->
        <footer>
        </footer>
        <!-- Footer Ends -->
    </div>
    <!-- Main Warapper Ends -->
    <!-- Custom Modal Starts-->
    <div class="modal fade" id="custom-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{Auth::guest()?url('mycart'):url('addcart')}}" method="POST">           
                    {{csrf_field()}}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="ion-close-round"></span>
                        </button>
                        <div>
                            <div class="row m-0">
                                <img src="{{asset('assets/user/img/veg.jpg')}}" class="prodveg veg-icon">
                                <img src="{{asset('assets/user/img/non-veg.jpg')}}" class="prodnonveg veg-icon">
                                <div class="food-menu-details custom-head-details">
                                    <h5 class="p_name"></h5>
                                    <p class="p_price"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <!-- Custom Head Starts -->
                       
                        <!-- Custom Head Ends -->
                        <!-- Cusom Content Starts -->
                        <div class="custom-content">
                            <!-- Custom Section Starts -->
                            <!-- <div class="custom-section" id="custom-quantity">
                                    
                            </div> -->
                            <!-- Custom Section Ends -->
                            <!-- Custom Section Starts -->
                            <div class="custom-section" id="custom-add-ons">
                                <h5 class="custom-block-tit">Addons <span class="optional">(Optional)</span></h5>
                                <div id="addon_list">
                                        
                                </div>
                                <!-- Custom Block Starts -->
                                
                            </div>
                            <!-- Custom Section Ends -->
                        
                        <!-- Custom Content Ends -->
                        <!-- Custom Section Starts -->
                            <div class="custom-section" id="custom-text-field">
                                <h5 class="custom-block-tit">Note</h5>
                                <textarea class="form-control" name="note" rows="3"></textarea>
                            </div>
                            <!-- Custom Section Ends -->
                            </div>
                    </div>
                    <div class="modal-footer">
                        
                        
                        <div class="">
                            <button class="total-btn row m-0">
                                <span class="pull-left t_price">Total </span>
                                <span class="pull-right">ADD ITEM</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Custom Modal Ends -->
   
   
    <div class="aside-backdrop"></div>
@endsection
@section('scripts')
<!-- <script type="text/javascript" src="{{asset('assets/user/js/max-bootstrap.min.js')}}"></script> -->
<script type="text/javascript">
$('.add_to_basket').click(function(){
    var product_id = $(this).data('productid'); 
    var quantity = $('#product_price_'+product_id).val();
    var addons = '';
    var cart_id = $(this).data('id'); 
    var qty = 1;
    var food_type = $(this).data('food_type'); 
    addons = '';
    if(cart_id){
        qty = $('#add-quantity_'+cart_id).val();
         addons +=' <input type="hidden" value="'+cart_id+'" name="cart_id" >';
    }
  
    $.ajax({
        url: "{{url('/addons/')}}/"+product_id,
        type:'GET',
        success: function(data) { 
            if(food_type == 'veg'){
                $('.prodveg').show();
                $('.prodnonveg').hide();
            }else{
               $('.prodnonveg').show();
               $('.prodveg').hide();
            }
             var p_price = qty*data.prices.price;
            
             addons +=' <input type="hidden" value="'+data.shop_id+'" name="shop_id" >\
                        <input type="hidden" value="'+data.id+'" name="product_id" >\
                        <input type="hidden" value="'+qty+'" name="quantity" class="form-control" placeholder="Enter Quantity" min="1" max="100">\
                        <input type="hidden" value="'+data.name+'" name="name" >\
                        <input type="hidden" value="'+data.prices.price+'" name="price" />';
            $.each( data.addons , function( key, value ) { 
                var chk='';
                if(cart_id){
                    if($('#cart_addon_'+cart_id+'_'+value.id).val()){
                        p_price = p_price+value.price;
                        chk = "checked";
                    }
                }
               addons+='<div class="custom-block">\
                                <div class="row m-0">';
                                   
                                    addons+='<div class="food-menu-details custom-details">\
                                        <div class="form-check">\
                                            <input class="form-check-input chkaddon" '+chk+' type="checkbox" name="product_addons['+value.id+']" value="'+value.id+'" id="addons-'+value.id+'"  data-price="'+value.price+'">\
                                            <label class="form-check-label" for="addons-"'+value.id+'">'+value.addon.name+'({{Setting::get('currency')}} '+value.price.toFixed(2)+')</label>\
                                             <input type="hidden" value="1" class=" input-number" name="addons_qty['+value.id+']"  />\
                            <input type="hidden" name="addons_price['+value.id+']" value="'+value.price+'" />\
                             <input type="hidden" name="addons_name['+value.id+']" value="'+value.addon.name+'" />\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>';
                
            });
            addons+='<input type="hidden" id="t_price" value="'+p_price+'"  >';
            $('.p_name').html(data.name);
            $('.p_price').html("{{Setting::get('currency')}}"+p_price.toFixed(2));
            $('.t_price').html("Total {{Setting::get('currency')}}"+p_price.toFixed(2));
             /*addons+='<div class="row">\
                        <div class="col-md-4">\
                            <label>Note</label>\
                            </div>\
                            <div class="col-md-8">\
                            <textarea id="fullfilled" class="form-control counted" name="note" placeholder="Write Something" rows="5" style="margin-bottom:10px;" >\
                            </textarea>\
                        </div>\
                    </div>';*/
            $('#addon_list').html(addons);
            $.each( data.addons , function( key, value ) {

            });
            $('#custom-modal').modal('show');
        },
        error:function(jqXhr,status){ 
            if( jqXhr.status === 422 ) {
                $(".print-error-msg").show();
                var errors = jqXhr.responseJSON; 

                $.each( errors , function( key, value ) { 
                    $(".print-error-msg").find("ul").append('<li>'+value[0]+'</li>');
                });
            } 
        }
    });
    
})

$(document).on('click','.chkaddon',function(){
    var price = $(this).data('price');
    if($(this).is(':checked')){
    var total_price = parseFloat($('#t_price').val()) + parseFloat(price);
    }else{
       var total_price = parseFloat($('#t_price').val()) - parseFloat(price); 
    }
    $('#t_price').val(total_price);
    $('.t_price').html('Total {{Setting::get("currency")}}'+total_price);
});

@if(isset($Cart['carts']))
    @if(count($Cart['carts'])==0)

    @elseif(@$Cart['carts'][0]->product->shop_id != $Shop->id)

            if(confirm("@lang('user.roster_change_msg')")){
                clearCart();
            }else{
                $('#my_map_form').submit();
                //window.location.href="{{url('/restaurants')}}";
            }
          console.log(1);   
    @endif 
@elseif(count($Cart) != 0)
        @if(!array_key_exists($Shop->id,$Cart))
            if(confirm("@lang('user.roster_change_msg')")){
                /*window.location.href="{{url('/restaurants')}}";*/
                clearCart();
            }else{
                $('#my_map_form').submit();
                //window.location.href="{{url('/restaurants')}}";
            }
            console.log(45);
        @endif

@endif

function clearCart(){
    $.ajax({
        url: "{{url('/clear/cart')}}",
        type:'GET',
        success: function(data) { 
            
        },
        error:function(jqXhr,status){ 
            if( jqXhr.status === 422 ) {
                $(".print-error-msg").show();
                var errors = jqXhr.responseJSON; 

                $.each( errors , function( key, value ) { 
                    $(".print-error-msg").find("ul").append('<li>'+value[0]+'</li>');
                });
            } 
        }
    });
}
$(document).ready(function() {    
$(document).on('click','.inc',function(e){
    e.preventDefault();
    var id = $(this).parent().attr('data-id'); 
    var pid = $(this).parent().attr('data-pid');   
    var input = $("input[id='add-quantity_"+id+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        product_price_calculation(id,'plus');
        changeCart(id,pid,currentVal);
    } else {
        input.val(0);
    }
});
$(document).on('click','.dec',function(e){
    e.preventDefault();
    var id = $(this).parent().attr('data-id');
    var pid = $(this).parent().attr('data-pid');    
    var input = $("input[id='add-quantity_"+id+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(currentVal==0){ 
            changeCart(id,pid,currentVal);
        }else{
        product_price_calculation(id,'minus'); 
        changeCart(id,pid,currentVal);  
        } 
    } else {
        input.val(0);
    }
});

  function product_price_calculation(val,type){

    if(type == 'plus'){
      var qty = $('#add-quantity_'+val).val();

      var price = $('#add-quantity_'+val).data('price');
      var tot_amt = qty*price;
      $('.total_product_'+val).html("{{Setting::get('currency')}}"+tot_amt.toFixed(2));
      ///
      var total = parseInt(price)+parseInt($('#total_price').val());
      
      var total_product_price = parseInt($('#total_product_price').val())+parseInt(price);
      $('#total_product_price').val(total_product_price);
      var total_addons_price = $('#total_addons_price').val();
      total = parseInt(total_product_price)+qty*parseInt(total_addons_price);
      $('#total_price').val(total); 
      $('.sub-total').html("{{Setting::get('currency')}}"+total.toFixed(2));
    }else{
      var qty = $('#add-quantity_'+val).val();

      var price = $('#add-quantity_'+val).data('price');
      var tot_amt = qty*price;
      $('.total_product_'+val).html("{{Setting::get('currency')}}"+tot_amt.toFixed(2));
      ///
      var total = parseInt(price)+parseInt($('#total_price').val());
      
      var total_product_price = parseInt($('#total_product_price').val())-parseInt(price);
      $('#total_product_price').val(total_product_price);
      var total_addons_price = $('#total_addons_price').val();
      total = parseInt(total_product_price)+qty*parseInt(total_addons_price);
      $('#total_price').val(total); 
      $('.sub-total').html("{{Setting::get('currency')}}"+total.toFixed(2));
    }
}
});
function changeCart(id,pid,qty){
    $.ajax({
        url: "{{url('addcart')}}",
        type:'POST',
        data:{'cart_id':id,'quantity':qty,'_token':"{{csrf_token()}}",'product_id':pid},
        success: function(res) { 
            if(qty==0){
            location.reload();
            }
        },
        error:function(jqXhr,status){ 
            if( jqXhr.status === 422 ) {
                $(".print-error-msg").show();
                var errors = jqXhr.responseJSON; 

                $.each( errors , function( key, value ) { 
                    $(".print-error-msg").find("ul").append('<li>'+value[0]+'</li>');
                });
            } 
        }
    });
}
$('.shopfav').on('click',function(){
    if($(".shopfav i" ).hasClass( "active")){
        var url = "{{url('favourite')}}/{{$Shop->id}}";
        var method = 'DELETE';
    }else{
        var url = "{{url('favourite')}}";
        var method = 'POST';
    }
    $.ajax({
        url: url,
        type:method,
        data:{'shop_id':{{$Shop->id}},'_token':"{{csrf_token()}}"},
        success: function(res) { 
            if(method=='POST'){
                $('.shopfav i').addClass('active');
                $('.shopfav i').removeClass('ion-ios-heart-outline');
                $('.shopfav i').addClass('ion-ios-heart');
                $('.fav').html("Favourited");
            }else{
                $('.shopfav i').removeClass('active');
                $('.shopfav i').addClass('ion-ios-heart-outline');
                $('.shopfav i').removeClass('ion-ios-heart');
                $('.fav').html("Favourite");
            }
        },
        error:function(jqXhr,status){ 
            if( jqXhr.status === 422 ) {
                $(".print-error-msg").show();
                var errors = jqXhr.responseJSON; 

                $.each( errors , function( key, value ) { 
                    $(".print-error-msg").find("ul").append('<li>'+value[0]+'</li>');
                });
            } 
        }
    });
});
$('#veg-check').on('click',function(){
    if($(this).is(':checked')){
        $('#veg_check_form').submit();
    }else{
        $('#veg_check_form').submit();
    }
})
$('.prodsearch,.search-close').on('click',function(){
    $('#prod_search_form').submit();
})
document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        $('#prod_search_form').submit();
    }
};
</script>
@endsection
