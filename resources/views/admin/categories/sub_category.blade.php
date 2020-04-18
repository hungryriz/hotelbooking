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
                                <h4 class="card-title">@lang('inventory.category.sub_title')</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a href="{{ route('admin.categories.create') }}?shop={{Request::get('shop')}}" class="btn btn-primary add-btn btn-darken-3">@lang('inventory.category.add_subcategory')</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <table class="table table-striped table-bordered file-export">
                                        <thead>
                                            <tr>
                                                <th>@lang('inventory.category.sl_no')</th>
                                                <th>@lang('inventory.category.name')</th>
                                                <th>@lang('inventory.category.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($Categories as $key=>$Category)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$Category->name}}</td>
                                                <td>
                                                   
                                                    <a href="{{ route('admin.categories.edit', $Category->id) }}?shop={{Request::get('shop')}}" class="table-btn btn btn-icon btn-success"><i class="fa fa-pencil-square-o"></i></a>
                                                    @if(Setting::get('DEMO_MODE') == "1")
                                                    <button  class="table-btn btn btn-icon btn-danger" form="resource-delete-{{ $Category->id }}" ><i class="fa fa-trash-o"></i></button> 
                                                    @endif
                                                    <form id="resource-delete-{{ $Category->id }}" action="{{ route('admin.categories.destroy', $Category->id)}}" method="POST">

                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                                <div class="row">
                                                    <div class="col-xs-12 text-center">
                                                        <h4>@lang('inventory.category.sub_no_record_found')</h4>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- File export table -->
@endsection
