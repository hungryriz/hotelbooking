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
                                <h4 class="card-title">Promocodes</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a href="{{ route('admin.promocodes.create') }}" class="btn btn-primary add-btn btn-darken-3">Add Promocode</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <table class="table table-striped table-bordered file-export">
                                        <thead>
                                            <tr>
                                                <th>S.no</th>
                                                <th>Code</th>
                                                <th>Code Type</th>
                                                <th>Discount</th>
                                                <th>Expiration</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Promocodes as $key=>$Promocode)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $Promocode->promo_code }}</td>
                                                    <td>{{ $Promocode->promocode_type }}</td>
                                                    <td>{{ $Promocode->discount }}</td>
                                                    <td>{{ $Promocode->expiration }}</td>
                                                    
                                                    <td>
                                                        {{ $Promocode->status }}
                                                    </td>
                                                    <td>
                                                        @if(Setting::get('DEMO_MODE')==1)
                                                        <a  class="table-btn btn btn-icon btn-success" href="{{ route('admin.promocodes.edit', $Promocode->id) }}"><i class="fa fa-pencil-square-o"></i></a>
                                                        <button  class="table-btn btn btn-icon btn-danger" form="resource-delete-{{ $Promocode->id }}" ><i class="fa fa-trash-o"></i></button> 
                                                        @endif
                                                        <form id="resource-delete-{{ $Promocode->id }}" action="{{ route('admin.promocodes.destroy', $Promocode->id)}}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- File export table -->


                 <!-- Menu List Modal Starts -->
    <div class="modal fade text-xs-left" id="menu-list">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="myModalLabel1">Menu List</h2>
                </div>
                <div class="modal-body">
                    <div class="row m-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            <div class="bg-img order-img" style="background-image: url(../assets/img/product-1.jpg);"></div>
                                        </th>
                                        <td>Burger Bistro</td>
                                        <td>$100</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu List Modal Ends -->
@endsection