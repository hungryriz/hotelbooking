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
                                <h4 class="card-title">Categories</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a href="{{ route('shop.categories.create') }}" class="btn btn-primary add-btn btn-darken-3">Add Category</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <table class="table table-striped table-bordered file-export">
                                        <thead>
                                            <tr>
                                                <th>S.no</th>
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($Categories as $key=>$Category)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$Category->name}}</td>
                                                <td>
                                                    @if(Setting::get('SUB_CATEGORY',0))
                                                     <a href="{{url('shop/subcategory?category='.$Category->id)}}">Sub Category</a>
                                                    @endif
                                                    @if(Setting::get('DEMO_MODE')==1)
                                                        <a href="{{ route('shop.categories.edit', $Category->id) }}" class="table-btn btn btn-icon btn-success"><i class="fa fa-pencil-square-o"></i></a>
                                                        <button  class="table-btn btn btn-icon btn-danger" form="resource-delete-{{ $Category->id }}" ><i class="fa fa-trash-o"></i></button>
                                                        
                                                        <form id="resource-delete-{{ $Category->id }}" action="{{ route('shop.categories.destroy', $Category->id)}}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                                <div class="row">
                                                    <div class="col-xs-12 text-center">
                                                        <h4>No categories in inventory</h4>
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
