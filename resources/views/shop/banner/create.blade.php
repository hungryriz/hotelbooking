@extends('shop.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add Banner</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('shop.banner.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
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
</script>
@endsection