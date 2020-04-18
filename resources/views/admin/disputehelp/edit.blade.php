@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit DisputeHelp</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.disputehelp.update',$Disputehelp->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">Message</label>
                    <input type="text" id="name"  class="form-control "  name="name" value="{{$Disputehelp->name}}"  required autofocus />
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">Dispute Type</label>
                    <select  id="type"  class="form-control "  name="type"   required  >
                        <option value="CANCELLED" @if($Disputehelp->type == 'CANCELLED') selected @endif>CANCELLED</option>
                        <option value="COMPLAINED" @if($Disputehelp->type == 'COMPLAINED') selected @endif >COMPLAINED</option>
                        <option value="REFUND" @if($Disputehelp->type == 'REFUND') selected @endif >REFUND</option>
                    </select>
                        @if ($errors->has('type'))
                            <span class="help-block">
                                <strong>{{ $errors->first('type') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="col-xs-12 mb-2">
                    <a href="{{ url('admin/disputehelp') }}" class="btn btn-warning mr-1">
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
