@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('inventory.product.add_title')</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">

            <form role="form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <input type="hidden" name="shop" value="{{Request::get('shop')}}" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">@lang('inventory.product.name')</label>

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">@lang('inventory.product.desc')</label>

                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                        @if(Setting::get('SUB_CATEGORY',1))
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category">@lang('inventory.product.category')</label>

                            <select class="form-control" id="parent_id" name="parent_id" required >
                                @if(Request::get('shop'))
                                    @forelse($Categories as $Category)
                                        <option value="{{ $Category->id }}" >{{ $Category->name }}</option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                            @if ($errors->has('parent_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('parent_id') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('sub_category') ? ' has-error' : '' }}">
                            <label for="category">@lang('inventory.product.sub_category')</label>

                            <select class="form-control" id="category" name="category" required >
                                
                            </select>
                            @if ($errors->has('category'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                        </div>
                        @else
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category">@lang('inventory.product.category')</label>

                            <select class="form-control" id="category" name="category" required >
                                @if(Request::get('shop'))
                                    @forelse($Categories as $Category)
                                        <option value="{{ $Category->id }}" >{{ $Category->name }}</option>
                                    @empty
                                    @endforelse
                                @endif
                            </select>
                            @if ($errors->has('category'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                        </div>
                        @endif
                        <div class="form-group{{ $errors->has('pure_veg') ? ' has-error' : '' }}">
                            <label for="parent_id">@lang('shop.create.pure_veg')</label>
                            <label class="radio-inline">
                                <input type="radio" value="non-veg" name="food_type">No
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="veg" name="food_type" checked >Yes
                            </label>

                            @if ($errors->has('food_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('food_type') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status">@lang('inventory.product.status')</label>

                            <select class="form-control" id="status" name="status">
                                <option value="enabled">Enabled</option>
                                <option value="disabled">Disabled</option>
                            </select>

                            @if ($errors->has('status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('product_position') ? ' has-error' : '' }}">
                            <label for="status">@lang('inventory.product.product_position')</label>

                            <input type="number" class="form-control" id="product_position" name="product_position" required autofocus/>
                                

                            @if ($errors->has('product_position'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_position') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image">@lang('inventory.product.image')</label>

                            <input type="file" accept="image/*" required name="image[]" class="dropify form-control" id="image" multiple="" aria-describedby="fileHelp">

                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('featured') ? ' has-error' : '' }}">
                            <label for="featured">@lang('inventory.product.featured')</label>
                            <input type="checkbox" class="form-control" id="featured" name="featured"/>
                             <label for="featured">@lang('inventory.product.featured_position')</label>
                            <input type="number" min="0" class="form-control" value="1" id="featured_position" name="featured_position"/>
                          

                            @if ($errors->has('featured'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('featured') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('featured_image') ? ' has-error' : '' }}">
                            <label for="image">@lang('inventory.product.featured_image')</label>
                            <p>@lang('inventory.product.featured_image_note')</p>

                            <input type="file" accept="image/*" required name="featured_image" class="dropify form-control" id="featured_image" aria-describedby="fileHelp">

                            @if ($errors->has('featured_image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('featured_image') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>
                    <div class="col-md-6">

                        <h4 class="m-t-0 header-title">
                            <b>@lang('inventory.product.pricing_title')</b>
                        </h4>
                        <hr>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price">@lang('inventory.product.price')</label>

                            <input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}" required autofocus>

                            @if ($errors->has('price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}" style="display:none1">
                            <label for="discount">@lang('inventory.product.discount')</label>

                            <input id="discount" type="text" class="form-control" name="discount" value="{{ old('discount', 0) }}" required autofocus>

                            @if ($errors->has('discount'))
                            <span class="help-block">
                                <strong>{{ $errors->first('discount') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('discount_type') ? ' has-error' : '' }}" style="display:none1">
                            <label for="discount_type">@lang('inventory.product.discount_type')</label>

                            <select class="form-control" id="discount_type" name="discount_type">
                                <option value="percentage">Percentage</option>
                                <option value="amount">Amount</option>
                            </select>

                            @if ($errors->has('discount_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('discount_type') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('out_of_stock') ? ' has-error' : '' }}" >
                            <label for="out_of_stock">@lang('inventory.product.out_of_stock')</label>

                            <label class="radio-inline">
                                        <input type="checkbox" value="1" checked name="out_of_stock">Yes
                            </label>

                            @if ($errors->has('out_of_stock'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('out_of_stock') }}</strong>
                                </span>
                            @endif
                        </div>

                        <!-- <div class="form-group{{ $errors->has('currency') ? ' has-error' : '' }}">
                            <label for="currency">@lang('inventory.product.currency')</label>

                            <select class="form-control" id="currency" name="currency">
                                <option value="₹">₹ - Rupee</option>
                                <option value="$">$ - Dollars</option>
                                <option value="£">£ - Sterling Pounds</option>
                            </select>

                            @if ($errors->has('currency'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('currency') }}</strong>
                                </span>
                            @endif
                        </div> -->

                         
                        @if(Setting::get('PRODUCT_ADDONS')==1)
                         <div class="form-group{{ $errors->has('addons') ? ' has-error' : '' }}">
                                <label for="addons">@lang('inventory.product.addons')</label>
                                
                                @forelse($Addons as $key=>$addon)
                               
                                <p><input type="checkbox"  name="addons[{{$addon->id}}]" value="{{$addon->id}}">{{$addon->name}}</p>
                                <p>Price</p>
                                <p><input type="text" class="form-control"  name="addons_price[{{$addon->id}}]"  value="0" ></p>
                                @empty
                                @endforelse
                                @if ($errors->has('addons'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('addons') }}</strong>
                                    </span>
                                @endif
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col-xs-12 mb-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-warning mr-1">
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
    $('#parent_id').on('change',function(){
        var shop_id = "{{Request::get('shop')}}";
        var category = $(this).val();
        $.ajax({
            url: "{{url('/admin/subcategory/')}}?shop="+shop_id+"&category="+category,
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
                    $('#category').html(option);
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
    $('#all_addons').on('change',function(){
        var id = $(this).val();
        var name = $("#all_addons option[value='"+id+"']").text();
        var total_panel = $('#alladdons_price .panel').length;
        //alert(total_panel);
        if(id!='' && total_panel==1){
            $('.panel').show();
           var clone =  $(".panel").clone();
           $('#alladdons_price').append(clone); 
        }else{
            var clone =  $(".panel").clone();
           $('#alladdons_price').append(clone); 
        }
    });
</script>
@endsection