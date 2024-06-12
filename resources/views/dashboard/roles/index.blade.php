@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
<link rel="stylesheet" type="text/css" href="{{asset('assets')}}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">

@section('title') {{ 'roles' }} @endsection
@section('page-title') roles @endsection
@section('body')


<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-head">
                <div class="card-header">
                	<h4 class="card-title">roles</h4>
                    @if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
                	<a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
        			<div class="heading-elements">
                        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm"><i class="ft-plus white"></i> Create New roles</a>
                	</div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                                    <table id="datatable-buttons" class="table table-striped">
                                        <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th width="280px">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $key => $role)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                                                    {{-- @can('roles-edit') --}}
                                                        <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                                    {{-- @endcan --}}
                                                    {{-- @can('roles-delete') --}}
                                                        {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                        {!! Form::close() !!}
                                                    {{-- @endcan --}}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end .table-responsive -->
                            </div> <!-- end .table-rep-plugin-->
                        </div> <!-- end .responsive-table-plugin-->
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        {!! $roles->render() !!}
        @endsection
