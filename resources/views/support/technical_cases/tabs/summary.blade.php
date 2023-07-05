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

            <h3>Case Details</h3>
        
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


                                    {{-- VINS Section --}}
                                    <div class="" x-data="{ 
                                        vins: [] , 
                                        showvin: vin=>vin[0]+' - '+vin[1]+'km',
                                    }">      

                                
                                        <div class="form-group" >

                                            <label>Vechicle Identities <span class="text-danger">*</span> <i class="fa fa-info-circle text-primary" data-toggle="tooltip" aria-hidden="true" title="Enter VIN & distance travelled in kilometers and press &quot;Add VIN&quot;"> </i></label>
                                            <div class="input-group">
                                                    {{-- <div class=""> --}}
                                                        <input id="newVIN" type="text" min="0" class="form-control" placeholder="Enter VIN here" @keydown.enter.prevent="addVIN.click()">
                                                        {{-- <label for="newVIN">VIN</label> --}}
                                                    {{-- </div> --}}
                                                    {{-- <div class=""> --}}
                                                        <input id="newKM" type="number" min="0" step="1" class="form-control" placeholder="Distance (km)" @keydown.enter.prevent="addVIN.click()" style="max-width:200px">
                                                        {{-- <label for="newKM">Distance (km)</label> --}}
                                                    {{-- </div> --}}
                                                    <button class="btn btn-secondary" type="button" id="addVIN" 
                                                    @click="
                                                        if (newVIN.value.length>0) {vins.push([newVIN.value,newKM.value||0])};
                                                        newVIN.value='';newKM.value=''
                                                    ">
                                                        Add VIN
                                                    </button>

                                                    {{-- <input type="text" placeholder="VIN" name="vin_table[]" id="vin1" value=""/> --}}
                                                    {{-- <input type="text" placeholder="Distance(km)" name="distance_table[]" id="distance" value=""/> --}}
                                                    {{-- <a href="javascript:void(0);" class="add_button" title="Add field"><img src="/img/add-icon.png"/></a> --}}
                                                    {{-- <p id="model_desc1"></p> --}}
                                            </div>
                                            <div class="form-group my-2 bg-light">
                                                <select name="vins[]" id="vins" class="form-control select2" multiple="multiple" size="1" required>
                                                    @foreach ($case->vins??[] as $vin)
                                                        <option value="{{implode(',',$vin->as_array())}}" selected   >{{$vin->vin}} - {{$vin->distance}}km</option>
                                                    @endforeach
                                                    <template x-for="vin in vins">
                                                        <option :value="vin.toString()" x-text="showvin(vin)" selected></option>
                                                    </template>
                                                </select>
                                            </div>
        
                                        </div>


                                    
                                    </div>


            <div class="form-group">
                <label for="submitter">Submitter</label>
                <input id="submitter" type="text" class="form-control" name="submitter" value="{{old('submitter')??$case->user->name??'' }}" disabled>
            </div>

            <hr class="mt-5 border border-dark">

            <h3>Nipponia Notes</h3>

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



            



            <hr class="my-4 border border-dark">


            <div class="text-end">

                <div class="form-group mt-4">
                    <input class="form-check-input" type="checkbox" id="donotmail" name="donotmail" value="1" >
                    <label class="form-check-label" for="donotmail" >Do not send e-mail on Update</label>     
                </div>
                
                <button class="btn btn-success" type="submit">Update Summary</button>
            </div>
        </form>
    </div>




</div>
























@endcan

@push('script')
<script src="{{ asset('js/va/nextorderreminder.js') }}"></script>
@endpush