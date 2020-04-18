@extends('user.layouts.app')

@section('content')
 <!-- Content ================================================== -->
     <!-- Content ================================================== -->
 
       <div class="container">
          <div>
             <h1 class="postTitle" itemprop="name">{{$Product->name}}</h1>
             <span class="postDate relative block">40 minutes ago</span>
          </div>
          <div class="card">
             <div class="container-fliud">
                <div class=" row">
                   <form accept-charset="UTF-8" action="{{Auth::guest()?url('mycart'):url('addcart')}}" method="POST" >
                   {{csrf_field()}}
                       <div class="col-md-7">
                          <div class="preview">
                             <div class="preview-pic tab-content product-click">
                              @forelse($Product->images as $key => $img)
                                <div class="tab-pane @if($key==0) active @endif" id="pic-{{$key+1}}"><img src="{{$img->url}}" /></div>
                              @empty
                              @endforelse
                               
                             </div>
                             <ul class="preview-thumbnail nav nav-tabs">
                                @forelse($Product->images as $key => $img)
                                <li @if($key==0)class="active"  @endif ><a data-target="#pic-{{$key+1}}" data-toggle="tab"><img src="{{$img->url}}" height="50px" width="50px" /></a></li>
                                @empty

                                @endforelse
                               
                             </ul>
                          
                          </div>
                       </div>
                       <div class="col-md-5">
                          @include('include.alerts')
                          <div class="panel panel-default product_details">
                             <div class="panel-heading">
                                <span class=""><i class="fa fa-tags"></i></span>
                                   {{$Product->name}}
                                <!-- <p class="price">Rs 190</p> -->
                             </div>
                             <div class="panel-body">
                                <p>
                                   {{$Product->description}}
                                </p>
                                <div class="row">
                                    <div class="col-md-4">
                                       <p class="price-product ">{{$Product->name}}</p>
                                       <?php  
                                        $cart_total_price = $Product->prices->price;
                                        $prod_qty = 1;
                                        $prod_note='';
                                        $total_addon_price =0;
                                        $cart_id = '';
                                       if(count($Cart)>0){
                                            $cart_total_price = @$Cart->quantity*@$Product->prices->price;
                                            $prod_qty = $Cart->quantity;
                                            $prod_note = $Cart->note;
                                            $cart_id = $Cart->id;
                                        }
                                        if(count($CartShop)>0){
                                          $cart_id = uniqid();
                                          if(count(@$CartShop[$Shop->id])>0){
                                              if(count(@$CartShop[$Shop->id][$Product->id])>0){
                                              $cart_total_price = $CartShop[$Shop->id][$Product->id]['quantity']*@$Product->prices->price;
                                              $prod_qty = $CartShop[$Shop->id][$Product->id]['quantity'];
                                              $prod_note = $CartShop[$Shop->id][$Product->id]['note'];
                                            }

                                          }
                                        }

                                          ?>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="section" style="padding-bottom:20px;">
                                          <div>
                                             <div class="btn-minus btn-number-prod" data-field="quantity" data-id="{{$Product->id}}" data-type="minus">
                                                  <span class="glyphicon glyphicon-minus"></span>
                                               </div>
                                              <input  value="{{$prod_qty}}"  class="input-number" name="quantity" id="product_{{$Product->id}}" min="1" max="100" data-price="{{$Product->prices->price}}" />
                                             <div class="btn-plus btn-number-prod" data-field="quantity" data-type="plus" data-id="{{$Product->id}}">
                                                  <span class="glyphicon glyphicon-plus"></span>
                                               </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-2">
                                       <p class="price-product Total_price"> <span>

                                        <input type="hidden" value="{{$Product->shop_id}}" name="shop_id" >
                                        <input type="hidden" value="{{$Shop->name}}" name="shop_name" >
                                        <input type="hidden" value="{{$Product->id}}" name="product_id" >
                                                    
                                        <input type="hidden" value="{{$Product->name}}" name="name" >
                                        <input type="hidden" value="{{@$Product->prices->price}}" name="price" />

                                        <input type="hidden" value="1" name="addons_details" />

                                       <p class="Total_price"><span>{{currencydecimal(@$Product->prices->price)}}</span></p>
                                    </div>
                                    <div class="col-md-2">
                                       <p class="price-product Total_price"> <span id="total_product_{{$Product->id}}">

                                       {{currencydecimal(@$Product->prices->price)}}</span></p>
                                    </div>
                                 </div>

                                  <h5>Add Ons Per Product</h5>
                                    @forelse($Product->addons as $key=>$addon)
                                      <?php 

                                      $product_addon_price =$addon->price;
                                      if(count($Cart)>0){
                                          if(count($Cart->cart_addons)>0){ 
                                            $cart_addon = $Cart->cart_addons->pluck('quantity','addon_product_id')->toArray();
                                            if(array_key_exists($addon->id,$cart_addon)){
                                              $addon_qty = $cart_addon[$addon->id];
                                              $addon_qty_chk = 1;
                                              $cart_total_price +=$addon_qty*$product_addon_price;
                                              $total_addon_price +=$addon_qty*$product_addon_price;
                                            }else{
                                              $addon_qty_chk = 0;
                                              $addon_qty = 1;
                                            }
                                          }else{
                                            $addon_qty_chk = 0;
                                            $addon_qty = 1;
                                          }
                                      }elseif(count(@$CartShop[$Shop->id])>0){
                                            $addon_qty_chk = 0;
                                            $addon_qty = 1;
                                           if(count(@$CartShop[$Shop->id][@$Product->id])>0){
                                             $addon_qty = @$CartShop[$Shop->id][$Product->id]['addons'][$addon->id]['quantity'];
                                             $addon_qty_chk = 1;
                                             $cart_total_price += $addon_qty*$product_addon_price;
                                             $total_addon_price +=$addon_qty*$product_addon_price;
                                           }
                                      }else{
                                        $addon_qty_chk = 0;
                                        $addon_qty = 1;
                                      }
                                      ?>
                                       <div class="row">
                                            <div class="col-md-4">
                                               <input type="checkbox" name="product_addons[{{$addon->id}}]" value="{{$addon->id}}" class="all_addons" @if($addon_qty_chk>0) checked @endif>
                                               <label for="radio1">
                                               {{@$addon->addon->name}}<br>
                                               </label>
                                               
                                            </div>
                                            <div class="col-md-4">
                                               <div class="section" style="padding-bottom:20px;">
                                                  <div>
                                                     <div class="btn-minus btn-number" data-field="addons_qty[{{$addon->id}}]" data-id="{{$addon->id}}" data-type="minus" >
                                                        <span class="glyphicon glyphicon-minus"></span>
                                                     </div>
                                                     <input value="{{$addon_qty}}" class=" input-number" name="addons_qty[{{$addon->id}}]" id="addons_{{$addon->id}}" min="1" max="100" data-price="{{$product_addon_price}}" />
                                                     <div class="btn-plus btn-number" data-field="addons_qty[{{$addon->id}}]" data-type="plus" data-id="{{$addon->id}}">
                                                        <span class="glyphicon glyphicon-plus"></span>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                            <div class="col-md-2">
                                               <p class="Total_price"><span>
                                               <input type="hidden" name="addons_price[{{$addon->id}}]" 
                                               id="addons_price_{{$addon->id}}" 
                                               value="{{$product_addon_price}}" />
                                                <input type="hidden" name="addons_name[{{$addon->id}}]" 
                                               id="addons_name_{{$addon->id}}" 
                                               value="{{@$addon->addon->name}}" />
                                               {{currencydecimal($product_addon_price)}}</span></p>
                                            </div>
                                            <div class="col-md-2">
                                               <p class="Total_price"><span id="total_addons_{{$addon->id}}">
                                               
                                               
                                               {{currencydecimal($addon_qty*$product_addon_price)}}</span></p>
                                            </div>
                                       </div>
                                    @empty
                                      <p>No addons </p>
                                    @endforelse
                             
                              <div class="row">  
                                  <div class="col-md-12">
                                      <input type="hidden" name="product_price" id="product_price" value="{{$Product->prices->price}}" />
                                      <input type="hidden" name="total_product_price" id="total_product_price" value="{{$prod_qty*$Product->prices->price}}" />
                                      <input type="hidden" name="total_addons_price" id="total_addons_price" value="{{$total_addon_price}}" />
                                      <input type="hidden" name="total_price" id="total_price" value="{{$cart_total_price}}" />
                                      <input type="hidden" name="cart_id" id="cart_id" value="{{$cart_id}}" />
                                       <h3 class="Total_price">Total :<span id="tot_pr"> 
                                       {{currencydecimal($prod_qty*$total_addon_price+$prod_qty*$Product->prices->price)}}</span></h3>
                                  </div>
                                </div>
                                <!-- <div class="row"> 
                                    <input type="checkbox" value="1" name="new_cart" checked /> New 
                                </div> -->
                                   <h5>Custom Notes</h5>
                                  
                                      <textarea  id="fullfilled" class="form-control counted" name="note" placeholder="Write Something" rows="5" style="margin-bottom:10px;"> {{$prod_note}} </textarea>
                                   
                               
                                
                                
                                   <button class="btn btn-lg btn-info add-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to Cart</button>
                                   
                                  
                                
                             </div>
                          </div>
                       </div>
                    </form>
                </div>
             </div>
          </div>
       </div>
         
         <!-- End container -->
