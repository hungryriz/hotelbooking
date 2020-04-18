@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">@lang('inventory.category.add_title')</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form role="form" method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name">@lang('inventory.category.name')</label>

                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description">@lang('inventory.category.desc')</label>

                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>

                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('shop_id') ? ' has-error' : '' }}">
                    <label for="parent_id">@lang('inventory.category.resturant_name'): @if(Request::get('shop')) {{\App\Shop::find(Request::get('shop'))->name}} @endif</label>
                    <input name="shop_id" type="hidden" value="{{Request::get('shop')}}" />
                    @if ($errors->has('shop_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('shop_id') }}</strong>
                        </span>
                    @endif
                </div>
                @if(Setting::get('SUB_CATEGORY',1))
                <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                    <label for="parent_id">Parent</label>

                    <select class="form-control" id="parent_id" name="parent_id">
                        <option value="0">None</option>
                        @forelse($Categories as $Category)
                        <option value="{{ $Category->id }}">{{ $Category->name }}</option>
                        @empty
                        <option value="0">None</option>
                        @endforelse
                    </select>

                    @if ($errors->has('parent_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('parent_id') }}</strong>
                        </span>
                    @endif
                </div>
                @endif
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    <label for="status">@lang('inventory.category.status')</label>

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
                <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                    <label for="status">@lang('inventory.category.position')</label>
                    <input type="number" class="form-control" id="position" name="position"/>
                        @if ($errors->has('position'))
                            <span class="help-block">
                                <strong>{{ $errors->first('position') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                    <label for="image">@lang('inventory.category.image')</label>

                    <input type="file" accept="image/*" name="image" class="dropify" id="image" aria-describedby="fileHelp">

                    @if ($errors->has('image'))
                        <span class="help-block">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                    @endif
                </div>

                 <div class="col-xs-12 mb-2">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-warning mr-1">
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