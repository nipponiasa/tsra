@extends('layouts.main') 

@section('title', 'Technical Directive')
<!-- include summernote css/js  Dim: Τα έβγαλα, μπορεί να χρειάζονται-->
{{-- <link href="summernote-bs5.css" rel="stylesheet"> --}}
{{-- <script src="summernote-bs5.js"></script> --}}
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            @if($action=="create")
                                <h5>New Technical Directive</h5>
                            @elseif($action=="show")
                                <h5>Technical Directive</h5>
                            @elseif($action=="edit")
                                <h5>Edit Technical Directive</h5>
                            @endif
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/technical_directives">Technical Directives</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @php
                            $form_action = ($action=="edit") ? "/technical_directives/$directive->id" : "/technical_directives";
                        @endphp
                        <form class="forms" method="POST" enctype="multipart/form-data" action="{{$form_action}}">
                        @csrf
                        @if($action=="edit")
                            @method('PUT')
                        @endif
                         <div class="row">
                                <div class="col-sm-6">
                                    

                                    {{-- ID hidden --}}
                                    @if($action=="edit")
                                        <input type="hidden" name="id" value="{{$directive->id}}">
                                    @endif

                                    {{-- Subject --}}
                                    <div class="form-group">
                                        <label for="subject">Subject <span class="text-red">*</span></label>
                                        <input id="subject" type="text" class="form-control" name="subject" value="{{old('subject')??$directive->subject??'' }}" placeholder="Enter a subject" >

                                        <div class="help-block with-errors">
                                            @error('subject')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>






                                        {{-- Notes --}}
                                        <div class="form-group">
                                            <label>{{ __('Notes')}}</label>
                                            <textarea  id="notes" name="notes" class="form-control h-205" rows="3">{{old('notes')??$directive->notes??''}}</textarea>
                                        </div>
                                        <div class="help-block with-errors">
                                            @error('notes')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Directive File --}}
                                        <label>File</label>
                                        @if( in_array($action, ["edit","show"]) && $directive->filename)
                                        <div>
                                            <a class="btn btn-primary text-white mb-1" href="{{$directive->filepath()}}">Download Directive File</a>
                                        </div>
                                        @endif
                                        <div class="custom-file">
                                            <input name="directivefile" type="file" accept="application/pdf" class="" id="directivefile">
                                            <label class="custom-file-label" for="directivefile" id="filename"> {{(isset($directive)&&$directive->filename) ? 'Replace File' : 'Upload File' }} </label>
                                            <script>
                                                document.getElementById("directivefile").onchange = function() {
                                                    document.getElementById("filename").innerText = this.files[0].name;
                                                };
                                            </script>
                                        </div>
                                        <div><p>File type: pdf, maximum size: 5MB</p></div>
                                        <div class="help-block with-errors">
                                            @error('directivefile')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                </div>


                                <div class="col-sm-6">

                                    {{-- Applicable Models --}}
                                    <div class="form-group">
                                        <label for="models">{{ __('Applicable Models')}} <span class="text-red">*</span></label>
                                        <select name="models[]" id="models" class="form-control select2" multiple="multiple">
                                        @foreach($models as $model)
                                            <option value = "{{ $model->id }}"   {{ ( collect(old('models'))->contains($model->id) || (isset($directive)&&$directive->motorModels->pluck('id')->contains($model->id)) ) ? 'selected':'' }}   >{{ $model->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="help-block with-errors">
                                        @error('models')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    {{-- Applicable Countries --}}
                                    @php
                                        $countries = array(
                                            '3' => 'HQ',
                                            '1' => 'RD',
                                            '4' => 'GE',
                                            '7' => 'BE',
                                        );
                                    @endphp
                                    <div class="form-group">
                                        <label for="countries">{{ __('Applicable Countries')}}</label>
                                        <select name="countries[]" id="countries" class="form-control select2" multiple="multiple">
                                            @foreach ($countries as $country_id => $country_name)
                                                <option value="{{$country_id}}"   {{ ( collect(old('countries'))->contains($country_id) || (isset($directive)&&$directive->motorCountries->pluck('id')->contains($country_id)) ) ? 'selected':'' }}     >{{$country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="help-block with-errors">
                                        @error('countries')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    @php
                                        $statuses = array(
                                            'draft' => 'draft',
                                            'publish' => 'publish',
                                            'republish' => 'republish',
                                        );
                                    @endphp
                                    <div class="form-group">
                                        <label for="state">{{ __('Directive state')}} <span class="text-red">*</span></label>
                                        <select name="state" id="state" class="form-group select2">
                                            @foreach ($statuses as $status_id => $status_name)
                                                <option value="{{$status_id}}"    {{ ( collect(old('status'))->contains($status_id) || (isset($directive)&&$directive->state==$status_id) ) ? 'selected':'' }}   >{{ $status_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="help-block with-errors">
                                        @error('publish_state')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>






                                    @if($action=="create")
                                        <div class="form-group text-right m-5">
                                            <button type="submit" class="btn btn-primary">Create</button>
                                        </div>
                                    @elseif($action=="edit")
                                        <div class="form-group text-right my-5">
                                            <button type="submit" class="btn btn-success m-2">Update</button>
                                            {{-- <button type="button" class="btn btn-danger m-2" id="deleteThis">Delete</button> --}}
                                        </div>
                                    @endif

                                </div>
                            </div>

                        </form>
                        @if($action=="edit")
                            <form action="/technical_directives/{{$directive->id}}" class="m-2" method="post" onsubmit="return confirm('Do you really want to delete this directive?');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{$directive->id}}">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-danger" onclick="">Delete</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript">


$(document).ready(function() {
  $('#directive').summernote(
{

  
        minHeight: 500,             
           
        focus: true







}


  );
});

    
  </script>


@endsection




