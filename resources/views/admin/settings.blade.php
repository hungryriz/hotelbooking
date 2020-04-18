@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Site Settings</h3>
    </div>

    <button class="submit pull-right" data-toggle="modal" data-target="#add-newsetting">Add New Setting Key</button>
    <div class="card-body collapse in">
        <div class="card-block">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
                <div id="accordion" class="panel-group">
                         {{ csrf_field() }}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#site_details">SITE DETAILS</a>
                                </h4>
                            </div>
                            <div id="site_details" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    @forelse(Setting::all() as $key=>$item)
                                        @if($key=='site_title')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='site_logo')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                            <br/>
                                            @if(Setting::get('site_logo')!='')
                                                <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{Setting::get('site_logo')}}">
                                            @endif
                                                <input type="file" accept="image/*" name="site_logo" class="dropify" id="site_logo" aria-describedby="fileHelp">

                                                @if ($errors->has($key))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first($key) }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        
                                        
                                        @elseif($key=='site_favicon')
                                    
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <br/>
                                                @if(Setting::get('site_favicon')!='')
                                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{Setting::get('site_favicon')}}">
                                                @endif
                                                    <input type="file" accept="image/*" name="site_favicon" class="dropify" id="site_favicon" aria-describedby="fileHelp">

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='site_copyright')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                         @elseif($key == 'default_lang')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <select name="default_lang" id="default_lang" value="" required class="form-control">
                                                  @foreach($listlang as $lang)
                                                        <option value="{{$lang}}" @if(Setting::get('default_lang')==$lang) selected @endif>{{$lang}}</option>
                                                  @endforeach
                                                      
                                                </select>
                                                    @if ($errors->has($key))
                                                        <span class="help-block">Setting::get('default_lang')
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key == 'currency')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <select name="currency" id="currency" value="" required class="form-control">
                                                      <option @if(Setting::get('currency') == "$") selected @endif data-id="USD" value="$">US Dollar (USD)</option>
                                                      <option @if(Setting::get('currency') == "₹") selected @endif data-id="INR" value="₹"> Indian Rupee (INR)</option>
                                                      <option @if(Setting::get('currency') == "د.ك") selected @endif data-id="KWD" value="د.ك">Kuwaiti Dinar (KWD)</option>
                                                      <option @if(Setting::get('currency') == "د.ب") selected @endif data-id="BHD" value="د.ب">Bahraini Dinar (BHD)</option>
                                                      <option @if(Setting::get('currency') == "﷼") selected @endif data-id="OMR" value="﷼">Omani Rial (OMR)</option>
                                                      <option @if(Setting::get('currency') == "£") selected @endif data-id="GBP" value="£">British Pound (GBP)</option>
                                                      <option @if(Setting::get('currency') == "€") selected @endif data-id="EUR" value="€">Euro (EUR)</option>
                                                      <option @if(Setting::get('currency') == "CHF") selected @endif data-id="CHF" value="CHF">Swiss Franc (CHF)</option>
                                                      <option @if(Setting::get('currency') == "ل.د") selected @endif data-id="LYD" value="ل.د">Libyan Dinar (LYD)</option>
                                                      <option @if(Setting::get('currency') == "B$") selected @endif data-id="BND" value="B$">Bruneian Dollar (BND)</option>
                                                      <option @if(Setting::get('currency') == "S$") selected @endif data-id="SGD" value="S$">Singapore Dollar (SGD)</option>
                                                      <option @if(Setting::get('currency') == "AU$") selected @endif data-id="AUD" value="AU$"> Australian Dollar (AUD)</option>
                                                      <option @if(Setting::get('currency') == "R$") selected @endif data-id="R$" value="R$"> Real Brazilian Currency (R$)</option>
                                                      <option @if(Setting::get('currency') == "PEN") selected @endif data-id="PEN" value="PEN"> Peruvian Sol (PEN)</option>
                                                  </select>
                                                    @if ($errors->has('currency'))
                                                        <span class="help-block">Setting::get('currency')
                                                            <strong>{{ $errors->first('currency') }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='currency_code')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='client_id')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                         @elseif($key=='client_secret')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}"  autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                         

                                        @elseif($key=='TWILIO_SID')
                                            
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='TWILIO_TOKEN')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='TWILIO_FROM')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                            
                                        @elseif($key=='PUBNUB_PUB_KEY')
                                            
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='PUBNUB_SUB_KEY')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#payment_details">PAYMENT DETAILS</a>
                                </h4>
                            </div>
                            <div id="payment_details" class="panel-collapse collapse ">
                                <div class="panel-body">
                                    @forelse(Setting::all() as $key=>$item)
                                        @if($key=='payment_mode')
                                            <?php 
                                                $payment_listall = ['PAYTM','CASH','BRAINTREE','STRIPE'];
                                                $payment_list = explode(',',Setting::get('payment_mode'))  ?>
                                                    <div class="form-group col-xs-12 mb-2">
                                                        <label for="name">@lang('setting.'.$key)</label>
                                                        </br>
                                                        @forelse($payment_listall as $kk=>$vv)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="{{$vv}}" name="payment_mode[]" @if(in_array($vv,$payment_list)) checked @endif  value="{{$vv}}">
                                                            <label class="form-check-label" for="{{$vv}}">{{$vv}}</label>
                                                        </div>
                                                        @empty
                                                        @endforelse
                                                        

                                                            @if ($errors->has('payment_mode'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('payment_mode') }}</strong>
                                                                </span>
                                                            @endif
                                                    </div>
                                        @elseif($key=='stripe_charge')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div> 
                                        @elseif($key=='stripe_publishable_key')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div> 
                                        @elseif($key=='stripe_secret_key')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div> 
                                        @elseif($key=='BRAINTREE_ENV')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div> 
                                        @elseif($key=='BRAINTREE_MERCHANT_ID')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div> 
                                        @elseif($key=='BRAINTREE_PUBLIC_KEY')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div> 
                                        @elseif($key=='RIPPLE_KEY')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='RIPPLE_BARCODE')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <br/>
                                                @if(Setting::get('RIPPLE_BARCODE')!='')
                                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{Setting::get('RIPPLE_BARCODE')}}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="RIPPLE_BARCODE" class="dropify" id="RIPPLE_BARCODE" aria-describedby="fileHelp">

                                                    @if ($errors->has('RIPPLE_BARCODE'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('RIPPLE_BARCODE') }}</strong>
                                                        </span>
                                                    @endif
                                            </div> 
                                        @elseif($key=='ETHER_KEY')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div> 
                                        @elseif($key=='ETHER_ADMIN_KEY')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div> 
                                        @elseif($key=='ETHER_BARCODE')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <br/>
                                                @if(Setting::get('ETHER_BARCODE')!='')
                                                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{Setting::get('ETHER_BARCODE')}}">
                                                    @endif
                                                    <input type="file" accept="image/*" name="ETHER_BARCODE" class="dropify" id="ETHER_BARCODE" aria-describedby="fileHelp">

                                                    @if ($errors->has('ETHER_BARCODE'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('ETHER_BARCODE') }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#product_order">PRODUCT AND ORDER SETTING</a>
                                </h4>
                            </div>
                            <div id="product_order" class="panel-collapse collapse">
                                <div class="panel-body">
                                    @forelse(Setting::all() as $key=>$item)
                                        @if($key=='manual_assign')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="manual_assign" class="col-xs-2 col-form-label"> @lang('setting.'.$key) </label>
                                                <div class="col-xs-10">
                                                    <div class="float-xs-left mr-1"><input @if(Setting::get('manual_assign') == 0) checked  @endif  name="manual_assign" value="0" type="radio" class="js-switch" data-color="#43b968">Manual</div>
                                                    <div class="float-xs-left mr-1"><input @if(Setting::get('manual_assign') == 1) checked  @endif  name="manual_assign" value="1" type="radio" class="js-switch" data-color="#43b968">Automatic</div>
                                                </div>
                                            </div>
                                        @elseif($key=='delivery_charge')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='resturant_response_time')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='search_distance')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='transporter_response_time')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='DEMO_MODE')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='SUB_CATEGORY')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='SCHEDULE_ORDER')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='PRODUCT_ADDONS')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='COMMISION_OVER_FOOD')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='COMMISION_OVER_DELIVERY_FEE')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='tax')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#app_details">APP SETTING</a>
                                </h4>
                            </div>
                            <div id="app_details" class="panel-collapse collapse">
                                <div class="panel-body">
                                    @forelse(Setting::all() as $key=>$item)
                                        @if($key=='ANDROID_ENV')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='ANDROID_PUSH_KEY')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='IOS_USER_ENV')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='IOS_PROVIDER_ENV')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>

                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#social_setting">SOCIAL SETTING</a>
                                </h4>
                            </div>
                            <div id="social_setting" class="panel-collapse collapse">
                                <div class="panel-body">
                                     @forelse(Setting::all() as $key=>$item)
                                        @if($key=='FB_CLIENT_ID')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='FB_CLIENT_SECRET')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='FB_REDIRECT')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='GOOGLE_CLIENT_ID')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='GOOGLE_CLIENT_SECRET')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='GOOGLE_REDIRECT')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='GOOGLE_API_KEY')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='GOOGLE_REDIRECT')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='GOOGLE_REDIRECT')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='SOCIAL_FACEBOOK_LINK')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}"  autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                         @elseif($key=='SOCIAL_TWITTER_LINK')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}"  autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='SOCIAL_INSTAGRAM_LINK')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='SOCIAL_PINTEREST_LINK')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='SOCIAL_VIMEO_LINK')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='SOCIAL_YOUTUBE_LINK')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='IOS_APP_LINK')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        @elseif($key=='ANDROID_APP_LINK')
                                            <div class="form-group col-xs-12 mb-2">
                                                <label for="name">@lang('setting.'.$key)</label>
                                                <input id="{{$key}}" type="text" class="form-control" name="{{$key}}" value="{{ $item }}" required autofocus @if($key=='currency_code') readonly @endif >

                                                    @if ($errors->has($key))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                         @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-xs-12 mb-2">
                    <a href="{{ route('admin.settings') }}" class="btn btn-warning mr-1">
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


 <!--  Add Address modal -->
    <div class="modal fade" id="add-newsetting" tabindex="-1" role="dialog" aria-labelledby="add-newsetting" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-popup">
                <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
                <form action="{{url('admin/setting/add')}}" method="POST" class="popup-form">
                    <h3 class="pop-tit">Add New Key And Value For Settings</h3>
                    {{ csrf_field() }}
                    
                    <input type="text" class="form-control form-white" id="new_key" name="key" placeholder="Setting key" required >
                    <input type="text" class="form-control form-white" id="value_new_key" name="value"  required placeholder="Setting Value" >
                    <button type="submit" class="btn btn-submit m-0">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add Address modal --> 

@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/dropify/dist/css/dropify.min.css') }}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/admin/plugins/dropify/dist/js/dropify.min.js') }}"></script>
<script type="text/javascript">
    $('.dropify').dropify();
    $('#currency').on('change',function(){ 
        var currency_code = $(this).find(':selected').data('id'); 
        $('#currency_code').val(currency_code);
    })
</script>
@endsection