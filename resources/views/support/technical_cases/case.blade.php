@extends('layouts.main') 
@section('title', 'Technical Case')
@section('content')


@push('head')

<link rel="stylesheet" href="{{ asset('css/va/add_vin.css') }}">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@endpush













    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            @if($action=="create")
                                <h1>New Technical Case</h1>
                            @elseif($action=="show")
                                <h1>Technical Case</h1>
                            @elseif($action=="edit")
                                <h1>Edit Technical Case</h1>
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
                                <a href="#">Cases</a>
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

                        


                        <form class="forms" method="POST" enctype="multipart/form-data" action="{{ ($action=='edit') ? route("cases.update",$case->id) : route("cases.create") }}">
                        @csrf
                        @if($action=="edit")
                            @method('PUT')
                        @endif
                         <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="subject">Subject <span class="text-danger">*</span></label>
                                        <input id="subject" type="text" class="form-control" name="subject" value="{{old('subject')??$case->subject??'' }}" placeholder="Enter a subject" required>
                                        <div class="help-block with-errors">
                                            @error('subject')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label for="description">{{ __('Description')}} <span class="text-danger">*</span> </label>
                                        <textarea name="description" id="description" class="form-control" rows="10" required>{{old('description')??$case->description??'' }}</textarea>
                                        <div class="help-block with-errors">
                                            @error('description')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


 


                                    <div class="form-group">
                                        <label>Photos/Videos</label>
                                        <div class="input-images" data-input-name="photos" data-label="Drag & Drop photos here or click to browse"></div>
                                    </div>

                                </div>
                                <div class="col-sm-6">

                                    

                                    <div class="form-group">
                                        <label for="model">{{ __('Model')}} <span class="text-danger">*</span> <i class="fa fa-info-circle text-primary" data-toggle="tooltip" aria-hidden="true" title="Use no spaces between the model's name and displacement (For example, BRIO110) "> </i></label>
                                        <input id="model" type="text" class="form-control" name="model" value="{{old('model')??$case->model??'' }}" placeholder="" required>
                                        </select>
                                    </div>
                              
                                    {{-- old code for multiple select --}}
                                    {{-- <div class="form-group">
                                        <label for="models">{{ __('Model(s)')}} </label>
                                        <select name="models[]" id="models" class="form-control select2" multiple="multiple">
                                        @foreach($uii as $result)
                                            <option value = "{{ $result->id }}"  >{{ $result->name }}</option>
                                        @endforeach
                                        </select>
                                    </div> --}}
                            
                         
                                    {{-- VINS Section --}}
                                    <div class="" x-data="{ 
                                        vins: [] , 
                                        showvin: vin=>vin[0]+' - '+vin[1]+'km',
                                    }">      

                                
                                        <div class="form-group" >

                                            <label>Vechicle Identities</label>
                                            <div class="input-group">
                                                    {{-- <div class=""> --}}
                                                        <input id="newVIN" type="text" min="0" class="form-control" placeholder="VIN" @keydown.enter.prevent="addVIN.click()">
                                                        {{-- <label for="newVIN">VIN</label> --}}
                                                    {{-- </div> --}}
                                                    {{-- <div class=""> --}}
                                                        <input id="newKM" type="number" min="0" step="1" class="form-control" placeholder="Distance (km)" @keydown.enter.prevent="addVIN.click()">
                                                        {{-- <label for="newKM">Distance (km)</label> --}}
                                                    {{-- </div> --}}
                                                    <button class="btn btn-secondary" type="button" id="addVIN" 
                                                    @click="
                                                        if (newVIN.value.length>0) {vins.push([newVIN.value,newKM.value||0])};
                                                        newVIN.value='';newKM.value=''
                                                    ">
                                                        Add VIN
                                                    </button>

                                                    {{-- <input type="text" placeholder="VIN" name="vin_table[]" id="vin1" value=""/> --}}
                                                    {{-- <input type="text" placeholder="Distance(km)" name="distance_table[]" id="distance" value=""/> --}}
                                                    {{-- <a href="javascript:void(0);" class="add_button" title="Add field"><img src="/img/add-icon.png"/></a> --}}
                                                    {{-- <p id="model_desc1"></p> --}}
                                            </div>
                                            <div class="form-group my-1">
                                                <select name="VIN[]" id="VIN" class="form-control select2" multiple="multiple" size="1">
                                                    <template x-for="vin in vins">
                                                        <option :value="vin.toString()" x-text="showvin(vin)" selected></option>
                                                    </template>
                                                    {{-- @foreach ($countries as $country_id => $country_name)
                                                        <option value="{{$country_id}}"   {{ ( collect(old('countries'))->contains($country_id) || (isset($directive)&&$directive->motorCountries->pluck('id')->contains($country_id)) ) ? 'selected':'' }}     >{{$country_name}}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
        
                                        </div>


                                    
                                    </div>


                                    <div class="form-group">
                                        <label for="purchase_order">Purchase Order</label>
                                        <input id="purchase_order" type="text" class="form-control" name="purchase_order" value="{{old('purchase_order')??$case->purchase_order??'' }}" placeholder="Enter Purchase Order">
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















                                    <div class="form-group text-right my-5">
                                        <button type="submit" class="btn btn-primary">
                                            @if($action=="create")
                                                Submit Case
                                            @elseif($action=="edit")
                                                Update Case
                                            @endif
                                        </button>
                                    </div>  


                                </div>
                                <div class="col-sm-6">

                             
                               
                                  
                                </div>
                            </div>

                        </form>



                    </div>
                </div>
            </div>
        </div>
    </div>


{{-- @push('script')
<script src="{{ asset('js/va/vin_input.js') }}"></script>
@endpush --}}





@endsection
