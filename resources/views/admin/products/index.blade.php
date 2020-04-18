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
                    <h4 class="card-title">@lang('inventory.product.title')</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            <li><a href="{{ route('admin.products.create') }}?shop={{Request::get('shop')}}" class="btn btn-primary add-btn btn-darken-3">@lang('inventory.product.add_product')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block card-dashboard table-responsive">
                        <table class="table table-striped table-bordered file-export">
                            <thead>
                                <tr>
                                    <th>@lang('inventory.product.sl_no')</th>
                                    <th>@lang('inventory.product.name')</th>
                                    <th>@lang('inventory.product.cuisine')</th>
                                    <th>@lang('inventory.product.category')</th>
                                    <th>@lang('inventory.product.action')</th>
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
                                        <a href="{{ route('admin.products.edit', $Product->id) }}?shop={{Request::get('shop')}}" class="table-btn btn btn-icon btn-success"><i class="fa fa-pencil-square-o"></i></a>
                                         <button  class="table-btn btn btn-icon btn-danger" form="resource-delete-{{ $Product->id }}" ><i class="fa fa-trash-o"></i></button> 
                                        @endif
                                        <form id="resource-delete-{{ $Product->id }}" action="{{ route('admin.products.destroy', $Product->id)}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
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