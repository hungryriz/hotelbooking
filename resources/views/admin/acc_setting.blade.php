@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Account Settings</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.accsetting.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">GOOGLE MAP KEY</label>
                    <input id="name" type="text" class="form-control" name="GOOGLE_MAP_KEY" value="{{ env('GOOGLE_MAP_KEY') }}" required autofocus>

                        @if ($errors->has('GOOGLE_MAP_KEY'))
                            <span class="help-block">
                                <strong>{{ $errors->first('GOOGLE_MAP_KEY') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group col-xs-12 mb-2 contact-repeater">
                    <label for="name">TWILIO SID</label>
                    <input id="TWILIO_SID" type="text" class="form-control" name="TWILIO_SID" value="{{ env('TWILIO_SID') }}" required autofocus>

                        @if ($errors->has('TWILIO_SID'))
                            <span class="help-block">
                                <strong>{{ $errors->first('TWILIO_SID') }}</strong>
                            </span>
                        @endif
                           
                </div>
                <div class="form-group col-xs-12 mb-2 contact-repeater">
                    <label for="name">TWILIO_TOKEN</label>
                    <input id="TWILIO_TOKEN" type="text" class="form-control" name="TWILIO_TOKEN" value="{{ env('TWILIO_TOKEN') }}" required autofocus>

                        @if ($errors->has('TWILIO_TOKEN'))
                            <span class="help-block">
                                <strong>{{ $errors->first('TWILIO_TOKEN') }}</strong>
                            </span>
                        @endif
                           
                </div>
                <div class="form-group col-xs-12 mb-2 contact-repeater">
                    <label for="name">TWILIO_FROM</label>
                    <input id="TWILIO_FROM" type="text" class="form-control" name="TWILIO_FROM" value="{{ env('TWILIO_FROM') }}" required autofocus>

                        @if ($errors->has('TWILIO_FROM'))
                            <span class="help-block">
                                <strong>{{ $errors->first('TWILIO_FROM') }}</strong>
                            </span>
                        @endif
                           
                </div>
                
                <div class="col-xs-12 mb-2">
                    <a href="{{ route('admin.accsetting') }}" class="btn btn-warning mr-1">
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

