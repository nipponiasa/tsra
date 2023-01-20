@extends('layouts.main') 
@section('title', 'Ask for Support')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-life-buoy bg-blue"></i>
                        <div class="d-inline">
                            <h5>Ask for Support</h5>
                            <span>Create Support Ticket</span>
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
                                <a href="#">Create Support Ticket</a>
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
                        <form class="forms-sample" method="POST" action="#">
                        <input type="hidden" name="_token" value="R7Ddbbgxb1qEbQoTDakkow75fNl3gqY3q3qkjl94">                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="subject">Subject<span class="text-red">*</span></label>
                                        <input id="subject" type="text" class="form-control" name="subject" value="" placeholder="Enter subject" required="">
                                        <div class="help-block with-errors"></div>


                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control html-editor h-205" rows="10"></textarea>

                                    </div>

                                    <div class="form-group">
                                        <label>Product Photos</label>
                                        <div class="input-images" data-input-name="product-images" data-label="Drag & Drop product photos here or click to browse"></div>
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Model<span class="text-red">*</span></label>
                                        <select class="form-control" name="warehouse" >
                                            <option selected="selected" value="" >Select Model</option>
                                            <option value="1">E-Legance</option>
                                            <option value="2">E-Rex</option>
                                        </select>
                                    </div>




                                    <div class="form-group">
                                        <label for="vin">VIN<span class="text-red">*</span></label>
                                        <input id="vin" type="text" class="form-control" name="vin" value="" placeholder="Enter VIN" required="">
                                        <div class="help-block with-errors"></div>
                                    </div>


                                   
                                  
                                    


                                </div>
                                <div class="col-sm-3">

                                    <div class="form-group">

                                        <label>Possible cause of problem</label>
                                        <div class="border-checkbox-section ml-3">
                                            <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                <input class="border-checkbox" type="checkbox" id="checkbox1" value="1">
                                                <label class="border-checkbox-label" for="checkbox1">Battery</label>
                                            </div>
                                            <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                <input class="border-checkbox" type="checkbox" id="checkbox2" value="2">
                                                <label class="border-checkbox-label" for="checkbox2">Electronics</label>
                                            </div>
                                            <div class="border-checkbox-group border-checkbox-group-success d-block">
                                                <input class="border-checkbox" type="checkbox" id="checkbox3" value="3">
                                                <label class="border-checkbox-label" for="checkbox3">Broken Parts</label>
                                            </div>
                                           
                                          
                                        </div>
                                    </div>
                                   
                             
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
