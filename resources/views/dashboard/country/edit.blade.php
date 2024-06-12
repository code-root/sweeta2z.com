@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
<link rel="stylesheet" type="text/css" href="{{asset('assets')}}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">

@section('title') {{ 'Category' }} @endsection
@section('page-title') Category @endsection
@section('body')

<section class="row">
    <div class="col-xl-6 col-lg-12">
        <div class="card" >
          <div class="card-header">
            <h4 class="card-title">Add Category</h4>
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
                <form action="{{ route('country.store') }}" id="store-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label >Name </label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $country->name }}" required>
                    </div>
                    <button type="submit" class="btn btn-success  buttonAnimation" data-animation="flash">submit</button>
                </form>
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

      $(document).ready(function () {

        $('#store-form').submit(function (e) {
             e.preventDefault();
            var formData = new FormData(this);
            var url ="{{ route('country.update' , ['id' => $country->id ]) }}" ;
            var redirect = "{{ route('country.edit', ['id' => $country->id]) }}";
            storeForm(formData, url , redirect , 'تم التعديل بنجاح' ,'POST')
        });

    })


</script>

@endsection
@endsection


