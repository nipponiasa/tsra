

<div class="tab-pane fade" id="tabs-messaging" role="tabpanel" aria-labelledby="pills-messaging-tab" tabindex="0"> 
    <div class="card-body">


        <h3>Use Outlook</h3>



        {{-- <p>Click here to prepare a message in Outlook</p> --}}
        <button id="messageToOutlook" class="btn btn-primary" type="button">Prepare message in Outlook</button>



        <hr class="my-5">



        <h3>Send Directly</h3>
        <form action="/api/messageToFactory" method="post">
            @csrf

            <input type="hidden" name="case_id" value="{{$case->id}}">
            
            <div class="mb-3">
                <label for="to" class="form-label">To <span class="text-danger">*</span> <i class="fa fa-info-circle text-primary" data-toggle="tooltip" aria-hidden="true" title="For multiple recipients, separate by space"></i> </label>
                <input type="text" class="form-control" id="to" name="to" value="" required>
            </div>
            <div class="mb-3">
                <label for="cc" class="form-label">CC  <i class="fa fa-info-circle text-primary" data-toggle="tooltip" aria-hidden="true" title="For multiple recipients, separate by space"></i>  </label>
                <input type="text" class="form-control" id="cc" name="cc" value="">
            </div>
            <div id="attachmentsDiv">
                <label for="photos" class="form-label">Attachments </label>
                <select name="attachments[]" class="form-select select2" multiple aria-label="multiple select example">
                    @if (isset($photos))
                    @foreach ($photos as $photo)
                        <option value="{{basename($photo)}}" selected>{{basename($photo)}}</option>
                    @endforeach
                    <a class="link-primary" href="{{route('directives.files',$case->id)}}" target="_blank">View all</a>
                @endif
                </select>

                {{-- @if (isset($photos))
                    @foreach ($photos as $photo)
                        @php $photo_name = basename($photo); @endphp
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="photo" value="{{$photo_name}}" data-url="{{$photos_path.basename($photo)}}" id="{{$photo_name}}" checked>
                            <label class="form-check-label" for="{{$photo_name}}" >{{$photo_name}}</div>
                    @endforeach
                    <a class="link-primary" href="{{route('directives.files',$case->id)}}" target="_blank">View all</a>
                @endif --}}
            </div>
            <div class="my-3">
                <label for="emailsubject" class="form-label">Subject <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="emailsubject" name="emailsubject" value="Case {{$case->id}} - {{$case->subject}}">
            </div>
            <div class="form-group">
                <label for="emailbody">{{ __('Message')}} <span class="text-danger">*</span></label>
                <textarea name="emailbody" id="emailbody" class="form-control" rows="10">{{old('message')??''}}</textarea>
            </div>

            <div class="text-end">
                    <div><button type="submit" class="btn btn-primary show-spinner">Send e-mail</button></div>
                    <div class="spinner spinner-border text-primary my-3 mx-4 d-none" role="status"></div>
            </div>   

        </form>


    </div>

</div>