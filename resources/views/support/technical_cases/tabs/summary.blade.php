@can('reporting_data_entry')

<div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="pills-setting-tab">  
    {{-- "show active" is the class to defaul show --}}
    <div class="card-body">
        <form class="form-horizontal"  method="POST" action="{{route("cases.revise",$case->id)}}">
                @csrf
                @if($action=="review")
                    @method('PUT')
                @endif

                {{-- <input type="hidden" id="supportid" name="supportid" value="{{$case->id}}"> --}}

        
            <div class="form-group">
                <label for="subject">Subject <span class="text-danger">*</span></label>
                <input id="subject" type="text" class="form-control" name="subject" value="{{old('subject')??$case->subject??'' }}" placeholder="Enter a subject" required>
                <div class="help-block with-errors">
                    @error('subject')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="form-group">
                <label for="description">{{ __('Description')}} <span class="text-danger">*</span></label>
                <textarea name="description" id="description" class="form-control" rows="5" required>{{old('description')??$case->description??'' }}</textarea>
                <div class="help-block with-errors">
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="models">{{ __('Model(s)')}} </label>
                <select name="models[]" id="models" class="form-control select2" multiple="multiple">
                </select>
            </div>

            <div class="form-group">
                <label for="po">Purchase Order</label>
                <input id="po" type="text" class="form-control" name="purchase_order" value="{{old('subject')??$case->po??'' }}" placeholder="Enter Purchase Order">
            </div>

            <hr class="my-4">

            @php
                $categories = array(
                            '1' => "Electrical",
                            '2' => "Mechanical",
                            '3' => "Delivery",
                            '4' => "Battery",
                            '5' => "Controller",
                            '6' => "Lighting",
                            '7' => "Braking",
                            '8' => "Dashboard",
                            '9' => "Plastic parts",
                            '10' => "Charging problem",
                            '11' => "Range issues",
                            '12' => "Update problem",
                            '13' => "Burnt",
                            '14' => "Paint issues",
                            '15' => "Broken parts",
                            '16' => "Stickers issues",
                            '17' => "Other",
                        );
            @endphp

            <div class="form-group">
                <label for="category">{{ __('Category')}}</label>
                <select name="category" id="category" class="form-select">
                <option value="0" >{{ __('Please select...')}}</option>
                @foreach ($categories as $category_id=>$category_name) 
                        <option value="{{$category_id}}"   @if ($category_id == $case->case_category_id)  {{ 'selected' }} @endif >{{$category_name}}</option>
                @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="status">{{ __('Status')}} <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-select">
                {{-- <option value="" >{{ __('Please select...')}}</option> --}}
                        @foreach ($statuses as $status) 
                        <option value="{{$status->id}}"  @if ($status->id == $case->status_id)  {{ 'selected' }} @endif  >{{$status->statusname}}</option>
                        @endforeach
                </select>
            </div>





            {{-- <div class="form-group">
                <label for="issue2">{{ __('Select Issue')}}</label>
                <select onchange="updateissue3()" name="issue2" id="issue2" disabled class="form-control">
                <option value="" >{{ __('Select Issue')}}</option>
                @foreach ($issues_array as $issue) 
                        <option value="{{$issue->id}}"   @if ($issue->id == $case->issue2)  {{ 'selected' }} @else @endif >{{$issue->issuename}}</option>
                        @endforeach
                </select>
            </div> --}}
            

            {{-- <div class="form-group">
                <label for="issue3">{{ __('Specify More')}}</label>
                <select name="issue3" id="issue3" disabled class="form-control">
                <option value="" >{{ __('Specify More')}}</option>
                @foreach ($specifymore_array as $specifymore) 
                        <option value="{{$specifymore->id}}"   @if ($specifymore->id == $case->issue3)  {{ 'selected' }} @else @endif >{{$specifymore->issuename}}</option>
                @endforeach
                </select>
            </div> --}}

            {{-- @can('approve_claims') --}}
                <div class="form-group m-4">
                    <input class="form-check-input" type="checkbox" id="claimapproved" name="claimapproved"  @if ($case->claim_approved == 1)  {{ 'checked' }} @endif  >
                    <label class="form-check-label" for="claimapproved" >Claim approved</label>  
                </div>
            {{-- @endcan --}}

            <div class="form-group m-4">
                <input class="form-check-input" type="checkbox" id="reminder" name="reminder" value={!!$case->nextorderreminder!!} @if ($case->nextorderreminder == 1)  {{ 'checked' }} @endif  >
                <label class="form-check-label" for="reminder" >Reminder for next order</label>     
            </div>


            <div class="form-group">
                <label for="reminder_desc">{{ __('Reminder')}}</label>
                <textarea name="reminder_desc" id="reminder_desc" rows="5" class="form-control" @unless ($case->nextorderreminder == 1)  {{ 'disabled' }} @endunless >{!!$case->nextorderremindert!!}</textarea>
            </div>


{{-- VIN table --}}


            {{-- <div class="form-group">
            <label for="vins">{{ __('Related vehicles')}}</label> 
            <table id="vins" class="table">
                            <thead>
                                <tr>

                                    <th>VIN</th>
									<th>Model</th>
		                            <th>PO</th>
		                            <th>Color</th>

                                </tr>
                            </thead>
                            <tbody> --}}





{{-- @foreach($rel_vins as $result) 
<tr>
<td>{{$result->vin}}</td>
<td>{{$result->model}}</td>
<td>{{$result->po}}</td>
<td>{{$result->color}}</td>
</tr>
@endforeach --}}






{{-- </tbody>
</table>
</div> --}}



            {{-- VIN table --}}








            <div class="text-end">
                <button class="btn btn-success my-4" type="submit">Update Summary</button>
            </div>
        </form>
    </div>




</div>
























@endcan

@push('script')
<script src="{{ asset('js/va/nextorderreminder.js') }}"></script>
@endpush