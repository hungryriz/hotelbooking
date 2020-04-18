@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-6">
        <h4 class="page-title">User Details</h4>
        <br>
    </div>
</div>
<div class="user-profile row m-0">
    <div class="user-prof-left-col col-md-4 col-sm-12 col-xs-12">
        <div class="card-box text-center">
            <img src="/avatar.png" class="rounded-circle mr-1" width="200">
            <h4 class="user-prof-tit">{{ $User->first_name }} {{ $User->last_name }}</h4>
            <p class="user-prof-txt"><i class="fa fa-envelope-o"></i> {{ $User->email }}</p>
            <p class="user-prof-txt"><i class="fa fa-phone"></i> {{ $User->phone }}</p>
            <div class="iframe-rwd">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d386950.6511603643!2d-73.70231446529533!3d40.738882125234106!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNueva+York!5e0!3m2!1ses-419!2sus!4v1445032011908" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <div class="user-prof-right-col col-md-8 col-sm-12 col-xs-12">
        <div class="user-prof-right">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Address List</b></h4>
                <hr>
                <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($User->addresses as $Index => $Address)
                        <tr>
                            <td>{{ $Index + 1 }}</td>
                            <td>{{ $Address->map_address }}</td>
                            <td>
                                <a href="#" class="btn btn-icon waves-effect btn-default waves-light btn-block">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button class="btn btn-icon waves-effect waves-light btn-danger btn-block" form="resource-delete">
                                    <i class="fa fa-remove"></i>
                                </button>
                                <form id="resource-delete" action="{{ route('admin.users.destroy', $User->id)}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="999">No orders yet!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-box">
                <h4 class="m-t-0 cart-tit"><b>Cart List</b></h4>
                <hr>
                <div class="row">
                    @forelse($User->cart as $Item)
                    <div class="col-lg-6 col-xs-12">
                        <div class="card">
                            <img class="card-img-top img-fluid" src="/avatar.png" alt="Card image cap">
                            <div class="card-block">
                                <h4 class="card-title">{{ $Item->product->parent->name }}</h4>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item b-l-0 b-r-0">Weight : {{ $Item->product->name }}</li>
                                <li class="list-group-item b-l-0 b-r-0">Price : {{ $Item->product->prices->isEmpty() ?  0 : $Item->product->prices[0]->price }}</li>
                            </ul>
                            <a href="#" class="btn btn-icon waves-effect btn-danger btn-block waves-light">Delete</a>
                        </div>
                    </div>
                    @empty
                    <div class="col-xs-12 text-center">
                        <h4>No items in cart!</h4>
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Order History</b></h4>
                <hr>
                <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Address</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($User->orders as $Index => $Order)
                        <tr>
                            <td>{{ $Index + 1 }}</td>
                            <td>{{ $Order->invoice_id }}</td>
                            <td>{{ $Order->address->map_address }}</td>
                            <td>{{ $Order->created_at }}</td>
                            <td>
                                <button class="btn btn-info" onclick="javascript">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr id="order-{{$Order->id}}">
                            <td colspan="9999">
                                <div class="inbox-widget">
                                    @forelse($Order->items as $Index => $Item)
                                    <a href="{{ route('admin.products.show', $Item->id) }}">
                                        <div class="inbox-item">
                                            <div class="inbox-item-img text-center p-t-10">{{ $Index + 1 }}</div>
                                            <div class="inbox-item-img">
                                                <img src="{{ asset($Item->product->images->isEmpty() ? 'avatar.png' : $Item->product->images[0]->url) }}">
                                            </div>
                                            <p class="inbox-item-author">{{ $Item->product->parent->name }}</p>
                                            <p class="inbox-item-author">{{ $Item->product->name }}</p>
                                            <p class="inbox-item-date p-t-5">Qty : {{ $Item->quantity }}</p>
                                        </div>
                                    </a>
                                    @empty
                                    <h4>No Items here, Looks like an invalid order</h4>
                                    @endforelse
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="999">No orders yet!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style type="text/css">
.inven-box{
    -webkit-box-shadow: 0 1px 3px 0 rgba(0,0,0,.2);
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.2);
    -webkit-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
    margin-bottom: 30px;
}

.inven-box:hover,
.inven-box:focus{
    -webkit-box-shadow: 0 4px 20px 0 rgba(168,182,191,.6);
    box-shadow: 0 4px 20px 0 rgba(168,182,191,.6);
    transform: translateY(-5px);
}
</style>
@endsection