@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-6">
        <h4 class="page-title">
            <b>{{ $Category->name }}</b>
            <a href="{{ route('admin.categories.products.create', $Category->id) }}">
                <i class="fa fa-plus"></i>
            </a>
            <a href="{{ route('admin.categories.edit', $Category->id) }}">
                <i class="fa fa-pencil"></i>
            </a>
            <a href="{{ route('admin.categories.show', $Category->id) }}">
                <i class="fa fa-eye"></i>
            </a>
            <a href="{{ route('admin.categories.destroy', $Category->id) }}">
                <i class="fa fa-trash"></i>
            </a>
        </h4>
        <br>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <table class="category-table table">
                <thead class="manual-width">
                    <th></th>
                    <th>S.No</th>
                    <th>Flavour</th>
                    <th>Rate</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @forelse($Category->products as $Product)
                    <tr class="clickable head-row manual-width">
                        <td data-toggle="collapse" data-target="#accordion-{{ $Product->id }}" >
                            <span class="glyphicon glyphicon glyphicon-menu-up" aria-hidden="true"></span>
                        </td>
                        <td data-toggle="collapse" data-target="#accordion-{{ $Product->id }}" >{{ $Product->id }}</td>
                        <td data-toggle="collapse" data-target="#accordion-{{ $Product->id }}" >{{ $Product->name }}</td>
                        <td>{{ price($Product->prices) }}</td>
                        <td>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-icon btn-primary waves-effect waves-light">
                                <i class="glyphicon glyphicon-plus"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $Product->id) }}" class="btn btn-icon waves-effect btn-default waves-light">
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
                            <div class="collapse in" id="accordion-{{ $Product->id }}">
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
                                            <a href="{{ route('admin.products.edit', $Variant->id) }}" class="tab-btn btn btn-icon waves-effect btn-default waves-light">
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
                    
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style type="text/css">
    .card-img {
        position: relative;
        overflow: hidden;
        padding-bottom: 50%;
    }
    .card-img img {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
    }
    .card-text {
        height: 44px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection