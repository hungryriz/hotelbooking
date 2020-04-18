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
                                <h4 class="card-title">Email Templates</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a href="{{ route('admin.emailtemplate.create') }}" class="btn btn-primary add-btn btn-darken-3">Add Email Template</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block card-dashboard table-responsive">
                                    <table class="table table-striped table-bordered file-export">
                                        <thead>
                                            <tr>
                                                <th>S.no</th>
                                                <th>Template Name</th>
                                                <th>Subject</th>
                                                <th>Sender Email</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($EmailTemplates as $key=>$EmailTemplate)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $EmailTemplate->template_name }}</td>
                                                    <td>{{ $EmailTemplate->email_subject }}</td>
                                                    <td>{{ $EmailTemplate->sender_email }}</td>
                                                    <td>
                                                        @if(Setting::get('DEMO_MODE')==1)
                                                        <a  class="table-btn btn btn-icon btn-success" href="{{ route('admin.emailtemplate.edit', $EmailTemplate->id) }}"><i class="fa fa-pencil-square-o"></i></a>
                                                        <button  class="table-btn btn btn-icon btn-danger" form="resource-delete-{{ $EmailTemplate->id }}" ><i class="fa fa-trash-o"></i></button> 
                                                        @endif
                                                        <form id="resource-delete-{{ $EmailTemplate->id }}" action="{{ route('admin.emailtemplate.destroy', $EmailTemplate->id)}}" method="POST">
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