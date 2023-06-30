@extends('layouts.main') 
@section('title', 'Technical Report')
@section('content')


@push('head')

<link rel="stylesheet" href="{{ asset('css/va/add_vin.css') }}">

@endpush













    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            @if($action=="create")
                                <h1>New Technical Report</h1>
                            @elseif($action=="show")
                                <h1>Technical Report</h1>
                            @elseif($action=="edit")
                                <h1>Edit Technical Report</h1>
                            @endif
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
                                <a href="#">Add a Report</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body">




                        <form class="forms" method="POST" enctype="multipart/form-data" action="{{route("cases.store")}}">
                        @csrf
                         <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="subject">Subject<span class="text-red">*</span></label>
                                        <input id="subject" type="text" class="form-control" name="subject" value="{{old('subject')??$report->subject??'' }}" placeholder="Enter a subject" required="">
                                        <div class="help-block with-errors"></div>


                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ __('Description')}}<span class="text-red">*</span></label>
                                        <textarea name="description" id="description" class="form-control" rows="10" required="">{{old('description')??$report->description??'' }}</textarea>

                                    </div>


 


                                    <div class="form-group">
                                        <label>Photos/Videos</label>
                                        <div class="input-images" data-input-name="photos" data-label="Drag & Drop photos here or click to browse"></div>
                                    </div>

                                </div>
                                <div class="col-sm-3">



                                
                              
                                    <div class="form-group">
                                        <label for="models">{{ __('Model(s)')}} </label>
                                        <select name="models[]" id="models" class="form-control select2" multiple="multiple">
                                        {{-- @foreach($uii as $result)
                                            <option value = "{{ $result->id }}"  >{{ $result->name }}</option>
                                        @endforeach --}}
                                        </select>
                                    </div>
                            
                         








                                    <div class="form-group">
                                        <label for="po">Purchase Order</label>
                                        <input id="po" type="text" class="form-control" name="purchase_order" value="{{old('subject')??$report->po??'' }}" placeholder="Enter Purchase Order">
     

                                    </div>
                                  

<!--
                                    <div class="form-group">

                                       
                                        <div class="border-checkbox-section ml-3">
                                            <div class="border-checkbox-group border-checkbox-group-primary d-block">
                                            <input type="hidden" name="isaclaim" value="0">
                                               <input class="border-checkbox" type="checkbox" id="isaclaim" name="isaclaim" value="1">
                                                <label class="border-checkbox-label" for="isaclaim">Is this a claim request?</label>
                                            </div>
                                 
                                          
                                        </div>


                                        
                                    </div>

-->


                                    <div class="form-group">


                                    <label>Vechicle identity</label>


                <div class="field_wrapper">
                    <div>
                        <input type="text" placeholder="VIN" name="vin_table[]" id="vin1" value=""/>
                        <input type="text" placeholder="Distance(km)" name="distance_table[]" id="distance" value=""/>
                        <a href="javascript:void(0);" class="add_button" title="Add field"><img src="/img/add-icon.png"/></a>
                        <p id="model_desc1"></p>
                    </div>
                </div>










                                    </div>












                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">
                                            @if($action=="create")
                                                Save
                                            @elseif($action=="edit")
                                                Update
                                            @endif
                                        </button>
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


@push('script')
<script src="{{ asset('js/va/vin_input.js') }}"></script>
@endpush





@endsection
