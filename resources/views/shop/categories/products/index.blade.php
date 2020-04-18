@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-6">
        <h4 class="page-title">{{ $Category->name }}</h4>
        <br>
    </div>
    <div class="col-sm-6 text-right">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
    </div>
</div>
<div class="card-box row m-0 table-responsive">
    <table class="category-table table">
        <thead class="manual-width">
            <th></th>
            <th>S.No</th>
            <th>Flavour</th>
            <th>Rate</th>
            <th>Action</th>
        </thead>
        <tbody>
            @forelse($Category->products as $Index => $Product)
            <tr class="clickable head-row manual-width">
                <td data-toggle="collapse" data-target="#accordion-{{ $Product->id }}">
                    <span class="glyphicon glyphicon @if($Index == 0) glyphicon-menu-up @else glyphicon-menu-down @endif" aria-hidden="true"></span>
                </td>
                <td data-toggle="collapse" data-target="#accordion-{{ $Product->id }}">
                    {{ $Product->id }}
                </td>
                <td data-toggle="collapse" data-target="#accordion-{{ $Product->id }}">
                    {{ $Product->name }}
                </td>
                <td>
                    {{ price($Product->prices) }}
                </td>
                <td>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-icon btn-primary waves-effect waves-light">
                        <i class="glyphicon glyphicon-plus"></i>
                    </a>
                    <a href="{{ route('admin.products.edit', $Product->id) }}" class="btn btn-icon waves-effect btn-warning waves-light">
                        <i class="glyphicon glyphicon-pencil"></i>
                    </a>
                    <button class="btn btn-icon waves-effect waves-light btn-danger" form="resource-delete-{{ $Product->id }}">
                        <i class="fa fa-remove"></i>
                    </button>
                    <form id="resource-delete-{{ $Product->id }}" action="{{ route('admin.products.destroy', $Product->id)}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </td>
            </tr>
            <tr class="hiddenRow btm-row">
                <td colspan="5" style="padding: 0;">
                    <div class="collapse @if($Index == 0) in @endif" id="accordion-{{ $Product->id }}">
                        <table class="category-table table sub-table des-table" style="width: 100%;">
                            <tr class="des-block row m-0">
                                <td class="des-block-left col-sm-4 col-xs-12">
                                    <div class="flavour-img bg-img" style="background-image: url({{ image($Product->images) }});"></div>
                                </td>
                                <td class="des-block-right col-sm-9 col-xs-12">
                                    <h4 class="des-tit">Description</h4>
                                    <p class="des-txt">{{ $Product->description }}</p>
                                </td>
                            </tr>
                        </table>
                        <table class="category-table table sub-table" style="width: 100%;">
                            @forelse($Product->variants as $Variant)
                            <tr class="manual-width">
                                <td></td>
                                <td></td>
                                <td>{{ $Variant->name }}</td>
                                <td>{{ price($Variant->prices) }}</td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $Variant->id) }}" class="tab-btn btn btn-icon waves-effect btn-warning waves-light">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>
                                    <button class="btn btn-icon waves-effect waves-light btn-danger" form="resource-delete-{{ $Variant->id }}">
                                        <i class="fa fa-remove"></i>
                                    </button>
                                    <form id="resource-delete-{{ $Variant->id }}" action="{{ route('admin.products.destroy', $Variant->id)}}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr class="manual-width">
                                <td colspan="9999" class="text-center">
                                    <hr>
                                    <h4>No Variants in this Product!.</h4>
                                </td>
                            </tr>
                            @endforelse
                        </table> 
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9999" class="text-center">
                    <h4>No Products in this Category!.</h4>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
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