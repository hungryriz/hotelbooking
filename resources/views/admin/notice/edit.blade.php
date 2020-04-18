@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Notice</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.notice.update',$Notice->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">DeliveryPeople</label>
                    <select id="transporter_id" name="transporter_id" class="form-control">
                        <option value="">Choose Delivery People</option>
                        @foreach($Transporters as $Transporter)
                            <option value="{{$Transporter->id}}" @if($Notice->transporter_id == $Transporter->id) selected  @endif >{{$Transporter->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">Notice Title</label>
                    <input type="text" id="title"  class="form-control "  name="title" value="{{$Notice->title}}"  required autofocus />
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">Notice</label>
                    <textarea id="notice"  class="form-control "  name="notice"  required >{{$Notice->notice}}
                    </textarea>

                        @if ($errors->has('notice'))
                            <span class="help-block">
                                <strong>{{ $errors->first('notice') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">Extra Note</label>
                    <input type="text" id="note"  class="form-control "  name="note" value="{{$Notice->note}}"   />
                        @if ($errors->has('note'))
                            <span class="help-block">
                                <strong>{{ $errors->first('note') }}</strong>
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