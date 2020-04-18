@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-6">
        <h4 class="page-title">{{ $Category->name }}</h4>
        <br>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="row">
                @forelse($Category->subcategories as $SubCategory)
                <div class="col-xl-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="{{ asset($SubCategory->images->isEmpty() ? 'avatar.png' : $SubCategory->images[0]->url) }}">
                        <div class="card-block">
                            <h4 class="card-title">{{ $SubCategory->name }}</h4>
                            <p class="cart-text">{{ $SubCategory->description }}</p>

                            <div class="row">
                                <div class="col-xs-6">
                                    <a href="#" class="btn waves-effect btn-primary btn-block waves-light">View</a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="#" class="btn waves-effect btn-danger btn-block waves-light">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-xs-12 text-center">
                    <h4>No subcategories for this category!</h4>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    // Table accordian
    $('.collapse').on('show.bs.collapse', function () {
        $('.collapse.in').collapse('hide');
        var pElement = $('[data-target="#' + $(this).attr('id') + '"]');
        pElement.find('span.glyphicon.glyphicon-menu-down').removeClass("glyphicon glyphicon-menu-down").addClass("glyphicon glyphicon-menu-up");
        
    });

    $('.collapse').on('hide.bs.collapse', function () {
        var pElement = $('[data-target="#' + $(this).attr('id') + '"]');
        pElement.find('span.glyphicon.glyphicon-menu-up').removeClass("glyphicon glyphicon-menu-up").addClass("glyphicon glyphicon-menu-down");
        
    });
</script>
@endsection