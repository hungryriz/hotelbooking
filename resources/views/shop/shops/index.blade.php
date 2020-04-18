@extends('shop.layouts.app')

@section('content')
<div class="card-box row m-0 table-responsive">
    <h4 class="page-title">@lang('admin.shops.index.title')</h4>
    <hr>
    <table id="datatable-buttons" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Shops as $key=>$User)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $User->name }}</td>
                <td>{{ $User->email }}</td>
                <td>{{ $User->phone }}</td>
                <td>
                    <a href="{{ route('shop.shops.show', $User->id) }}" class="btn btn-icon waves-effect btn-primary waves-light">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="{{ route('shop.shops.show', $User->id) }}" class="btn btn-icon waves-effect btn-warning waves-light">
                        <i class="fa fa-archive"></i>
                    </a>
                    <a href="{{ route('shop.shops.edit', $User->id) }}" class="btn btn-icon waves-effect btn-default waves-light">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-icon waves-effect waves-light btn-danger" form="resource-delete-{{ $User->id }}">
                        <i class="fa fa-remove"></i>
                    </button>
                    <form id="resource-delete-{{ $User->id }}" action="{{ route('shop.shops.destroy', $User->id)}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>

<script src="{{ asset('assets/admin/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/responsive.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.scroller.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.colVis.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.fixedColumns.min.js') }}"></script>

<script src="{{ asset('assets/admin/pages/datatables.init.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        console.log('Hello');
        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({keys: true});
        $('#datatable-responsive').DataTable();
        $('#datatable-colvid').DataTable({
            "dom": 'C<"clear">lfrtip',
            "colVis": {
                "buttonText": "Change columns"
            }
        });
        var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
        var table = $('#datatable-fixed-col').DataTable({
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            }
        });
    });
    TableManageButtons.init();
</script>
@endsection

@section('styles')
<!-- DataTables -->
<link href="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/admin/plugins/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/admin/plugins/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/admin/plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/admin/plugins/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/admin/plugins/datatables/dataTables.colVis.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/admin/plugins/datatables/fixedColumns.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection