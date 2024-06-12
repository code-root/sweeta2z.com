@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
<link rel="stylesheet" type="text/css" href="{{asset('assets')}}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">

@section('title') {{ 'Edit '.$products->name  }} @endsection
@section('page-title') Edit Products {{ $products->name }}  @endsection
@section('body')

<section class="row">
    <div class="col-xl-6 col-lg-12">
        <div class="card" >
          <div class="card-header">
            <h2>Edit Products {{ $products->name }}</h2>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
          </div>
            <div class="card-content">
              <div class="card-body">
                <div class="container">
                    <form id="store-form" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name"><i class="fa fa-tag"></i> Name:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $products->name }}">
                        </div>
                        <div class="form-group">
                            <label for="title"><i class="fa fa-tag"></i> Title:</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $products->title }}">
                        </div>
                        <div class="form-group">
                            <label for="category"><i class="fa fa-list-alt"></i> Category:</label>
                            <select name="category_id" id="category" class="form-control">
                                <!-- Populate categories dropdown from database -->
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id === $products->category_id) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price"><i class="fa fa-money"></i> Price:</label>
                            <input type="number" name="price" id="price" class="form-control" value="{{ $products->price }}">
                        </div>
                        <div class="form-group">
                            <label for="price_before"><i class="fa fa-money"></i> ranking:</label>
                            <input type="number" name="price_before" id="price_before" class="form-control" value="{{ $products->price_before }}">
                        </div>

                        <div class="form-group">
                            <label for="description"><i class="fa fa-info-circle"></i> Words Title </label>
                            <input name="words_title" id="words_title" class="form-control" value="{{ $products->words_title }}">
                        </div>

                        <div class="form-group">
                            <label for="category"><i class="fa fa-list-alt"></i> Products:</label>
                            <select name="productsList[]" id="products" class="form-control" multiple>
                                <!-- Populate categories dropdown from database -->
                                @foreach($relationship as $item)
                                    <option value="{{ $item->id }}"  @if ($item->rel_id === $products->id) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description"><i class="fa fa-info-circle"></i> word </label>
                            <textarea name="word" id="word" class="form-control" rows="5" >{{ $products->words }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="description"><i class="fa fa-info-circle"></i> Description:</label>
                            <textarea name="description" id="description" class="form-control" rows="5" required  style="direction: rtl;">{{ $products->description }}</textarea>
                        </div>
                        <button type="submit"  class="btn btn-primary store-form">Update Product</button>
                    </form>
                </div>

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
                    <form id="uploadForm-2" enctype="multipart/form-data">
                        <!-- إضافة حقل تحميل الصور هنا -->
                        <input type="file" name="image[]" id="image" multiple accept=".jpg, .jpeg, .png, .gif">
                        <input type="text" id="token_image" name="token_image" value="{{ $token_image ?? ''}}" style="display: none">
                        <br>
                        <button type="submit" class="btn btn-primary">
                            <i class="ft-file"></i>
                            <i class="fa fa-circle-o-notch spinner loder-image" style="display: none;"></i> Upload Image
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-12">
        <div class="card" >
          <div class="card-header">
            <h4 class="card-title">Image</h4>
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
                    <fieldset class="form-group add-image">
                            @isset($products['image'][0])
                            @foreach ( $products['image'] as $item)
                            <label id="img-{{$item->id}}" class="btn"><p><i onclick="deleteImage ({{$item->id}} , '{{  route('image.delete') }}')" style="color: red" class="fa fa-trash" data-id="{{ $item->id }}" ></i> </p>
                            <img src="https://sweeta2z.com/back-end/{{$item['url']}}" class="check img-thumbnail" style="width: 155px;height: 97px;"></label>
                            @endforeach
                            @endisset
                    </fieldset>
                  </div>
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

      $(document).ready(function () {
        $('#uploadForm-2').submit(function (e) {
        e.preventDefault();
    var fileInput = document.getElementById('image');
    if (fileInput.files.length != 0) {
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData(this);
            formData.append('token_image', '{{ $products->token }}');
            formData.append('table_name', 'products');
            uplodeImage (formData , "{{ route('image.upload') }}");
            }
        });

        $('#store-form').submit(function (e) {
             e.preventDefault();
            var formData = {
                'title' : $('#title').val() ,
                'name' : $('#name').val() ,
                'words' : $('#word').val() ,
                'description' : $('#description').val() ,
                'price' : $('#price').val() ,
                'category_id' : $('#category').val() ,
                'price_before' : $('#price_before').val() ,
                'id':  '{{  $products->id }}' ,
                'token':  '{{ $products->token }}' ,
            }
            var jsonData = JSON.stringify(formData);
            var url = "{{ route('products.update', ['id' => $category->id]) }}";
            var redirect = "{{ route('products.edit', ['id' => $category->id]) }}";
            storeForm(jsonData, url , redirect , 'done' ,'PUT')
        });

    })

</script>

@endsection
@endsection