@endsection
@section('styles')
<style type="text/css">
.center{
width: 150px;
  margin: 40px auto;
  
}
</style>
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('assets/user/js/jquery-latest.min.js')}}"></script>
<script type="text/javascript">


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


//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field'); 
    type      = $(this).attr('data-type');
    var id = $(this).attr('data-id');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if($("input[name='product_addons["+id+"]']").is(':checked')){
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                    price_calculation(id,'minus');
                } 
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if(type == 'plus') {

                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                    price_calculation(id,'plus');
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
   }
});

$('.btn-number-prod').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field'); 
    type      = $(this).attr('data-type');
    var id = $(this).attr('data-id'); 
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
                product_price_calculation(id,'minus');
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
                product_price_calculation(id,'plus');
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});




$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });


$('.all_addons').on('change',function(){
  if($(this).is(':checked')){
    var val = $(this).val();
    var qty = $('#addons_'+val).val();
    var price = $('#addons_'+val).data('price');
    var total = parseInt(qty*price)+parseInt($('#total_price').val());
    var tot_amt = qty*price;
      $('#total_addons_'+val).html("{{Setting::get('currency')}}"+tot_amt.toFixed(2));

      $('#total_addons_price').val(parseInt(tot_amt)+parseInt($('#total_addons_price').val()));
      var total = parseInt(price)+parseInt($('#total_price').val());

      var total_product_price = $('#total_product_price').val();
      var total_addons_price = $('#total_addons_price').val();
      var product_qty = $('#product_{{$Product->id}}').val();
      total = parseInt(total_product_price)+product_qty*parseInt(total_addons_price);
      $('#total_price').val(total); 
      $('#tot_pr').html("{{Setting::get('currency')}}"+total.toFixed(2));
  }else{
    var val = $(this).val();
    var qty = $('#addons_'+val).val();
    var price = $('#addons_'+val).data('price');
    var total = parseInt($('#total_price').val())-parseInt(qty*price);
    var tot_amt = qty*price;
      $('#total_addons_'+val).html("{{Setting::get('currency')}}"+tot_amt.toFixed(2));

      $('#total_addons_price').val(parseInt($('#total_addons_price').val())-parseInt(tot_amt));
      var total = parseInt(price)+parseInt($('#total_price').val());

      var total_product_price = $('#total_product_price').val();
      var total_addons_price = $('#total_addons_price').val();
      var product_qty = $('#product_{{$Product->id}}').val();
      total = parseInt(total_product_price)+product_qty*parseInt(total_addons_price);
      $('#total_price').val(total); 
      $('#tot_pr').html("{{Setting::get('currency')}}"+total.toFixed(2));
  }
});

