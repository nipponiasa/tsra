@extends('layouts.main') 
@section('title', 'List VINs')
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
                            <h5>List Vins</h5>
                            <span>Vehicle History</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}">Home</a>
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
							
						</div>




                    <div class="card-body">
                        <table id="data_table" class="table p-2">
                            <thead>
                                <tr>
							
                                <th>VIN</th>
                                <th>Case #</th>
                                <th>Case Subject</th>

                                </tr>
                            </thead>
                            <tbody>



							{{-------------------------------------------------------------------------------------------------------}}

									

@foreach($vins as $vin) 

<tr>


<td>{{$vin->vin}}</td>
<td><a href="{{route('cases.review',$vin->case_id)}}">{{$vin->case_id}}</a></td>
<td><a href="{{route('cases.review',$vin->case_id)}}">{{$vin->case->subject}}</a></td>




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