@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Promocode</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form role="form" method="POST" action="{{ route('admin.promocodes.update',$Promocode->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group{{ $errors->has('promo_code') ? ' has-error' : '' }}">
                    <label for="promo_code">Promo Code</label>

                    <input id="promo_code" type="text" class="form-control" name="promo_code" value="{{ old('promo_code',$Promocode->promo_code) }}" required autofocus>

                    @if ($errors->has('promo_code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('promo_code') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
                    <label for="promo_code">Discount</label>

                    <input id="discount" type="text" class="form-control" name="discount" value="{{ old('discount', $Promocode->discount) }}" required >

                    @if ($errors->has('discount'))
                    <span class="help-block">
                        <strong>{{ $errors->first('discount') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('coupon_limit') ? ' has-error' : '' }}">
                    <label for="coupon_limit">Usage Limit Per Coupon</label>

                    <input id="coupon_limit" type="text" class="form-control" name="coupon_limit" value="{{ old('coupon_limit', $Promocode->coupon_limit) }}" required >

                    @if ($errors->has('coupon_limit'))
                    <span class="help-block">
                        <strong>{{ $errors->first('coupon_limit') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('coupon_user_limit') ? ' has-error' : '' }}">
                    <label for="coupon_user_limit">Usage Limit Per User</label>

                    <input id="coupon_user_limit" type="text" class="form-control" name="coupon_user_limit" value="{{ old('coupon_user_limit', $Promocode->coupon_user_limit) }}" required >

                    @if ($errors->has('coupon_user_limit'))
                    <span class="help-block">
                        <strong>{{ $errors->first('coupon_user_limit') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('promocode_type') ? ' has-error' : '' }}">
                    <label for="status">Promocode Type</label>

                    <select class="form-control" id="promocode_type" name="promocode_type">
                        <option value="amount"  @if($Promocode->promocode_type == 'amount')  selected @endif >Amount</option>
                        <option value="percent" @if($Promocode->promocode_type == 'percent')  selected @endif >Percent</option>
                    </select>

                    @if ($errors->has('promocode_type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('promocode_type') }}</strong>
                        </span>
                    @endif
                </div>
                 <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    <label for="status">Promocode Type</label>

                    <select class="form-control" id="status" name="status">
                        <option value="ADDED" @if($Promocode->status == 'ADDED')  selected @endif >ADDED</option>
                        <option value="EXPIRED" @if($Promocode->status == 'EXPIRED')  selected @endif >EXPIRED</option>
                    </select>

                    @if ($errors->has('status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('status') }}</strong>
                        </span>
                    @endif
                </div>
                 <div class="form-group{{ $errors->has('avail_from') ? ' has-error' : '' }}">
                    <label for="avail_from">Available From</label>

                    <input id="avail_from" type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" name="avail_from" value="{{ old('avail_from', $Promocode->avail_from) }}" required >

                    @if ($errors->has('avail_from'))
                    <span class="help-block">
                        <strong>{{ $errors->first('avail_from') }}</strong>
                    </span>
                    @endif
                </div>
                 <div class="form-group{{ $errors->has('expiration') ? ' has-error' : '' }}">
                    <label for="expiration">Expire Date</label>

                    <input id="expiration" type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" name="expiration" value="{{ old('expiration', $Promocode->expiration) }}" required >

                    @if ($errors->has('expiration'))
                    <span class="help-block">
                        <strong>{{ $errors->first('expiration') }}</strong>
                    </span>
                    @endif
                </div>
                 <div class="col-xs-12 mb-2">
                    <a href="{{ route('admin.promocodes.index') }}" class="btn btn-warning mr-1">
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
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $('.datepicker').datepicker();
</script>
@endsection
