@extends('admin.layouts.app')

@section('content')
 <div class="card">
    <div class="card-header">
    @if(Setting::get('DEMO_MODE')==0)
        <div class="col-md-12" style="height:50px;color:red;">
            ** Demo Mode : No Permission to Edit and Delete.
        </div>
    @endif
        <h4 class="card-title">@lang('dispute.index.title')</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                <li><a href="{{ route('admin.disputehelp.create') }}" class="btn btn-primary add-btn btn-darken-3">@lang('dispute.index.add_message')</a></li>
            </ul>
        </div>
    </div>
    <div class="card-body collapse in">
        <div class="card-block card-dashboard table-responsive">
            <table class="table table-striped table-bordered file-export">
                <thead>
                    <tr>
                        <th>@lang('dispute.index.sl_no')</th>
                        <th>@lang('dispute.index.message')</th>
                        <th>@lang('dispute.index.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($Disputehelp as $Index => $Help)
                    <?php //print"<pre>";print_r($Order); exit;?>
                    <tr>
                        <td>{{ $Help->id }}</td>
                        <td>{{ @$Help->name }}</td>
                        <td>
                            @if(Setting::get('DEMO_MODE')==1)
                             <a href="{{ route('admin.disputehelp.edit', $Help->id) }}" class="table-btn btn btn-icon btn-success"><i class="fa fa-pencil-square-o"></i></a>
                             @endif
                            <!-- <button  class="table-btn btn  btn-danger" onclick="return confirm('Do You want To Remove This Dispute?');" form="resource-delete-{{ $Help->id }}" >Remove</button> -->
                                        <form id="resource-delete-{{ $Help->id }}" action="{{ route('admin.disputehelp.destroy',$Help->id)}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5"> @lang('dispute.index.no_record_found')</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection