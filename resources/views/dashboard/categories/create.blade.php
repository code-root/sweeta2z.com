@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
<link rel="stylesheet" type="text/css" href="{{asset('assets')}}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">

@section('title') {{ 'Category' }} @endsection
@section('page-title') Category @endsection
@section('body')

<section class="row">
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="fa fa-plus-circle"></i> Add Category</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" id="store-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label><i class="fa fa-tag"></i> Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fa fa-font"></i> Title</label>
                            <input type="text" id="token" name="token" value="{{ $token_image }}" style="display: none;">
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <button type="submit" class="btn btn-success buttonAnimation" data-animation="flash"><i class="fa fa-check"></i> Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="fa fa-upload"></i> Upload Image</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <!-- إضافة حقل تحميل الصور هنا -->
                        <input type="file" name="image[]" id="image" multiple accept=".jpg, .jpeg, .png, .gif">
                        <input type="text" id="token_image" name="token_image" value="{{ $token_image }}" style="display: none">
                        <br>
                        <button type="submit" class="btn btn-primary">
                            <i class="ft-file"></i>
                            <i class="fa fa-circle-o-notch spinner loder-image"></i> Upload Image
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="fa fa-image"></i> Image</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="card-body">
                        <fieldset class="form-group add-image"></fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('footer')

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="{{asset('assets')}}/app-assets/vendors/js/extensions/sweetalert.min.js"></script>
<script src="{{asset('assets')}}/dashboard/js/app.js"></script>
<script>
    
    $(document).ready(function() {
        $('#uploadForm').submit(function(e) {
            e.preventDefault(); // منع السلوك الافتراضي للزر
            var fileInput = document.getElementById('image');
            if (fileInput.files.length != 0) {
                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData(this);
                formData.append('token_image', '{{ $token_image }}');
                formData.append('table_name', 'categories');
                uplodeImage(formData, "{{ route('image.upload') }}");
            }
        });

        $('#store-form').submit(function(e) {
            e.preventDefault(); // منع السلوك الافتراضي للزر
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData(this);
            formData.append('token', '{{ $token_image }}');
            formData.append('table_name', 'categories');
            var url = "{{ route('categories.store') }}";
            var redirect = "{{ route('categories.index') }}";
            storeForm(formData, url, redirect, 'تم الاضافه بنجاح', 'POST', false)
        });

    })

</script>

@endsection
@endsection
