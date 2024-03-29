@extends('layouts.main')
@section('title', 'Permission')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    @endpush


    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-unlock bg-blue"></i>
                        <div class="d-inline">
                            <h1>{{ __('Permissions')}}</h1>
                            <p class="lead">{{ __('Define the permissions of the roles')}}</p>
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
                                <a href="#">{{ __('Permissions')}}</a>
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
                    <div class="card-body">
                        <table id="permission_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Permission')}}</th>
                                    <th>{{ __('Assigned Role')}}</th>
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

        <!-- only those have manage_permission permission will get access -->
        @can('manage_permission')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>{{ __('Add Permission')}}</h3></div>
                <div class="card-body">
                    <form class="forms-sample" method="POST" action="{{url('permission/create')}}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="permission">{{ __('New Permission Name')}}<span class="text-red">*</span></label>
                                    <input type="text" class="form-control" id="permission" name="name" placeholder="Permission Name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail3">{{ __('Assigned to Role')}} </label>
                                    {!! Form::select('roles[]', $roles, null,[ 'class'=>'form-control select2', 'multiple' => 'multiple']) !!}
                                </div>
                            </div>

                                <div class="col-sm-2 form-group center-contents pt-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>

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
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/DataTables/Cell-edit/dataTables.cellEdit.js') }}"></script>
    <!--server side permission table script-->
    <script src="{{ asset('js/permission.js') }}"></script>
    @endpush
@endsection
