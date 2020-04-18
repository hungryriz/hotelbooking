@extends('shop.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Product</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">

            <form role="form" method="POST" action="{{ route('shop.products.update', $Product->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <input type="hidden" name="shop" value="{{Auth::user()->id}}" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Name</label>

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $Product->name) }}" required autofocus>

                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Description</label>

                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $Product->description) }}</textarea>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category">Category</label>

                            <select class="form-control" id="category" name="category">
                                @foreach(\App\Category::where('shop_id',Auth::user()->id)->get() as $Category)
                                <option value="{{ $Category->id }}" @if(@$Product->categories[0]->id==$Category->id) selected  @endif >{{@$Product->categories[0]->category_id}}{{ $Category->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('category'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('pure_veg') ? ' has-error' : '' }}">
                            <label for="parent_id">Pure Veg</label>
                            <label class="radio-inline">
                                <input type="radio" value="non-veg" @if($Product->food_type=='non-veg')  checked @endif name="food_type">No
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="veg" name="food_type" @if($Product->food_type=='veg')  checked @endif >Yes
                            </label>

                            @if ($errors->has('food_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('food_type') }}</strong>
                                </span>
                            @endif
                        </div>
                            
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status">Status</label>

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

                            <input type="number" class="form-control" value="{{$Product->position}}" id="product_position" name="product_position" required autofocus/>
                                

                            @if ($errors->has('product_position'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_position') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image">Image</label>

                            <input type="file" accept="image/*" name="image" class="dropify" id="image" aria-describedby="fileHelp" data-default-file="{{ image($Product->images) }}">

                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                            <a class="submit pull-right" data-toggle="modal" data-target="#image-list">View Image List</a>
                        </div>
                        <div class="form-group{{ $errors->has('featured') ? ' has-error' : '' }}">
                            <label for="featured">@lang('inventory.product.featured')</label>
                            <input type="checkbox" class="form-control" @if($Product->featured) checked  @endif id="featured" name="featured"/>
                             <label for="featured">@lang('inventory.product.featured_position')</label>
                            <input type="number" min="0" class="form-control" value="{{$Product->featured}}" id="featured_position" name="featured_position"/>
                          

                            @if ($errors->has('featured'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('featured') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('featured_image') ? ' has-error' : '' }}">
                            <label for="image">@lang('inventory.product.featured_image')</label>
                            <p>@lang('inventory.product.featured_image_note')</p>

                            <input type="file" accept="image/*"  name="featured_image" class="dropify form-control" id="featured_image" aria-describedby="fileHelp" data-default-file="{{ image($Product->featured_images) }}">

                            @if ($errors->has('featured_image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('featured_image') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>
                    <div class="col-md-6">

                        <h4 class="m-t-0 header-title">
                            <b>Pricing</b>
                        </h4>
                        <hr>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price">Price</label>

                            <input id="price" type="text" class="form-control" name="price" value="{{ old('price', $Product->prices->price) }}" required autofocus>

                            @if ($errors->has('price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}" style="display:none">
                            <label for="discount">Discount</label>

                            <input id="discount" type="text" class="form-control" name="discount" value="{{ old('discount',$Product->prices->discount) }}" required autofocus>

                            @if ($errors->has('discount'))
                            <span class="help-block">
                                <strong>{{ $errors->first('discount') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('discount_type') ? ' has-error' : '' }}" style="display:none">
                            <label for="discount_type">Discount Type</label>

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
                        <div class="form-group{{ $errors->has('addon_status') ? ' has-error' : '' }}">
                            <label for="parent_id">@lang('inventory.product.addon_fixed')</label>
                            <label class="radio-inline">
                                <input type="checkbox" value="1" @if($Product->addon_status==1)  checked @endif name="addon_status">@lang('inventory.product.fixed')
                            </label>
                            @if ($errors->has('addon_status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('addon_status') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        @if(Setting::get('PRODUCT_ADDONS')==1)
                        <div class="form-group{{ $errors->has('addons') ? ' has-error' : '' }}">
                            <label for="addons">@lang('inventory.product.addons')</label>
                           <?php $product_addons = $Product->addons->pluck('price','addon_id')->all(); ?>
                            @forelse($Addons as $key=>$addon)
                            <?php 
                                if(array_key_exists($addon->id,$product_addons)){ 
                                    $product_price = $product_addons[$addon->id]; 
                                }else{
                                    $product_price = 0;
                                    }  ?>
                            <p><input type="checkbox" @if(array_key_exists($addon->id,$product_addons)) checked @endif name="addons[{{$addon->id}}]" value="{{$addon->id}}">{{$addon->name}}</p>
                            <p>Price</p>
                            <p><input type="text" class="form-control"  name="addons_price[{{$addon->id}}]" @if(array_key_exists($addon->id,$product_addons)) value="{{$product_price}}" @else value="0" @endif></p>
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
                    <a href="{{ route('shop.products.index') }}" class="btn btn-warning mr-1">
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


<!-- Order List Modal Starts -->
<div class="modal fade text-xs-left" id="image-list">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="myModalLabel1">Product Image List  </h2>
                <!-- <div><p id="order_timer"></p></div> -->
            </div>
            <div class="modal-body">
                <div class="row m-0">
                    <dl class="order-modal-top">
                        @forelse($Product->images as $img)
                        <div class="row m-0">
                            <dt class="col-sm-3 order-txt p-0">
                                <img src="{{$img->url}}"  height="100px" width="100px" />
                            </dt> 
                            <dd class="col-sm-9 order-txt orderid">
                               <button  class="table-btn btn btn-icon btn-danger" form="resourceimg-delete-{{ $img->id }}" ><i class="fa fa-trash-o"></i></button> 
                                       
                                        <form id="resourceimg-delete-{{ $img->id }}" action="{{ route('shop.productimage.destroy', $img->id)}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                            </dd>
                        </div>
                       @empty
                        <div>No Image Found</div>
                       @endforelse
                    </dl>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Order List Modal Ends -->
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
</script>
@endsection