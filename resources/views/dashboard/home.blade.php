@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
@section('title') {{ 'Home' }} @endsection
@section('page-title')
Dashboard
@endsection
@section('body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-3 col-sm-12 border-right-blue-grey border-right-lighten-5">
                            <div class="pb-1">
                                <div class="clearfix mb-1">
                                    <i class="fas fa-th font-large-1 blue-grey float-left mt-1"></i>
                                    <span class="font-large-2 text-bold-300 info float-right">{{ $categoriesCount }}</span>
                                </div>
                                <div class="clearfix">
                                    <span class="text-muted">Categories</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



    </div>
    </div>
</div>


@endsection


