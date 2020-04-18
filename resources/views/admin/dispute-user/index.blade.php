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
                <h4 class="card-title">Dispute Manager</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a href="{{ route('admin.dispute-user.create') }}" class="btn btn-primary add-btn btn-darken-3">Add Dispute Manager</a></li>
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
                                <th>Email</th>
                                <th>Contact Deatils</th>
                                <th>Ratings</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Users as $Indx => $User)
                                
                                <tr>
                                    <td>{{$Indx+1}}</td>
                                    <td>{{$User->name}}</td>
                                    <td>
                                    @if(Setting::get('DEMO_MODE')==1)
                                    {{$User->email}}
                                    @else
                                    {{substr($User->email, 0, 1).'****'.substr($User->email, strpos($User->email, "@"))}}
                                    @endif
                                    </td>
                                    <td>{{$User->phone}}</td>
                                    <td class="star">
                                        <input type="hidden" class="rating" readonly value="3"/>
                                    </td>
                                    <td>
                                        @if(Setting::get('DEMO_MODE')==1)
                                            <a href="{{ route('admin.dispute-user.edit', $User->id) }}" class="table-btn btn btn-icon btn-success"><i class="fa fa-pencil-square-o"></i></a>
                                            <button   class="table-btn btn btn-icon btn-danger" form="resource-delete-{{ $User->id }}" ><i class="fa fa-trash-o"></i></button>
                                        @endif
                                        <form id="resource-delete-{{ $User->id }}" action="{{ route('admin.dispute-user.destroy', $User->id)}}" method="POST">
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
@endsection