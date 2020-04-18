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
                    <h4 class="card-title">Products</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            <li><a href="{{ route('shop.products.create') }}" class="btn btn-primary add-btn btn-darken-3">Add Product</a></li>
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
                                    <th>Cuisine Name</th>
                                    <th>Category Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($Products as $Index => $Product)
                                <tr>
                                    <td>{{$Index+1}}</td>
                                    <td>{{$Product->name}}</td>
                                    <td>    
                                            @foreach($Product->shop->cuisines as $Cuisine)
                                                {{$Cuisine->name}},
                                            @endforeach
                                    </td>
                                    <td>{{@$Product->categories[0]->name}}</td>
                                    <td>
                                        @if(Setting::get('DEMO_MODE')==1)
                                            <a href="{{ route('shop.products.edit', $Product->id) }}" class="table-btn btn btn-icon btn-success"><i class="fa fa-pencil-square-o"></i></a>
                                            <button  class="table-btn btn btn-icon btn-danger" form="resource-delete-{{ $Product->id }}" ><i class="fa fa-trash-o"></i></button>
                                            <form id="resource-delete-{{ $Product->id }}" action="{{ route('shop.products.destroy', $Product->id)}}" method="POST">
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

@section('scripts')
<script type="text/javascript">
    $('.collapse').on('show.bs.collapse', function () {
        $('.collapse.in').collapse('hide');
        var pElement = $('[data-target="#' + $(this).attr('id') + '"]');
        pElement.find('span.glyphicon.glyphicon-menu-down').removeClass("glyphicon glyphicon-menu-down").addClass("glyphicon glyphicon-menu-up");
        
    });

    $('.collapse').on('hide.bs.collapse', function () {
        var pElement = $('[data-target="#' + $(this).attr('id') + '"]');
        pElement.find('span.glyphicon.glyphicon-menu-up').removeClass("glyphicon glyphicon-menu-up").addClass("glyphicon glyphicon-menu-down");
        
    });
</script>
@endsection