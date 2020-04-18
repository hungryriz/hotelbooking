@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">

            <form role="form" method="POST" action="{{ route('admin.cuisines.update', $Cuisine->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="row">
                    <div class="col-md-12">
                        <h4 class="m-t-0 header-title">
                            <b>@lang('inventory.cuisine.edit_title')</b>
                        </h4>
                        <hr>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">@lang('inventory.cuisine.name')</label>

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $Cuisine->name) }}" required autofocus>

                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="col-md-4 col-md-offset-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                Save
                            </button>
                        </div>
                    </div>                 
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

