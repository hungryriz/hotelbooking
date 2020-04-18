@extends('admin.layouts.app')

@section('content')

<div class="row file">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Translation</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#lang_page" class="btn btn-primary add-btn btn-darken-3">Add Language</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body collapse in">
        <div class="card-block">
            <form class="form-horizontal" role="form" method="GET" action="{{ Route('admin.translation.index') }}" enctype="multipart/form-data">
                 <div class="form-group col-xs-12 mb-2">
                    <label for="name">Choose Language</label>
                    <select id="name"  class="form-control" name="lang_name" >
                    @foreach($listlang as $lang)
                        <option value="{{$lang}}" @if(Request::get('lang_name')==$lang) selected @endif>{{$lang}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">Choose File</label>
                    <select id="name"  class="form-control" name="lang_file_name" >
                    @foreach($listlang_file as $lang_file)
                        <option value="{{substr($lang_file,0,-4)}}" @if(Request::get('lang_file_name')==substr($lang_file,0,-4)) selected @endif    >{{substr($lang_file,'0','-4')}}</option>
                    @endforeach
                    </select>
                </div>

                <!-- <div class="form-group col-xs-12 mb-2">
                    <label for="name">name</label>
                    <input type="hidden" name="key" value="title" />
                    <input type="text" class="form-control" name="value" value="" />
                       
                </div> -->
                <div class="col-xs-12 mb-2">
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check-square-o"></i> Search
                    </button>
                </div>
            </form>
            @if(count($data)>0 && env('DEMO_MODE')==1)
                <div>
                    <h4>@lang('setting.create.title')</h4>
                    <form action="{{Route('admin.translation.store')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="lang_name" value="{{Request::get('lang_name')}}" />
                        <input type="hidden" name="lang_file_name" value="{{Request::get('lang_file_name')}}" />
                        <input type="hidden" name="new_key" value="1" />
                        <div class="form-group{{ $errors->has('key') ? ' has-error' : '' }}">
                            <label for="key">@lang('setting.create.newkey')</label>

                            <input id="key" type="text" class="form-control" name="key" value="{{ old('key') }}" required autofocus>

                            @if ($errors->has('key'))
                            <span class="help-block">
                                <strong>{{ $errors->first('key') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('key') ? ' has-error' : '' }}">
                            <label for="key">@lang('setting.create.newvalue')</label>

                            <textarea id="value"  class="form-control" name="value" value="" required >{{ old('value') }}</textarea>

                            @if ($errors->has('value'))
                            <span class="help-block">
                                <strong>{{ $errors->first('value') }}</strong>
                            </span>
                            @endif
                        </div>
                        
                        
                        <button class="btn btn-primary">Save</button>
                    </form>
                </div>
                <br/>
            @endif
            <div>
                <table class="table table-striped table-bordered file-export">

                    <thead>
                        <tr>
                            <!-- <th>S.no</th> -->
                            <th>Key</th>
                            <th>Message</th>
                            <!-- <th>Actions</th> -->
                        </tr>
                    </thead>
                   <tbody>
                    @forelse($data as $key => $item)
                            @if(is_array($item))
                            <tr><td colspan="2">{{ $key }}</td></tr>
                                @foreach($item as $key1=>$item1)

                                    @if(is_array($item1))
                                        <tr><td colspan="2"> {{$key}} >> {{ $key1 }}</td></tr>
                                        @foreach($item1 as $key2=>$item2)
                                            @if(is_array($item2))
                                                <tr>
                                                    <td colspan="2"> {{$key}} >> {{ $key1 }} >> {{$key2}}</td>
                                                </tr>
                                                @foreach($item2 as $key3=>$item3)

                                                <tr>
                                                    <td>{{$key3}}</td>
                                                <td>
                                                    <form action="{{Route('admin.translation.store')}}" method="post">
                                                     <input type="hidden" name="lang_name" value="{{Request::get('lang_name')}}" />
                                                     <input type="hidden" name="lang_file_name" value="{{Request::get('lang_file_name')}}" />
                                                    <input type="hidden" name="par" value="{{$key.'.'.$key1.'.'.$key3}}" />
                                                    <input type="hidden" name="key" value="{{$key3}}" />
                                                    <textarea name="value">{{ $item3 }}</textarea>
                                                    <button class="btn">Save</button>
                                                    </form>
                                               </td>
                                                </tr>
                                                @endforeach

                                            @else
                                             
                                            <tr>
                                            <td>{{$key2}}</td>
                                            <td>
                                                <form action="{{Route('admin.translation.store')}}" method="post">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="lang_name" value="{{Request::get('lang_name')}}" />
                                                    <input type="hidden" name="lang_file_name" value="{{Request::get('lang_file_name')}}" />
                                                    <input type="hidden" name="par" value="{{$key.'.'.$key1}}" />
                                                    <input type="hidden" name="key" value="{{$key2}}" />
                                                    <textarea class="form-control" name="value">{{ $item2 }}</textarea>
                                                

                                                    <button class="btn">Save</button>
                                                 </form>
                                            </td>
                                            </tr>
                                               
                                            @endif
                                        @endforeach

                                    @else
                                        
                                            <tr>
                                                <td>{{$key1}}</td>
                                                <td>
                                                    <form action="{{Route('admin.translation.store')}}" method="post">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="lang_name" value="{{Request::get('lang_name')}}" />
                                                    <input type="hidden" name="lang_file_name" value="{{Request::get('lang_file_name')}}" />
                                                    <input type="hidden" name="par" value="{{$key}}" />
                                                    <input type="hidden" name="key" value="{{$key1}}" />
                                                    <textarea class="form-control" name="value">{{ $item1 }}</textarea>
                                                    <button class="btn">Save</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        
                                    @endif

                                @endforeach

                            @else
                                
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>    
                                            <form class="111" action="{{Route('admin.translation.store')}}" method="post">
                                            {{csrf_field()}}
                                            <input type="hidden" name="lang_name" value="{{Request::get('lang_name')}}" />
                                            <input type="hidden" name="lang_file_name" value="{{Request::get('lang_file_name')}}" />
                                            <input type="hidden" name="par" value="" />
                                            <input type="hidden" name="key" value="{{$key}}" />
                                            <textarea class="form-control" name="value">{{ $item }}</textarea>
                                            <button class="btn">Save</button>
                                            </form>
                                        </td>
                                    </tr>
                            @endif 
                    @empty 
                    @endforelse
                    </tbody>
                </table>               
            </div>
        </div>
    </div>
    </div>
</div>




                 <!-- Menu List Modal Starts -->
    <div class="modal fade text-xs-left" id="lang_page">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="myModalLabel1">Menu List</h2>
                </div>
                <div class="modal-body">
                    <div class="row m-0">
                         <form class="form-horizontal" role="form" method="POST" action="{{ Route('admin.translation.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group col-xs-12 mb-2">
                    <label for="name">New Language</label>
                    <input id="name" type="text" class="form-control" name="lang_code" value=""  autofocus>

                        @if ($errors->has('lang_code'))
                            <span class="help-block">
                                <strong>{{ $errors->first('lang_code') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="col-xs-12 mb-2">
                    <a href="" class="btn btn-warning mr-1">
                        <i class="ft-x"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check-square-o"></i> Save
                    </button>
                </div>
            </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu List Modal Ends -->

@endsection

