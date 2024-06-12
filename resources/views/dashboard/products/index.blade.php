@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
<link rel="stylesheet" type="text/css" href="{{asset('assets')}}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">

@section('title') {{ 'Products' }} @endsection
@section('page-title') Products @endsection
@section('body')



<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <table id="invoices-list" class="table table-white-space table-bordered display no-wrap icheck table-middle">
                        <thead>
                            <tr>
                                <th>name</th>
                                <th>title</th>
                                <th>ranking</th>
                                <th>image</th>
                                <th>category</th>
                                <th>price</th>
                                <th>description</th>
                                <th>updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- PAID -->
                            @isset($data)
                            @foreach ($data as $item )
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->price_before }}</td>
                            <td>@isset($item['image'][0]['url'])<img src="https://sweeta2z.com/back-end/{{ $item['image'][0]['url'] }}" alt="{{ $item->name_ar }}" class="img-thumbnail" width="50">@endisset </td>
                                <td>{{ $item['category']['name'] ?? 'NA' }}</td>
                                <td>
                                    {{ $item->price }}
                                    {{-- @if ($item->price_before > 0 ) --}}
                                    <br>
                                    {{-- <span> before {{ $item->price_before }}</span> --}}
                                    {{-- @endif --}}
                                </td>
                                <td>{{ substr($item->description, 0, 25) }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>
                                    <span class="dropdown">
                                        <button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-primary dropdown-toggle dropdown-menu-right"><i class="ft-settings"></i></button>
                                        <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                           <a href="{{ route('products.edit', $item->id) }}" class="dropdown-item"><i class="fa fa-pencil"></i> Edit Products</a>
                                             <a href="#" class="dropdown-item delete-Products"><i class="fa fa-trash" data-id="{{ $item->id }}"></i> Delete</a>
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

{{-- Modal for ourTeam deletion confirmation --}}
<div class="modal fade" id="deleteourTeamModal" tabindex="-1" role="dialog" aria-labelledby="deleteourTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteourTeamModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this ourTeam?
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
    // JavaScript code for handling ourTeam deletion with AJAX
    $(document).ready(function() {
        $('.delete-ourTeam').click(function() {
            var ourTeamId = $(this).data('id');
            $('#deleteourTeamModal').modal('show');

            $('#confirmDelete').click(function() {
                $.ajax({
                    type: 'DELETE'
                    , url: '/admin/ourTeam/' + ourTeamId
                    , data: {
                        '_token': '{{ csrf_token() }}'
                    , }
                    , success: function(data) {
                        // Reload the page or update the table as needed
                        location.reload();
                    }
                });
            });
        });
    });

</script>
@endsection
