
@extends('dashboard.layouts.footer')

@extends('dashboard.layouts.navbar')
@section('title') {{ 'Home' }} @endsection
@section('page-title')
{{-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> --}}
<li class="breadcrumb-item ">Dashboard</li>
<li class="breadcrumb-item ">Rools</li>
<li class="breadcrumb-item active">edit</li>
@endsection

@section('body')

<style>
    * {
        font-weight: bold;
    }
</style>


<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2> Show Role</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                </div>
            </div>
        </div>
        
        @if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $role->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Permissions:</strong>
                    @if(!empty($rolePermissions))
                        @foreach($rolePermissions as $v)
                            <label class="label label-success">{{ $v->name }},</label>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        @endsection
