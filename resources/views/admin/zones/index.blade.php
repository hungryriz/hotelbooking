@extends('admin.layouts.app')

@section('content')
<div class="card-box row m-0 table-responsive">
    <h4 class="page-title">
        <span class="m-r-20">@lang('admin.zones.index.title')</span>
        <a href="{{ route('admin.zones.create') }}" class="btn waves-effect btn-primary waves-light">
            <i class="fa fa-plus"></i>
        </a>
    </h4>
    <hr>
    <table class="table table-striped table-bordered" id="datatable-buttons">
        <thead>
            <tr>
                <th>#</th>
                <th>Zone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @if(sizeof($Zones))
            @foreach($Zones as $Index => $Zone)
                <tr>
                    <td class="v-align-middle">
                        {{ $Index+1 }}
                    </td>
                    <td class="v-align-middle">
                        {{ $Zone->name }}
                    </td>
                    <td class="v-align-middle">
                        <form action="{{ route('admin.zones.destroy', $Zone->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a href="{{ route('admin.zones.edit', $Zone->id) }}" class="btn btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                            <!-- <button class="btn btn-danger"><i class="fa fa-trash"></i></button> -->
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center">
                    <h4>No Service Zones have been registered. <a href="{{ route('admin.zones.create') }}">Add Zone</a></h4>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
@endsection
