@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
<link rel="stylesheet" type="text/css" href="{{asset('assets')}}/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">

@section('title') {{ 'Users' }} @endsection
@section('page-title') Users @endsection
@section('body')


<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-head">
                <div class="card-header">
                	<h4 class="card-title">Users</h4>
                    @if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
                	<a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
        			<div class="heading-elements">
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"><i class="ft-plus white"></i> Create New User</a>
                	</div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                <table class="table table-center bg-white mb-0">
                    <thead>
                        <tr>
                                   <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                                <tbody>
                                  {{-- @can('user-list') --}}
                                    @foreach ($data as $key => $user)
                                    <tr>
                                      <td>{{ $user->id }}</td>
                                      <td>{{ $user->name }}</td>
                                      <td>{{ $user->email }}</td>
                                      <td>
                                        @if(!empty($user->getRoleNames()))
                                          @foreach($user->getRoleNames() as $v)
                                             <label class="badge badge-success">{{ $v }}</label>
                                          @endforeach
                                        @endif
                                      </td>
                                      <td>
                                         <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                                         <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                          {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                          {!! Form::close() !!}
                                      </td>
                                    </tr>
                                   @endforeach
                                   {{-- @endcan --}}
                    </tbody>
                </table>
            </div>
        </div><!--end col-->
    </div><!--end row-->

</div>

@endsection

