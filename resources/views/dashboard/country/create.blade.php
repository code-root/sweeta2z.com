@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
<link rel="stylesheet" type="text/css" href="{{asset('assets')}}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">

@section('title') {{ 'country' }} @endsection
@section('page-title') country create @endsection
@section('body')

<section class="row">
    <div class="col-xl-6 col-lg-12">
        <div class="card" >
          <div class="card-header">
            <h4 class="card-title">Add country</h4>
            </div>
          </div>
            <div class="card-content">
              <div class="card-body">
                <form action="{{ route('country.store') }}" id="store-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label >Name </label>
                        <input type="text" class="form-control" id="name" name="name"  required>
                    </div>

                    <div class="form-group">
                        <label >currency </label>
                        <input type="text" class="form-control" id="currency" name="currency"  required>
                    </div>


                    <div class="form-group">
                        <label>flag</label>
                        <input type="text" class="form-control" id="flag" name="flag"  value="0" required>
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
            var url ="{{ route('country.store') }}" ;
            var redirect = "{{ route('country.index') }}";
            storeForm(formData, url , redirect , 'تم الاضافه بنجاح' ,'POST' ,false)
        });

    })


</script>

@endsection
@endsection


