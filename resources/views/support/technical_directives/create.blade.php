@extends('layouts.main') 

@section('title', 'Add a Technical Directive')
<!-- include summernote css/js-->
<link href="summernote-bs5.css" rel="stylesheet">
<script src="summernote-bs5.js"></script>
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5>New Technical Directive</h5>
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
                                <a href="#">Add a Technical Directive</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body">
                        <form class="forms" method="POST" enctype="multipart/form-data" action="/technical_directives/create">
                        @csrf
                         <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="subject">Subject<span class="text-red">*</span></label>
                                        <input id="subject" type="text" class="form-control" name="subject" value="" placeholder="Enter a subject" >


                                        <div class="help-block with-errors">
                                        @error('subject')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </div>


                                    </div>







                                        <div class="form-group">
                                        <label>{{ __('Instructions')}}</label>
                                        <textarea  id="directive" name="directive"  class="form-control html-editor h-205" rows="50"></textarea>

                                    </div>
                                    <div class="help-block with-errors">
                                        @error('directive')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </div>









                                </div>


                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="models">{{ __('Applicable Model(s)')}} <span class="text-red">*</span></label>
                                        <select name="models[]" id="models" class="form-control select2" multiple="multiple">
                                        @foreach($uii as $result)
                                            <option value = "{{ $result->id }}"  >{{ $result->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>


                                    <div class="help-block with-errors">
                                        @error('models')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </div>



                                    <div class="form-group">
                                        <label for="publish_state">{{ __('Directive state')}} <span class="text-red">*</span></label>
                                        <select name="publish_state" id="publish_state" class="form-group select2">
                                          
                                                <option value="publish" selected>{{ __('Publish')}}</option>
                                                <option value="republish">{{ __('Republish')}}</option>
                                                <option value="draft">{{ __('Draft')}}</option>
                                        </select>
                                    </div>


                                    <div class="help-block with-errors">
                                        @error('publish_state')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </div>







                                     <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>  
                                </div>
                                <div class="col-sm-3">
                              </div>
                            </div>

                        </form>
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




