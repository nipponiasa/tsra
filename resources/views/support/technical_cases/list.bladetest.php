@extends('layouts.main') 
@section('title', 'Technical Reports')
@section('content')

@push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    @endpush


 <!-- view modal -->
 <script>
        function getcasetechidview(name) {
                            $.get('reportt_view_form_modal?reportt='+name, function (data) {
                                        $('#caseView').on('shown.bs.modal', function () {
                                                            $('#caseViewLabel').text(data.data.subject);
                                                            $('#wholejson').text(JSON.stringify(data));
                                                            $('#description').html(data.data.description);
                                                            $('#idhtml').html(printimages(data.files));
															$('#idhtml2').html(printmodels(data.related_models));
															console.log(JSON.stringify(data.related_models));
                                        })
                            })
         	 
		 
		 
		 }



		 function printimages(obj) {
						let imagetagpre = '<img id="image" class="img-thumbnail" src="{{ url('/storage/') }}/';
						let str='';
						for(var k in obj) {
								str =str +imagetagpre+ obj[k] + '">';
								}
			return str;};


						function printmodels(arr) {
						let textpre = '<h1>';
						let str='';
						for (let element of arr) { 
							str =str +textpre+ element['name'] + '</h1>';
}
						return str;};




</script>
 <!-- view modal -->

 


















	<div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-green"></i>
                        <div class="d-inline">
                            <h5>Technical Reports</h5>
                            <span>View, delete and update Technical Reports</span>
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
                                <a href="#">Technical Reports</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- list layout 1 start -->
            <div class="col-md-12">
				<div class="card">
		            <div class="card-header row">
		                <div class="col col-sm-1">

		                    
		                </div>
		                <div class="col col-sm-6">
		                    <div class="card-search with-adv-search dropdown">
		                        <form action="">
		                            <input type="text" class="form-control global_filter" id="global_filter" placeholder="Search.." required="">
		                            <button type="submit" class="btn btn-icon"><i class="ik ik-search"></i></button>
		                            <button type="button" id="adv_wrap_toggler_1" class="adv-btn ik ik-chevron-down dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
		                           
		                                <button class="btn btn-theme">Search</button>
		                         
		                        </form>
		                    </div>
		                </div>
		                <div class="col col-sm-5">
		                    <div class="card-options text-right">
		                    

			                    <a href="{{url('technical_reports/create')}}" class=" btn btn-outline-primary btn-semi-rounded ">Add Report</a>
		                    </div>
		                </div>
		            </div>
		            <div class="card-body">




		                <table id="technical_reports_table" class="table">
		                    <thead>
		                        <tr>
								
	
									<th>name</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                    


						

{{-------------------------------------------------------------------------------------------------------}}






		                    </tbody>
		                </table>
		            </div>

		



		        </div>
		    </div>
		    <!-- list layout 1 end -->





		





		</div>




		
	</div>








    <!-- push external js -->
    @push('script')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--server side users table script-->
    <script src="{{ asset('js/customva.js') }}"></script>
    @endpush








@endsection