@extends('layouts.main') 
@section('title', $directive->subject)
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    @endpush

    <div class="container-fluid">
    	
    <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <h5>{{$directive->subject}}</h5>
                    </div>
                </div>




                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/technical_directives/list">Technical Directives</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{$directive->subject}}</a>
                            </li>
                        </ol>
                    </nav>
                    </nav>
                </div>
            </div>
        </div>


        <div class="row">
           
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    

               {!! $directive->directive !!}





                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script') 
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/form-components.js') }}"></script>

    @endpush
@endsection
