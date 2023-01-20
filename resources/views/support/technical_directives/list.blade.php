@extends('layouts.main') 
@section('title', 'Technical Directives')
@section('content')

@push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    @endpush


 



	<div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-green"></i>
                        <div class="d-inline">
                            <h5>Technical Directives</h5>
                            <span>Read carefully the Technical Directives</span>
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
                                <a href="#">Technical Directives</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>










        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
							<div class="card-options text-left">
								<a href="{{url('technical_reports/create')}}" class=" btn btn-outline-primary btn-semi-rounded ">Add Directive</a>
							</div>
						</div>




                    <div class="card-body">
                        <table id="data_table" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
									<th>{{__('Subject')}}</th>
		                            <th>{{__('Model(s)')}}</th>
		                            <th>{{__('Date')}}</th>
		                            <th>{{__('Status')}}</th>
									<th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>



							{{-------------------------------------------------------------------------------------------------------}}

									

@foreach($uii as $result) 
<tr>
<td>{{$result->directive_id}}</td> 
<td>{{$result->subject}}</td>
<td>{{$result->models}}</td>
<td>{{date('d-m-Y', strtotime($result->directive_created_at))}}</td>
<td> @if (!$result->isread) <span class="badge badge-secondary">Unread</span> @endif</td>
<td><a href="/technical_directives/{{$result->directive_id}}"><i class="ik ik-message-square f-16 mr-15 text-green"></i></a></td>
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
    @endpush








@endsection