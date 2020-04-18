@extends('shop.layouts.app')

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
                <h4 class="card-title">@lang('inventory.addons.title')</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a href="{{ route('shop.addons.create') }}" class="btn btn-primary add-btn btn-darken-3">@lang('inventory.addons.add_addon')</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                <div class="card-block card-dashboard table-responsive">
                    <table class="table table-striped table-bordered file-export">
                        <thead>
                            <tr>
                                <th>@lang('inventory.addons.sl_no')</th>
                                <th>@lang('inventory.addons.name')</th>
                                <th>@lang('inventory.addons.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Addons as $Index => $Addon)
                                <tr>
                                    <td>{{$Index+1}}</td>
                                    <td>{{$Addon->name}}</td>
                                    <td>
                                        @if(Setting::get('DEMO_MODE')==1)
                                            <a href="{{ route('shop.addons.edit', $Addon->id) }}" class="table-btn btn btn-icon btn-success"><i class="fa fa-pencil-square-o"></i></a>
                                            
                                            <button  class="table-btn btn btn-icon btn-danger" form="resource-delete-{{ $Addon->id }}" ><i class="fa fa-trash-o"></i></button> 
                                            
                                            <form id="resource-delete-{{ $Addon->id }}" action="{{ route('shop.addons.destroy', $Addon->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9999" class="text-center">
                                        <h4>@lang('inventory.addons.no_record_found')</h4>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


