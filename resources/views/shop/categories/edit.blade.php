@extends('shop.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Category</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form role="form" method="POST" action="{{ route('shop.categories.update', $Category->id) }}" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name">Name</label>

                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $Category->name) }}" required autofocus>

                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description">Description</label>

                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $Category->description) }}</textarea>

                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
                 @if(Setting::get('SUB_CATEGORY',0))
                 <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                    <label for="parent_id">Parent</label>

                    <select class="form-control" id="parent_id" name="parent_id">
                        <option value="0">None</option>
                        @forelse($Categories as $Cat)
                        <option value="{{ $Cat->id }}" @if($Category->parent_id==$Cat->id) selected  @endif >{{ $Cat->name }}</option>
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
                    <label for="status">Status</label>

                    <select class="form-control" id="status" name="status">
                        <option value="enabled" @if($Category->status == "enabled") selected @endif>Enabled</option>
                        <option value="disabled" @if($Category->status == "disabled") selected @endif>Disabled</option>
                    </select>

                    @if ($errors->has('status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('status') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                    <label for="status">@lang('inventory.category.position')</label>
                    <input type="number" class="form-control" value="{{$Category->position}}" id="position" name="position"/>
                        @if ($errors->has('position'))
                            <span class="help-block">
                                <strong>{{ $errors->first('position') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                    <label for="image">Image</label>

                    <input type="file" accept="image/*" name="image" class="dropify" id="image" aria-describedby="fileHelp" data-default-file="{{ image($Category->images) }}">

                    @if ($errors->has('image'))
                        <span class="help-block">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                    @endif
                </div>

                 <div class="col-xs-12 mb-2">
                    <a href="{{ route('shop.categories.index') }}" class="btn btn-warning mr-1">
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