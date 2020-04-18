@extends('admin.layouts.app')

@section('content')
 <div class="card">
    <div class="card-header">
        @if(Setting::get('DEMO_MODE')==0)
        <div class="col-md-12" style="height:50px;color:red;">
            ** Demo Mode : No Permission to Edit and Delete.
        </div>
        @endif
        <h4 class="card-title">Notice Board</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-body collapse in">
        <div class="card-block card-dashboard table-responsive">
            <table class="table table-striped table-bordered file-export">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Delivery Boy Name</th>
                        <th>Notice</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($NoticeList as $Index => $Notice)
                    <?php //print"<pre>";print_r($Order); exit;?>
                    <tr>
                        <td>{{ $Index + 1 }}</td>
                        <td>{{ @$Notice->transporter->name }}</td>
                        <td>
                            {!! @$Notice->notice !!}
                        </td>
                        <td>{{ @$Notice->created_at }}</td>
                        <td>
                            @if(Setting::get('DEMO_MODE')==1)
                             <a href="{{ route('admin.notice.edit', $Notice->id) }}" class="table-btn btn btn-icon btn-success"><i class="fa fa-pencil-square-o"></i></a>
                            <!-- <button  class="table-btn btn  btn-danger" onclick="return confirm('Do You want To Remove This Notice?');" form="resource-delete-{{ $Notice->id }}" >Remove</button> -->
                            @endif
                            <form id="resource-delete-{{ $Notice->id }}" action="{{ route('admin.notice.destroy',$Notice->id)}}" method="POST">
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
@endsection