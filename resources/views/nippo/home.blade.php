@extends('layouts.main') 
@section('title', 'Nipponia Technical Support')
@section('content')
    <!-- push external head elements to head -->
    @push('head')

        <link rel="stylesheet" href="{{ asset('plugins/weather-icons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/jvectormap/jquery-jvectormap.css') }}">
    @endpush


    {{-- HOME DASHBOARD --}}
    <div class="container-fluid">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-layers bg-primary"></i>
                        <div class="d-inline">
                            <h1>{{ __('Nipponia Technical Support')}}</h1>
                            {{-- <span>{{ __('Nipponia')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Home')}}</a>
                            </li>

                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        
        
          
       
    </div>




        {{-- DASHBOARD WIDGETS --}}
        
        <div class="row">
            <div class="col-sm-12 col-md-5 col-lg-4">
                <div class="widget bg-primary">
                    <div class="widget-body">
                        <a href="{{route('directives.index')}}" class="text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>{{ __('Technical Directives')}}</h6>
                                <h2>{{$directives}}</h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-mail"></i>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>



            {{-- @can('manage_user')  --}}
            {{-- <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget bg-success">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>{{ __('Technical Support Ticket')}}</h6>
                                <h2>3</h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-life-buoy"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-sm-12 col-md-5 col-lg-4">
                <div class="widget bg-secondary">
                    <div class="widget-body">
                        <a href="{{route('cases.index')}}" class="text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>{{ __('Open Cases')}}</h6>
                                <h2>{{$pending_cases}}</h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-file-text"></i>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            
            </div>
            <div class="row">
            
            <div class="col-sm-12 col-md-5 col-lg-4">
                <div class="widget bg-danger">
                    <div class="widget-body">
                        {{-- here --}}
                        <a href="{{route('cases.indexpending')}}" class="text-white">        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>{{ __('Waiting for Nipponia')}}</h6>
                                <h2>{{$waiting_cases}}</h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-file-text"></i>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget bg-danger">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>{{ __('Warranty Claims')}}</h6>
                                <h2>1</h2>
                            </div>
                            <div class="icon">
                                <i class="ik ik-settings"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- @endcan --}}
        </div>



    </div>
              
    <!-- push external js -->
    @push('script')
        <script src="{{ asset('plugins/moment/moment.js') }}"></script>
        <script src="{{ asset('plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <script src="{{ asset('plugins/jvectormap/jquery-jvectormap.min.js') }}"></script>
        <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
       
        {{-- Dim: αυτό το έβγαλα, μπορεί να χρειάζεται --}}
        {{-- <script src="{{ asset('js/widgets.js') }}"></script> --}}
    @endpush
@endsection
