@extends('shop.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Create Product</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">

            <form role="form" method="POST" action="{{ route('shop.products.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <input type="hidden" name="shop" value="{{Auth::user()->id}}" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Name</label>

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Description</label>

                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category">Category</label>

                            <select class="form-control" id="category" name="category">
                                
                                @foreach(Request::user()->categories as $Category)
                                    <option value="{{ $Category->id }}" >{{ $Category->name }}</option>
                                    
                                @endforeach
                               
                            </select>
                            @if ($errors->has('category'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                        </div>
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

                            <input type="number" class="form-control" id="product_position" name="product_position" required autofocus/>
                                

                            @if ($errors->has('product_position'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('product_position') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image">Image</label>

                            <input type="file" accept="image/*" required name="image[]" class="dropify form-control" id="image" aria-describedby="fileHelp">

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
                            <b>Pricing</b>
                        </h4>
                        <hr>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price">Price</label>

                            <input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}" required autofocus>

                            @if ($errors->has('price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}" style="display:none">
                            <label for="discount">Discount</label>

                            <input id="discount" type="text" class="form-control" name="discount" value="{{ old('discount', 0) }}" required autofocus>

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

                        <!-- <div class="form-group{{ $errors->has('currency') ? ' has-error' : '' }}">
                            <label for="currency">Currency</label>

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
                            <p><input type="checkbox" name="addons[]" value="{{$addon->id}}">{{$addon->name}}</p>
                            <p>Price</p>
                            <p><input type="text" class="form-control" name="addons_price[]" value="0"></p>
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