

<div class="tab-pane fade" id="tabs-messaging" role="tabpanel" aria-labelledby="pills-messaging-tab" tabindex="0"> 
    <div class="card-body">


        <h3>Use Outlook</h3>



        {{-- <p>Click here to prepare a message in Outlook</p> --}}
        <button id="messageToOutlook" class="btn btn-primary" type="button">Prepare message in Outlook</button>

        <hr class="my-5">

        <h3>Send Directly</h3>
        <form action="/api/messageToFactory" method="post">
            
            <div class="mb-3">
                <label for="to" class="form-label">To <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="to" value="">
            </div>
            <div class="mb-3">
                <label for="cc" class="form-label">CC <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="cc" value="">
            </div>
            <div>
                <label for="photos" class="form-label">Attachments </label>
                @if (isset($photos))

                    @foreach ($photos as $photo)
                        @php $photo_name = basename($photo); @endphp
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{$photo_name}}" id="{{$photo_name}}" checked>
                            <label class="form-check-label" for="{{$photo_name}}">
                                {{$photo_name}}
                            </label>
                        </div>
                    @endforeach
                    <a class="link-primary" href="{{route('directives.files',$case->id)}}" target="_blank">View all</a>
            @endif
            </div>
            <div class="my-3">
                <label for="emailsubject" class="form-label">Subject <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="emailsubject"  value="Case {{$case->id}} - {{$case->subject}}">
            </div>
            <div class="form-group">
                <label for="emailbody">{{ __('Message')}} <span class="text-danger">*</span></label>
                <textarea name="Message" id="emailbody" class="form-control" rows="10">{{old('message')??''}}</textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Send e-mail</button>
            </div>   

        </form>


    </div>

</div>