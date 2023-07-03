

@can('communication_with_vendor')

                        <div class="tab-pane fade" id="vendor" role="tabpanel" aria-labelledby="pills-setting-tab">
                            <div class="card-body">

                            <div class="row">
                                    <div class="col-lg-12">
                                            <div class="float-right">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newmessagemodalvendor">{{ __('New Message')}}</button>
                                            </div>
                                    </div>
                             </div>




                             <div class="profiletimeline mt-0">
{{-- 
                             @foreach($messages_vendor as $message)
                                  
                             <hr>


<button class="accordion"><span class="badge badge-primary">{{$message->mail_from}}</span><span class="badge badge-light">----></span><span class="badge badge-primary">{{$message->mailto}}</span></button>  <! -- accordeon -->
<div class="panel"><! -- accordeon -->





                                  <div class="sl-item">
                                      <div class="sl-left"> <img src="{url($message->mypic)}" alt="External" class="rounded-circle" /> </div>
                                      <div class="sl-right">
                                          <div> <a href="javascript:void(0)" class="link">{{$message->name}}{{$message->mail_from}}</a> <span class="sl-date">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }} ( @php echo date('d-m-Y', strtotime($support_case->created_at)); @endphp )</span>
                                              <div class="mt-20 row">
                                                
                                                  <div class="col-md-9 col-xs-12">
                                                      <p>{{$message->message}}</p>
                                                  </div>
                                              </div>
                                           
                                          </div>
                                      </div>
                                  </div>
                                  <hr>

          </div><! -- accordeon -->



                               @endforeach --}}

                               </div>
                  





                        </div>
                        </div>


                        <! -- modal -->

<div class="modal fade" id="newmessagemodalvendor" tabindex="-1" role="dialog" aria-labelledby="newmessagemodalLabelvendor" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg mt-0 mb-0" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newmessagemodalLabelvendor">{{ __('New Message')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                   





                <form class="forms" method="POST" enctype="multipart/form-data" action="/technical_reports/send_vendor_message">
                <input type="hidden" id="supportid" name="supportid" value="{{$support_case->id}}">
                {{-- <input type="hidden" id="number_of_files" name="number_of_files" value="{{$number_of_files}}"> --}}

                
                    @csrf

                    <div class="modal-body">
                            <div class="form-group">
                                <label for="input">{{ __('Recipients')}}</label>
                                <input type="text" id="tags"  name="recipients[]" class="form-control" value="">
                            </div>

                            <div class="form-group">
                                <label for="input">{{ __('Subject')}}</label>
                                <input type="text" id="subject_vendor" name="subject_vendor" class="form-control" value="">
                            </div>





                                <div class="form-group">
                                        <label for="messagetovendor">{{ __('Message to Vendor')}} </label>
                                        <textarea name="messagetovendor" name="messagetovendor" rows="5" class="form-control"></textarea>
                                    </div>

                                    
                    


                                    <h5 class="modal-title" >{{ __('Select what you want to forward')}}</h5>
                                    {{-- @foreach($messages as $message)
                                   
                                   
                                    @foreach($files["{$message->messageid}"] as $file)

   

                                              @php 
                                              $file_path=url('/storage/azure_ext/').'/'.$file;
                                              if(in_array(pathinfo($file_path)['extension'],$video_extensions))
                                              {
                                                echo '<div class="col-lg-3 col-md-6 mb-20" style="display:inline-block!important"><input type="checkbox" name="'.$number_of_files--.'" value="'.$file.'">'.pathinfo($file_path)['filename'].' <video width="120"  controls><source src="'.$file_path.'" type="video/mp4"> Your browser does not support the video tag.</video></div>';

                                              }
                                              else
                                              {
                                                echo '<div class="col-lg-3 col-md-6 mb-20" style="display:inline-block!important">  <input type="checkbox" name="'.$number_of_files--.'" value="'.$file.'"> '.pathinfo($file_path)['filename'].' <img src="'.$file_path.'" class="img-fluid rounded" /></div>';
                                             
                                            
                                            
                                            }
                                              
                                        
                                              @endphp
                                       
                                              @endforeach






                                         
                                @endforeach --}}
   
            

                                          

                       
                                        























                          

                                   
                                    <div class="modal-footer">
                                    <button class="btn btn-success" type="submit"> {{ __('Send')}} </button>
                                 
                    </div>








                                </form>



                                </div>
            </div>
        </div>
    </div>

    <! -- modal -->



















                        @endcan


@push('script')
<script src="{{ asset('js/va/accordeonva.js') }}"></script>
@endpush



