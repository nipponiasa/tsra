@extends('layouts.main')
@section('title', 'Roles')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    @endpush


    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-award bg-primary"></i>
                        <div class="d-inline">
                            <h1>{{ __('Roles')}}</h1>
                            <p class="lead">{{ __('Define the roles of the users')}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="../index.html"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Roles')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>


    <!-- start message area-->
    @include('include.message')
    <!-- end message area-->
    

		<div class="row">
	        <div class="col-md-12">
	            <div class="card p-3">
	                <div class="card-header"><h3>{{ __('Roles')}}</h3></div>
	                <div class="card-body">
	                    <table id="roles_table" class="table">
	                        <thead>
	                            <tr>
	                                <th>{{ __('Role')}}</th>
	                                <th>{{ __('Permissions')}}</th>
	                                <th>{{ __('Action')}}</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
	    </div>
    </div>




    <div class="row clearfix">

        <!-- only those have manage_role permission will get access -->
        @can('manage_role')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>{{ __('Add Role')}}</h3></div>
                <div class="card-body">
                    <form class="forms-sample" method="POST" action="{{url('role/create')}}">
                        @csrf
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="role">{{ __('New Role Name')}} <span class="text-red">*</span></label>
                                <input type="text" class="form-control is-valid" id="role" name="name" placeholder="Role Name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="">
                                <label for="exampleInputEmail3">{{ __('Assign Permission')}} </label>
                                <div class="row">
                                    @foreach($permissions as $key => $permission)
                                    <div class="col-sm-6">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="item_checkbox" name="permissions[]" value="{{$key}}">
                                            <span class="custom-control-label">
                                                <!-- clean unescaped data is to avoid potential XSS risk -->
                                                {{ clean($permission,'titles')}}
                                            </span>
                                        </label>

                                    </div>
                                    @endforeach
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary my-3">{{ __('Save')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endcan
    </div>




    <!-- push external js -->
    @push('script')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--server side roles table script-->
    <script src="{{ asset('js/custom.js') }}"></script>
	@endpush
@endsection
