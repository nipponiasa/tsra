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
                <textarea name="description" id="description" class="form-control" rows="5" disabled>{{old('description')??$case->description??'' }}</textarea>
            </div>

            <div class="form-group">
                <label for="model">{{ __('Model')}} <span class="text-danger">*</span> <i class="fa fa-info-circle text-primary" data-toggle="tooltip" aria-hidden="true" title="Use no spaces between the model's name and displacement (For example, BRIO110) "> </i></label>
                <input id="model" type="text" class="form-control" name="model" value="{{old('model')??$case->model??'' }}" placeholder="" required>
                </select>
            </div>

            {{-- <div class="form-group">
                <label for="models">{{ __('Model(s)')}} </label>
                <select name="models[]" id="models" class="form-control select2" multiple="multiple">
                </select>
            </div> --}}

            <div class="form-group">
                <label for="purchase_order">Purchase Order</label>
                <input id="purchase_order" type="text" class="form-control" name="purchase_order" value="{{old('purchase_order')??$case->purchase_order??'' }}" placeholder="Enter Purchase Order">
            </div>


            <label for="files">{{ __('Files')}} </label>
            <br>
            <label for="vins">{{ __('VINs')}} </label>

            <div class="form-group">
                <label for="submitter">Submitter</label>
                <input id="submitter" type="text" class="form-control" name="submitter" value="{{old('submitter')??$case->user->name??'' }}" disabled>
            </div>

            <hr class="my-4 border border-dark">

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

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="category">{{ __('Category')}}</label>
                    <select name="category" id="category" class="form-select">
                    <option value="0" >{{ __('Please select...')}}</option>
                    @foreach ($categories as $category_id=>$category_name) 
                            <option value="{{$category_id}}"   @if ($category_id == $case->case_category_id)  {{ 'selected' }} @endif >{{$category_name}}</option>
                    @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="subcategory">{{ __('Subcategory')}}</label>
                    <select name="subcategory" id="subcategory" class="form-select">
                    <option value="0" >{{ __('Please select...')}}</option>
                    @foreach ($categories as $subcategory_id=>$subcategory_name) 
                            <option value="{{$subcategory_id}}"   @if ($subcategory_id == $case->case_subcategory_id)  {{ 'selected' }} @endif >{{$subcategory_name}}</option>
                    @endforeach
                    </select>
                </div>

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


            <div class="form-group">
                <label for="notes">{{ __('Notes')}} </label>
                <textarea name="notes" id="notes" class="form-control" rows="5">{{old('notes')??$case->notes??'' }}</textarea>
                <div class="help-block with-errors">
                    @error('notes')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
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
                    <input class="form-check-input" type="checkbox" id="approved" name="approved"  @if ($case->approved == 1) {{ 'checked' }} @endif  value="1" >
                    <label class="form-check-label" for="approved" >Claim approved</label>  
                </div>
            {{-- @endcan --}}

            <div class="form-group m-4">
                <input class="form-check-input" type="checkbox" id="reminder" name="reminder" value="1" @if ($case->reminder == 1) {{ 'checked' }} @endif  >
                <label class="form-check-label" for="reminder" >Reminder for next order</label>     
            </div>


            <div class="form-group">
                <label for="reminder_desc">{{ __('Reminder')}}</label>
                <textarea name="reminder_desc" id="reminder_desc" rows="5" class="form-control" value="1" @unless ($case->reminder == 1)  {{ 'disabled' }} @endunless >{{old('reminder_desc')??$case->reminder_desc }}</textarea>
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