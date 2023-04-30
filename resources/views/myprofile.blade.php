@extends('layouts.main') 
@section('title', $user->name)
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
                        <i class="ik ik-user-plus bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit My Profile')}}</h5>
                            <span>{{ __('Update Profile Details')}}</span>
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
                                {{ clean($user->name, 'titles')}}
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



                        <form class="forms" method="POST" enctype="multipart/form-data" action="{{ url('myprofile/update') }}" >
                            @csrf
                            <input type="hidden" name="id" value="{{$user->id}}">

                            <div class="row">
                                <div class="col-sm-6">

                                    
                                    <div class="form-group">
                                        <label for="name">{{ __('Username')}}<span class="text-red">*</span></label>
                                        <input id="name" type="text" disabled class="form-control @error('name') is-invalid @enderror" name="name" value="{{ clean($user->name, 'titles')}}" required>
                                        <div class="help-block with-errors"></div>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    
                                    <div class="form-group">
                                        <label for="email">{{ __('Email')}}<span class="text-red">*</span></label>
                                        <input id="email" type="email" disabled class="form-control @error('email') is-invalid @enderror" name="email" value="{{ clean($user->email, 'titles')}}" required>
                                        <div class="help-block with-errors"></div>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                   
                                    <div class="form-group">
                                        <label for="password">{{ __('Reset Password')}}</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  >
                                        <div class="help-block with-errors"></div>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    {{-- Photo upload --}}
                                    <div class="form-group">
                                        <label for="avatar">{{ __('User Photo (.jpg format, 512px square preferred)')}}</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="avatar" name="avatar" accept=".jpg">
                                            <label class="custom-file-label" for="avatar">Choose file</label>
                                        </div>
                                        {{-- Για κάποιο λόγο δεν δείχνει ότι επιλέχθηκε εικόνα, οπότε βάζω αυτό: --}}
                                        <script>
                                            $('.custom-file-input').on('change', function() { 
                                                let fileName = $(this).val().split('\\').pop(); 
                                                $(this).next('.custom-file-label').addClass("selected").html(fileName); 
                                            });
                                        </script>
                                        {{--
                                        <label for="avatar">{{ __('Photo upload (512px square preferred)')}}</label>
                                        <div class="">
                                            <input type="file" class="" id="avatar">
                                            <label class="custom-file-label" for="avatar">Choose file</label>
                                          </div> --}}
                                        {{-- <input type="file" id="avatar" name="avatar"  class="form-control"> --}}
                                        {{-- <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" placeholder="Upload Image">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary" type="button">{{ __('Upload')}}</button>
                                            </span>
                                        </div> --}}
                                    </div>




                                    <div class="form-group">
                                        <label for="locale">{{ __('Language Preferences')}} <span class="text-red">*</span></label>
                                        <select name="locale" id="locale" class="form-control select2">
                                            @foreach(App\Models\User::LOCALES as $locale => $label)
                                                <option value="{{ $locale }}" {{ $user->locale != $locale ?: 'selected' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>









            
                                
                                </div>


         <div class="col-lg-1 col-md-1">
                
            </div>





             <div class="col-lg-3 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center"> 
                            <img src="{{auth()->user()->avatarURL()}}" class="" width="150" />
                            <h4 class="card-title mt-10">{{ clean($user->name, 'titles')}}</h4>

                        </div>
                    </div>
                </div>
            </div>





                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary form-control-right">{{ __('Update')}}</button>
                                    </div>
                                </div>
                            </div>



                    
                        
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
