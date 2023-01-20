@extends('layouts.main') 
@section('title', 'Settings')
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
                        <i class="ik ik-settings bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Settings')}}</h5>
                            <span>{{ __('Update Settings')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('/')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <!-- clean unescaped data is to avoid potential XSS risk -->
                             
                            </li>

                        </ol>
                    </nav>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="forms" method="POST" enctype="multipart/form-data" action="{{ url('app_settings') }}" >
                                 @csrf




  <!-- cc message-->
                        <div class="row">
                                <div class="col-sm-6">
                                    <h5><b>CC email address</b></h5>
                                    <p>{{ __('Email address for all the communication to be carbon copied.')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ccemail">{{ __('Email ')}}</label>
                                        <input id="ccemail" type="text" class="form-control" name="ccemail" value="{{$ccemail}}" >

                                    </div>
                                </div>

                        </div>
  <!-- cc message-->





  <!-- bcc message-->
  <div class="row">
                                <div class="col-sm-6">
                                    <h5><b>BCC email address</b></h5>
                                    <p>{{ __('Email address for all the communication to be blined carbon copied.')}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="bccemail">{{ __('Email ')}}</label>
                                        <input id="bccemail" type="text" class="form-control" name="bccemail" value="{{$bccemail}}" >

                                    </div>
                                </div>

                        </div>
  <!-- bcc message-->














  <!-- update-->
                        <div class="row">
                        <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary form-control-right">{{ __('Update')}}</button>
                                    </div>
                                </div>

                         </div>
  <!-- update-->
                      
                        
                    </form>
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
