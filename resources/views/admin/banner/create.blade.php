@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add Banner</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.banner.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">Resturants</label>
                    <select id="shop_id" name="shop_id" class="form-control" required>
                        <option value="">Choose Resturant</option>
                        @foreach($Resturants as $Resturant)
                            <option value="{{$Resturant->id}}">{{$Resturant->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">Products</label>
                    <select id="product_id" name="product_id" class="form-control" required>
                        <option value="">Choose Product</option>
                        
                    </select>
                </div>
                 <div class="form-group col-xs-12 mb-2">
                    <label for="name">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="">Choose Status</option>
                        <option value="active" >Active</option>
                        <option value="inactive" selected >Inactive</option>
                       
                    </select>
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">Position</label>
                    <select id="position" name="position" class="form-control">
                        <option value="0">Choose Position</option>
                        @for($i=1;$i<=10;$i++)
                            <option value="{{$i}}"  >{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">Banner</label>
                    <input type="file" accept="image/*" required name="image" class="dropify form-control" id="image" aria-describedby="fileHelp">

                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                </div>
                <div class="col-xs-12 mb-2">
                    <a href="{{ url('admin/notice') }}" class="btn btn-warning mr-1">
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
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/multiselect/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/dropify/dist/css/dropify.min.css') }}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/admin/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/plugins/dropify/dist/js/dropify.min.js') }}"></script>
<script type="text/javascript">
    $('#categories').multiSelect({ selectableOptgroup: true });
    $('.dropify').dropify();
    $('#shop_id').on('change',function(){
       
        var shop_id = $(this).val();
        $.ajax({
            url: "{{url('/admin/products/')}}?shop="+shop_id,
            type:'GET',
            success: function(data) { 
                if($.isEmptyObject(data.error)){
                    var option = '';
                    if(data.length>0){
                        $.each( data , function( key, value ) { 
                            option +="<option value='"+value.id+"'>"+value.name+"</option>";
                        });
                    }else{
                        option +="<option value=''>None</option>";
                    }
                    $('#product_id').html(option);
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
</script>
@endsection