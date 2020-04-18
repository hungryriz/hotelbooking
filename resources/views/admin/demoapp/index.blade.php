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
                                <h4 class="card-title">Demo App</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a href="{{ route('admin.demoapp.create')}}" class="btn btn-primary add-btn btn-darken-3">Add Demo App </a></li>
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
                                                <th>Api Url</th>
                                                <th>Client Id</th>
                                                <th>Client Secret</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($Demoapp as $App)
                                            <tr>
                                                <td>{{$App->id}}</td>
                                                <td>{{$App->pass_code}}</td>
                                                <td>{{$App->base_url}}</td>
                                                <td>{{$App->client_id}}</td>
                                                <td>{{$App->client_secret}}</td>
                                                <td>
                                                @if(env('DEMO_MODE') == "0")
                                                    <a href="{{ route('admin.demoapp.edit', $App->id) }}" class="table-btn btn btn-icon btn-success"><i class="fa fa-pencil-square-o"></i></a>
                                                    @endif
                                                    
                                                </td>
                                            </tr>
                                            @empty
                                                <div class="row">
                                                    <div class="col-xs-12 text-center">
                                                        <h4>No categories in inventory</h4>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- File export table -->
@endsection
