 <form action="{{url('orders')}}" id="pay_now_form" method="POST" >
                {{ csrf_field() }}

    <input type="hidden" value="{{Session::get('wallet')}}" name="wallet" />
    <input type="hidden" value="{{Request::get('type')}}" name="payment_mode" />
    <input type="hidden" value="{{Session::get('note')}}" name="note" />
    <input type="hidden" value="{{Session::get('user_address_id')}}" name="user_address_id" />
    @if(Setting::get('SCHEDULE_ORDER')==1)
    <input type="hidden" value="{{Session::get('delivery_date')}}" name="delivery_date" />
    @endif
    
    <input type="hidden" value="1" name="payment_mode_again" />
    <div class="modal-body">
        <div class="row no-margin" id="card-payment">
            <div class="form-group col-md-12 col-sm-12">
                <label>Ripple Price ( 1 ETH = {{$ether_response->result->ethusd}} USD ) </label>
                <?php $total_amount = number_format((Session::get('amount')/$ether_response->result->ethusd),6); ?>
                <input name="amount" id="amount" value="{{$total_amount}}" type="text"  readonly class="form-control" >
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <label>Enter Your Transaction ID</label>
                <input name="payment_id" id="transaction_id" onChange="checkpayment();" type="text" class="form-control" placeholder="Enter Your Transaction ID" />
                <div id ="ripple_form_error" class="ripple_error"></div>
            </div>
            
        </div>
    </div>
   
  <div class="modal-footer ripple_footer">
    
    <div id="loader" class="ripple_loader" style="display:none">
    <h3 id="msg">Please Wait Your Transaction Is In Process.....</h3>
    <img  height="200px" width="200px" src="{{asset('images/roundloader.gif')}}" /></div>
    <button type="submit" id="ord_btn" disabled  class="btn btn-default rip_full">Order Place</button>
  </div>
</form>

@section('scripts')
<script>
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
  $('.pcpy').show();
}
var error = 0;
function checkpayment(){
    if($('#transaction_id').val() == ''){
        return false;
    }
    var myVar ;
    $.ajax({
      url: "{{url('checkEtherPayment')}}",
      type: "GET",
      data:{'payment_id':$('#transaction_id').val(),'amount':$('#amount').val()}
        })
      .done(function(response){ 
            console.log(response);
            if(response.success == 'Ok'){
                $("#ripple_form_error").html('');
                $('#loader').hide();
                $('#ord_btn').prop('disabled',false);
            }else if(response.error == 'id_not_valid'){
                error =1;
                $('#ord_btn').prop('disabled',true);
                $('#msg').html('');
                $("#ripple_form_error").html('Invalid Transaction Id');
            }else if(response.error == 'price_not_match'){
                error =1;
                $('#ord_btn').prop('disabled',true);
                $('#msg').html('');
                $("#ripple_form_error").html('Price doesn\'t match');
            }
            else{
                $('#loader').show();
                $('#ord_btn').prop('disabled',true);
                $('#msg').html('Please wait until your Transaction is Processing...');
                myVar = setTimeout(checkpayment, 5000);
            }
            
        })
    .error(function(jqXhr,status){
        if(jqXhr.status === 422) {
            error =1;
            $("#ripple_form_error").html('');
            $("#ripple_form_error ").show();
            var errors = jqXhr.responseJSON;
            console.log(errors);
            $.each( errors , function( key, value ) { 
                $("#ripple_form_error").html(value);
            }); 
        } 
    
        $('#ord_btn').prop('disabled',true);
    })

    
}

setTimeout(function(){ 
        if(error ==0){
            checkpayment();
        }
    }, 5000);
</script>

@endsection

