@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
<link rel="stylesheet" type="text/css" href="{{asset('assets')}}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">

@section('title') {{ 'country' }} @endsection
@section('page-title') country create @endsection
@section('body')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">Add country</h4>
                            <form action="{{ route('areas.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">الاسم</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="name_en">الاسم بالإنجليزية</label>
                                    <input type="text" id="name_en" name="name_en" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="country_id">البلد</label>
                                    <select id="country_id" name="country_id" class="form-control">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> حفظ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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


