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
                            <h1>Technical Directives</h1>
                            {{-- <p class="lead">Read carefully the Technical Directives</p> --}}
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
                <div class="card px-2">
                    {{-- <div class="card-header">
							<div class="card-options text-left">
								<a href="{{url('technical_reports/create')}}" class=" btn btn-outline-primary btn-semi-rounded ">Add Directive</a>
							</div>
						</div> --}}




                    <div class="card-body">
                        <table id="data_table" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
									<th>{{__('Subject')}}</th>
		                            <th>{{__('Models')}}</th>
		                            <th>{{__('Countries')}}</th>
		                            <th>{{__('Updated on')}}</th>
		                            <th>{{__('Status')}}</th>
									<th>{{__('File')}}</th>
                                </tr>
                            </thead>
                            <tbody>



							{{-------------------------------------------------------------------------------------------------------}}

									

                            @foreach($technical_directives as $directive) 
                                <tr>
                                <td>{{$directive->id}}</td> 
                                <td><a href="/technical_directives/{{$directive->id}}/edit">{{$directive->subject}}</a></td>
                                <td>{{$directive->motorModels->pluck('name')->implode(', ')}}</td>
                                <td>{{$directive->motorCountries->pluck('shortname')->implode(', ')}}</td>
                                <td>{{date('d-m-Y', strtotime($directive->updated_at))}}</td>
                                <td> 
                                    {{$directive->state}}
                                    {{-- @if (!$directive->isread) <span class="badge badge-secondary">Unread</span> @endif --}}
                                </td>
                                <td>
                                    @if ($directive->filepath() != null)
                                        <a href="{{$directive->filepath()}}"><i class="ik ik-file text-success"></i></a>
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
    @endpush








@endsection