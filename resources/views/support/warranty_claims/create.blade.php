@extends('layouts.main') 
@section('title', 'New Warranty Claim')
@section('content')
	<div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-settings bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Warranty Claim</h5>
                            <span>Warranty Claim Entry</span>
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
                                <a href="#">Add Warranty Claim</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            <div class="col-md-12">
        </div>            <!-- end message area-->
            <div class="col-md-12">
                <form method="POST" action="">
                    <input type="hidden" name="_token" value="k4JC0rIKsVlV9AR9NCn4JfVS7hvobvmKTZm9pwR6">                    <div class="row">
                        
                        <div class="col-md-4 pr-0">
                            <div class="card mb-0">
                                <div class="card-body">
								

                                    
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-10 pr-0">
                                                <label>Category<span class="text-red">*</span></label>
												<select class="form-control select2" required="" >
                                                	<option selected="selected" value="" data-select2-id="#">Select Category</option>
                                                	<option value="1">Electrical</option>
                                                	<option value="2">Mechanical</option>
													<option value="2">Delivery</option>
                                                </select>
                                            </div>
                                      </div>
                                    </div>



                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-10 pr-0">
                                                <label>Issue<span class="text-red">*</span></label>
												<select class="form-control select2" required="">
                                                	<option selected="selected" value="" data-select2-id="1">Select Issue</option>
                                                	<option value="1">Electrical</option>
                                                	<option value="2">Mechanical</option>
													<option value="2">Delivery</option>
                                                </select>
                                            </div>
                                      </div>
                                    </div>





                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-10 pr-0">
                                                <label>Specify more</label>
												<select class="form-control select2">
                                                	<option selected="selected" value="" data-select2-id="3">Specify more</option>
                                                	<option value="1">12</option>
                                                	<option value="2">11</option>
													<option value="2">11</option>
                                                </select>
                                            </div>
                                      </div>
                                    </div>









                               
                                    <div class="form-group">
                                        <label>Problem description</label>
                                        <textarea class="form-control h-123" name="note" placeholder="Describe the problem"></textarea> 
                                    </div>





                                    <div class="form-group">
                                        <label>Photos</label>
                                        <div class="input-images" data-input-name="issue-images" data-label="Drag & Drop images here or click to browse"></div>
                                    </div>







                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="row">

									<div class="col-sm-4">
											<div class="form-group">
												<label for="vin">VIN<span class="text-red">*</span></label>
												<input id="vin" type="text" class="form-control" name="vin" value="" placeholder="Vehicle Identification Number" required="">
												<div class="help-block with-errors"></div>


											</div>
									</div>

                                        <div class="col-sm-6">

                                            <div class="form-group"> 
											<label for="part">Part to be replaced</label>
												<select name="part" id="part" class="form-control select2" disabled >
	                                             	<option selected="selected" value=""   data-select2-id="9">Select Part</option>
                                                	<option value="1">1</option>
                                                	<option value="2"> 6</option>
                                                	<option value="3"> Bag</option>
                                                	<option value="4">2</option>
                                                	<option value="5">3</option>
                                                	<option value="6">3</option>
                                                	<option value="7"> Watch</option>
                                                	<option value="8">3</option>
                                                	<option value="9">3</option>
                                                </select>
                                            </div>
                                        </div>
										<div class="col-sm-2 pl-1 pt-1">
                                                <button type="button" class="mt-4 btn btn-sm btn-primary" data-toggle="modal" data-target="#">+</button>
                                            </div>



                                    </div>
                                                
                                    <div class="warrantytable">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="wp-30">SKU#</th>
                                                    <th class="wp-60">Part</th>
                                                    <th class="wp-10">Qty</th>
                                                  </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>ES3370263</td>
                                                    <td>E-LEGANCE Stickers</td>
                                                     <td><input type="text" name="shiping" class="form-control w-60 text-center hm-30" value="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>3370261-SP</td>
                                                    <td>Support, windshield big</td>
                                                     <td><input type="text" name="shiping" class="form-control w-60 text-center hm-30" value="1"></td>
                                                </tr>
                                               

                                                <tr>
                                                <td class="border-0" colspan="3"></td>
                                                </tr>


                                                <tr>
                                                <td class="border-0" colspan="3"></td>
                                                </tr>

                                                <tr>
                                                <td class="border-0" colspan="3"></td>
                                                </tr>

                                               
                                                <tr>
                                                <td class="border-0" colspan="3"></td>
                                                </tr>


                                                <tr>
                                                <td class="border-0" colspan="3"></td>
                                                </tr>

                                                <tr>
                                                <td class="border-0" colspan="3"></td>
                                                </tr>









                                                <tr>





                                                    <td class="border-0" colspan="2"></td>
                                                    <td class="border-0">
                                                        <div class="form-group">
                                                            <div type="submit" class="btn btn-primary wp-100">Save</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                        
            </div>

                            
        </div>
    </div>
 

@endsection