function price_calculation(val,type){

    if(type == 'plus'){
      //var val = $('#'+id).val();
      var qty = $('#addons_'+val).val();
      var price = $('#addons_'+val).data('price');
      var tot_amt = qty*price;
      $('#total_addons_'+val).html("{{Setting::get('currency')}}"+tot_amt.toFixed(2));

      $('#total_addons_price').val(parseInt(price)+parseInt($('#total_addons_price').val()));
      var total = parseInt(price)+parseInt($('#total_price').val());

      var total_product_price = $('#total_product_price').val();
      var total_addons_price = $('#total_addons_price').val();
      var product_qty = $('#product_{{$Product->id}}').val();
      total = parseInt(total_product_price)+product_qty*parseInt(total_addons_price);
      $('#total_price').val(total); 
      $('#tot_pr').html("{{Setting::get('currency')}}"+total.toFixed(2));
    }else{
      //var val = $(this).val();
      var qty = $('#addons_'+val).val();
      var price = $('#addons_'+val).data('price');
      var tot_amt = qty*price;
      $('#total_addons_'+val).html("{{Setting::get('currency')}}"+tot_amt.toFixed(2));
      $('#total_addons_price').val(parseInt($('#total_addons_price').val())-parseInt(price));

      var total = parseInt($('#total_price').val())-parseInt(price);
      var total_product_price = $('#total_product_price').val();
      var total_addons_price = $('#total_addons_price').val();
      var product_qty = $('#product_{{$Product->id}}').val();
      total = parseInt(total_product_price)+product_qty*parseInt(total_addons_price);
      $('#total_price').val(total); 
      $('#tot_pr').html("{{Setting::get('currency')}}"+total.toFixed(2));
    }
}

  function product_price_calculation(val,type){

    if(type == 'plus'){
      //var val = $('#'+id).val();
      var qty = $('#product_'+val).val();
      var price = $('#product_'+val).data('price');
      var tot_amt = qty*price;
      $('#total_product_'+val).html("{{Setting::get('currency')}}"+tot_amt.toFixed(2));
      $('#total_product_price').val(tot_amt);
      var total = parseInt(price)+parseInt($('#total_price').val());
      
      var total_product_price = $('#total_product_price').val();
      var total_addons_price = $('#total_addons_price').val();
      total = parseInt(total_product_price)+qty*parseInt(total_addons_price);
      $('#total_price').val(total); 
      $('#tot_pr').html("{{Setting::get('currency')}}"+total.toFixed(2));
    }else{
      //var val = $(this).val();
      var qty = $('#product_'+val).val();
      var price = $('#product_'+val).data('price');
      var tot_amt = qty*price;
      $('#total_product_'+val).html("{{Setting::get('currency')}}"+tot_amt.toFixed(2));
      $('#total_product_price').val(tot_amt);
      var total = parseInt($('#total_price').val())-parseInt(price);

      var total_product_price = $('#total_product_price').val();
      var total_addons_price = $('#total_addons_price').val();
      total = parseInt(total_product_price)+qty*parseInt(total_addons_price);
      $('#total_price').val(total); 
      $('#tot_pr').html("{{Setting::get('currency')}}"+total.toFixed(2));
    }

}

</script>
@endsection
