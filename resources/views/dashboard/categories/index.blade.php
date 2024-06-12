@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
<link rel="stylesheet" type="text/css" href="{{asset('assets')}}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">

@section('title') {{ 'Category' }} @endsection
@section('page-title') Category @endsection
@section('body')


<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                            {{-- <div class="table-responsive"> --}}
                  <table id="invoices-list" class="table table-white-space table-bordered display no-wrap icheck table-middle">
                                <thead>
                                    <tr>
                                        <th>name</th>
                                        <th>title</th>
                                        <th>image</th>
                                        <th>updated at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- PAID -->
                                    @isset($category)
                                    @foreach ($category as $item )
                            <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->title }}</td>
                            <td>@isset($item['image'][0]['url'])<img src="/{{ $item['image'][0]['url'] }}" alt="{{ $item->name_ar }}" class="img-thumbnail" width="50">@endisset </td>
                            <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <span class="dropdown">
                                                <button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="true" class="btn btn-primary dropdown-toggle dropdown-menu-right"><i
                                                        class="ft-settings"></i></button>
                                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                                    @can('edit_categories') <a href="{{ route('categories.edit', $item->id) }}" class="dropdown-item"><i class="fa fa-pencil"></i> Edit category</a> @endcan
                                                    @can('delete_categories') <a href="#" class="dropdown-item delete-category"><i class="fa fa-trash" data-id="{{ $item->id }}" ></i> Delete</a> @endcan
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endisset
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                            </div>

                            <!--/ Invoices table -->
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </section>

    {{-- Modal for category deletion confirmation --}}
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>



    </div>
    </div>
</div>

<script>
    // JavaScript code for handling category deletion with AJAX
    $(document).ready(function() {
        $('.delete-category').click(function() {
            var categoryId = $(this).data('id');
            $('#deleteCategoryModal').modal('show');

            $('#confirmDelete').click(function() {
                $.ajax({
                    type: 'DELETE',
                    url: '/admin/categories/' + categoryId,
                    data: {
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        // Reload the page or update the table as needed
                        location.reload();
                    }
                });
            });
        });
    });
</script>
@endsection


