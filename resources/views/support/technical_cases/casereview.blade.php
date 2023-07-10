@extends('layouts.main') 
@section('title', 'Review Technical Case')
@section('content')

@push('script')
{{-- <script src="{{ asset('js/va/issueselect.js') }}"></script> --}}
<script defer src="{{ asset('js/casereview.js') }}"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
@endpush




    <div class="container-fluid">
    <div class="page-header">
            <div class="row align-items-end">



                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h1>{{$case->subject}}</h1>
                            <p class="lead">Review Technical Case</p>
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
                                <a href="#">Technical Cases</a>
                            </li>
                            {{-- <li class="breadcrumb-item">
                                <a href="#">Message</a>
                            </li> --}}
                        </ol>
                    </nav>
                </div>





            </div>
       </div>



        <div class="row">
          

            <div class="">
                <div class="card">
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">

                        {{-- <li class="nav-item">
                            <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#timeline" role="tab" aria-controls="pills-timeline" aria-selected="true">{{ __('Importer')}}</a>
                        </li> --}}


                        {{-- @can('reporting_data_entry') --}}
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-summary-tab" data-bs-toggle="pill" data-bs-target="#tabs-summary" type="button" role="tab" aria-controls="tabs-summary" aria-selected="true">{{ __('Case Summary')}}</button>
                        </li>
                        {{-- @endcan --}}

                        {{-- @can('communication_with_vendor') --}}
                        <li class="nav-item">
                            <button class="nav-link" id="pills-messaging-tab" data-toggle="pill" data-bs-toggle="pill" data-bs-target="#tabs-messaging" type="button" role="tab" aria-controls="tabs-messaging" aria-selected="false">{{ __('Messaging')}}</button>
                        </li>
                        {{--  @endcan --}}


                    </ul>



                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="timeline" role="tabpanel" aria-labelledby="pills-timeline-tab">
                            
                            {{--<div class="card-body">

                            <div class="row">
                                    <div class="col-lg-12">
                                            <div class="float-right">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newmessagemodal">{{ __('Reply')}}</button>
                                            </div>
                                    </div>
                             </div>






                                <div class="profiletimeline mt-0">



          

                             @foreach($messages as $message)
                                  
                                  <div class="sl-item">
                                      <div class="sl-left"> <img src=@php echo url($message->mypic); @endphp alt="user" class="rounded-circle" /> </div>
                                      <div class="sl-right">
                                          <div> <a href="javascript:void(0)" class="link">{{$message->name}}</a> <span class="sl-date">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }} ( @php echo date('d-m-Y', strtotime($case->created_at)); @endphp )</span>
                                              <div class="row">
                                                
                                                  <div class="col-md-9 col-xs-12">
                                                      <p style="white-space: pre-wrap;">  {!!$message->message!!}</p>
                                                  </div>
                                              </div>
                                             
                                              @foreach($files["{$message->messageid}"] as $file)
                                              @php 
                                              $file_path=url('/storage/azure_ext/').'/'.$file;
                                              if(in_array(pathinfo($file_path)['extension'],$video_extensions))
                                              {
                                                echo '<div class="col-lg-3 col-md-6 mb-20" style="display:inline-block!important"> <video width="320" height="240" controls><source src="'.$file_path.'" type="video/mp4"> Your browser does not support the video tag.</video><a href="'.$file_path.'" download><i class="ik ik-download-cloud"></i></a></div>';

                                              }
                                              else
                                              {
                                                echo '<div class="col-lg-3 col-md-6 mb-20" style="display:inline-block!important">  <img src="'.$file_path.'" class="img-fluid rounded" /> <a href="'.$file_path.'" download><i class="ik ik-download-cloud"></i></a></div>';
                                              }
                                              
                                        
                                              @endphp
                                       
                                              @endforeach
                                         
                                        </div>
                                          </div>
                                      </div>
                                  
                                  <hr>
                               @endforeach 









                                </div>
                            </div>--}}
                        </div>

         
                        @include('support.technical_cases.tabs.summary')
                        @include('support.technical_cases.tabs.messaging')


                    </div>
               </div>
            </div>
        </div>
    </div>



    <! -- modal -->

    <div class="modal fade" id="newmessagemodal" tabindex="-1" role="dialog" aria-labelledby="newmessagemodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg mt-0 mb-0" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newmessagemodalLabel">{{ __('New Message')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form class="forms" method="POST" enctype="multipart/form-data" action="/technical_cases/update_new_message">
                        @csrf
                    <div class="modal-body">

                    <input type="hidden" id="supportid" name="supportid" value="{{$case->id}}">
                                    <div class="form-group">
                                        <label for="message">{{ __('Message')}}<span class="text-red">*</span></label>
                                        <textarea name="message" id="message" class="form-control" rows="10"></textarea>
                                  </div>

                                    <div class="form-group">
                                        <label>Photos/Videos</label>
                                        <div class="input-images" data-input-name="photos" data-label="Drag & Drop here or click to browse"></div>
                                    </div>


               





                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Submit')}}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>

        <! -- modal -->









@endsection
