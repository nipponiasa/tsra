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
                            <h1>Technical Reports</h1>
                            {{-- <span class="lead">View, delete and update Technical Reports</span> --}}
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
            <div class="col-md-12">
                <div class="card">
                    {{-- <div class="card-header">
							<div class="card-options text-left">
								<a href="{{url('technical_reports/create')}}" class=" btn btn-outline-primary btn-semi-rounded ">Add New Report</a>
							</div>
						</div> --}}




                    <div class="card-body">
                        <table id="data_table" class="table">
                            <thead>
                                <tr>
								{{-- <th class="nosort">Submitter</th> --}}
                                    <th>Case #</th>
									<th>User</th>
		                            <th>Subject</th>
		                            <th>{{__('Model(s)')}}</th>
  		                             <th>Date</th>
		                            <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>



							{{-------------------------------------------------------------------------------------------------------}}

                            {{--------------------------------<img src="{{url($result->mypic)}}" class="table-user-thumb" alt="">---------------------------------------------------------}}

@foreach($technical_cases as $report) 

<tr>

{{-- <td>

<img src="{{url($result->mypic)}}" class="table-user-thumb" alt="">

</td> --}}

<td>
    <a href="/technical_cases/{{$report->id}}/edit">{{$report->id}}</a>
</td>
<td>
    {{-- <a href="/technical_cases/toedit/{{$result->id}}">{{$result->name}}</a> --}}
</td>
<td>
    <a href="/technical_cases/{{$report->id}}/edit">{{$report->subject}}</a>
</td>
<td>
    {{-- <a href="/technical_cases/toedit/{{$result->id}}">{{$result->models}}</a> --}}
</td>
<td>{{date('d-m-Y', strtotime($report->created_at))}}</td>

<td>
    
@if($report->statusname == "Waiting for Nipponia") 
	<span class="badge badge-pill badge-primary mb-1">{{$report->statusname}}</span>
@elseif ($report->statusname == "Waiting for Dealer") 
	<span class="badge badge-pill badge-secondary mb-1">{{$report->statusname}}</span>
@elseif ($report->statusname == "Resolved") 
	<span class="badge badge-pill badge-success mb-1">{{$report->statusname}}</span>
@elseif ($report->statusname == "Claim approved")
	<span class="badge badge-pill badge-danger mb-1">{{$report->statusname}}</span>
@elseif ($report->statusname == "Waiting for Vendor")
	<span class="badge badge-pill badge-warning mb-1">{{$report->statusname}}</span>
@else 
    <span class="badge badge-pill badge-info mb-1">{{$report->statusname}}</span>
@endif
@if($report->claim_approved) 
<span class="badge badge-pill badge-warning mb-1">Claim Approved</span>
@endif
</td>


</tr>




@endforeach

{{-------------------------------------------------------------------------------------------------------}}










                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


		
	</div>








    <!-- push external js -->
    @push('script')
	<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/customva.js') }}"></script>
    @endpush








@endsection