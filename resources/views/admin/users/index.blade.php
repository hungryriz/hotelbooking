@extends('admin.layouts.app')

@section('content')
<!-- File export table -->
<div class="row file">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
            @if(Setting::get('DEMO_MODE')==0)
            <div class="col-md-12" style="height:50px;color:red;">
                 ** Demo Mode : No Permission to Edit and Delete.
            </div>
            @endif
                <h4 class="card-title">@lang('user.index.title')</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <!-- <li><a href="{{ route('admin.transporters.create') }}" class="btn btn-primary add-btn btn-darken-3">Add Delivery People</a></li> -->
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                <div class="card-block card-dashboard table-responsive">
                    <table class="table table-striped table-bordered file-export">
                        <thead>
                            <tr>
                                <th>@lang('user.index.sl_no')</th>
                                <th>@lang('user.index.name')</th>
                                <th>@lang('user.index.email')</th>
                                <th>@lang('user.index.image')</th>
                                <th>@lang('user.index.contact_details')</th>
                                <th>@lang('user.index.rating')</th>
                                <th>@lang('user.index.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Users as $key=>$User)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$User->name}}</td>
                                    <td>
                                    @if(Setting::get('DEMO_MODE')==1)
                                    {{$User->email}}
                                    @else
                                    {{substr($User->email, 0, 1).'****'.substr($User->email, strpos($User->email, "@"))}}
                                    @endif
                                    </td>
                                    <td>
                                        @if($User->avatar) 
                                            <div class="bg-img com-img" style="background-image: url({{ asset($User->avatar) }});"></div>
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{$User->phone}}</td>
                                    <td class="star">
                                        <input type="hidden" class="rating" readonly value="3"/>
                                    </td>
                                    <td>
                                        @if(Setting::get('DEMO_MODE')==1)
                                        <a href="{{ route('admin.users.edit', $User->id) }}" class="table-btn btn btn-icon btn-success"><i class="fa fa-pencil-square-o"></i></a>
                                        <button   class="table-btn btn btn-icon btn-danger" form="resource-delete-{{ $User->id }}" ><i class="fa fa-trash-o"></i></button>
                                        @endif
                                        <form id="resource-delete-{{ $User->id }}" action="{{ route('admin.users.destroy', $User->id)}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="50">@lang('user.index.no_record_found')</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection