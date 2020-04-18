@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Create Demo Details</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form role="form" method="POST" action="{{ route('admin.demoapp.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('pass_code') ? ' has-error' : '' }}">
                    <label for="pass_code">Code</label>

                    <input id="pass_code" type="text" class="form-control" name="pass_code" value="{{ old('pass_code') }}" required autofocus>

                    @if ($errors->has('pass_code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('pass_code') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('base_url') ? ' has-error' : '' }}">
                    <label for="base_url">Base Url</label>

                    <input type="text" class="form-control" id="base_url" name="base_url" rows="3" required value="{{ old('base_url') }}" />

                    @if ($errors->has('base_url'))
                        <span class="help-block">
                            <strong>{{ $errors->first('base_url') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('client_id') ? ' has-error' : '' }}">
                    <label for="client_id">Client Id</label>

                    <input type="number" class="form-control" id="client_id" name="client_id"  required value="{{ old('client_id') }}" />

                    @if ($errors->has('client_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('client_id') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('client_secret') ? ' has-error' : '' }}">
                    <label for="client_secret">Client Secret</label>

                    <input type="text" class="form-control" id="client_secret" name="client_secret" rows="3" required value="{{ old('client_secret') }}" />

                    @if ($errors->has('client_secret'))
                        <span class="help-block">
                            <strong>{{ $errors->first('client_secret') }}</strong>
                        </span>
                    @endif
                </div>

                
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    <label for="status">Status</label>

                    <select class="form-control" id="status" name="status">
                        <option value="1">New</option>
                        <option value="0">Expaire</option>
                    </select>

                    @if ($errors->has('status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('status') }}</strong>
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
