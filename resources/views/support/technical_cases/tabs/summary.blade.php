<div class="tab-pane fade show active" id="tabs-summary" role="tabpanel" aria-labelledby="pills-summary-tab" tabindex="0">  
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


            <label for="files" class="mt-2">{{ __('Files')}} </label>
            @if (isset($photos))
                <ul style="list-style-type:circle;" class="mb-1">
                    @foreach ($photos as $photo)
                            <li><a class="link-info2" href="{{$photos_path.basename($photo)}}" target="_blank">{{basename($photo)}}</a></li>
                    @endforeach
                </ul>
                <a class="link-primary" href="{{route('directives.files',$case->id)}}">View all</a>
            @endif


                                    {{-- VINS Section --}}
                                    <div class="my-4" x-data="{ 
                                        vins: [] , 
                                        showvin: vin=>vin[0]+' - '+vin[1]+'km',
                                    }">      

                                
                                        <div class="form-group" >

                                            <label>Vechicle Identities <span class="text-danger">*</span> <i class="fa fa-info-circle text-primary" data-toggle="tooltip" aria-hidden="true" title="Enter VIN & distance travelled in kilometers and press &quot;Add VIN&quot;"> </i></label>
                                            <div class="input-group">
                                                        <input id="newVIN" type="text" min="0" class="form-control" placeholder="Enter new VINs here" @keydown.enter.prevent="addVIN.click()">
                                                        <input id="newKM" type="number" min="0" step="1" class="form-control" placeholder="Mileage (km)" @keydown.enter.prevent="addVIN.click()" style="max-width:200px">
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

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="country">Applicable country</label>
                    {{-- <input id="country" type="text" class="form-control" name="country" value="{{old('country')??$case->user->country->name??'' }}" disabled> --}}
                    <select name="country" id="country" class="form-select" required>
                        <option value="" ></option>
                        @foreach ($countries as $country)
                            <option value="{{$country->id}}" {{ (old('country')==$country->id || $case->country_id==$country->id ) ? 'selected':'' }}  >{{$country->shortname.' - '.$country->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr class="mt-5 border border-dark">

            <h3>Nipponia Notes</h3>


            
            <script>

                //if there is no case->category, it becomes: '', corresponding to the value="" option
                let category = "{{old('category')??$case->category }}";     
                let issue = "{{old('issue')??$case->issue }}";
                let part = "{{old('subissue')??$case->part }}";


                let categories = ["Electrical", "Mechanical", "Frame parts"];
                var issues = [
                    ["Electrical", "Assembly"],
                    ["Electrical", "Damage"],
                    ["Electrical", "Charging"],
                    ["Electrical", "Defect"],
                    ["Electrical", "Delivery"],
                    ["Electrical", "Noise"],
                    ["Electrical", "Malfunction"],
                    ["Electrical", "Packaging"],
                    ["Electrical", "Paint"],
                    ["Electrical", "Rust"],
                    ["Electrical", "Scratches"],
                    ["Electrical", "Short-circuit"],
                    ["Electrical", "Update"],
                    ["Mechanical", "Assembly"],
                    ["Mechanical", "Damage"],
                    ["Mechanical", "Defect"],
                    ["Mechanical", "Delivery"],
                    ["Mechanical", "Noise"],
                    ["Mechanical", "Fuel feed"],
                    ["Mechanical", "Malfunction"],
                    ["Mechanical", "Packaging"],
                    ["Mechanical", "Paint"],
                    ["Mechanical", "Rust"],
                    ["Mechanical", "Scratches"],
                    ["Frame parts", "Assembly"],
                    ["Frame parts", "Damage"],
                    ["Frame parts", "Defect"],
                    ["Frame parts", "Delivery"],
                    ["Frame parts", "Noise"],
                    ["Frame parts", "Malfunction"],
                    ["Frame parts", "Packaging"],
                    ["Frame parts", "Paint"],
                    ["Frame parts", "Rust"],
                    ["Frame parts", "Scratches"]
                ];
                var parts = [
                    ["Electrical", "Battery"],
                    ["Electrical", "Charger"],
                    ["Electrical", "Controller"],
                    ["Electrical", "Convertor"],
                    ["Electrical", "Headlight"],
                    ["Electrical", "Ignition"],
                    ["Electrical", "Instrument"],
                    ["Electrical", "Left switch"],
                    ["Electrical", "Motor"],
                    ["Electrical", "Power switch"],
                    ["Electrical", "Right switch"],
                    ["Electrical", "Taillight"],
                    ["Electrical", "T-box"],
                    ["Electrical", "Throttle"],
                    ["Electrical", "Winkers"],
                    ["Electrical", "Wire harness"],
                    ["Electrical", "Wiring"],
                    ["Mechanical", "Belt"],
                    ["Mechanical", "Bearings"],
                    ["Mechanical", "Carburetor"],
                    ["Mechanical", "Clutch"],
                    ["Mechanical", "Crankshaft"],
                    ["Mechanical", "CVT"],
                    ["Mechanical", "Cylinder / Piston / Rings"],
                    ["Mechanical", "Muffler"],
                    ["Mechanical", "Oil pump"],
                    ["Frame parts", "Bearings"],
                    ["Frame parts", "Brackets"],
                    ["Frame parts", "Brake disc"],
                    ["Frame parts", "Brake pad"],
                    ["Frame parts", "Cables"],
                    ["Frame parts", "Calipers"],
                    ["Frame parts", "CBS"],
                    ["Frame parts", "Covers"],
                    ["Frame parts", "Fender"],
                    ["Frame parts", "Front fork"],
                    ["Frame parts", "Fuel tank"],
                    ["Frame parts", "Grips"],
                    ["Frame parts", "Levers"],
                    ["Frame parts", "Master cylinder"],
                    ["Frame parts", "Mirrors"],
                    ["Frame parts", "Rear absorber"],
                    ["Frame parts", "Rims"],
                    ["Frame parts", "Seat"],
                    ["Frame parts", "Side covers"],
                    ["Frame parts", "Stand"],
                    ["Frame parts", "Sticker / logo"],
                    ["Frame parts", "Throttle"],
                    ["Frame parts", "Tyres"]
                ];
            </script>

            <div id="categorization" class="row" x-data="{
                categories,
                issues,
                parts,
                category,
                issue,
                part,
                get filteredIssues() {
                    return this.issues.filter( (issue)=>{return issue[0]===this.category} ) ;
                },
                get filteredParts() {
                    return this.parts.filter( (part)=>{return part[0]===this.category} );
                },
            }">
                <div class="form-group col-md-4">
                    <label for="category">{{ __('Category')}} <span class="text-danger">*</span></label>
                    <select name="category" id="category" x-model="category" class="form-select" required>
                        <option value="" disabled>{{ __('Please select category first...')}}</option>
                        <template x-for="categOption in categories" :key="categOption">
                            <option x-text="categOption" :value="categOption" :selected="categOption==category"></option>
                        </template>

                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="issue">{{ __('Issue')}}</label>
                    <select name="issue" id="issue" x-model="issue" class="form-select">
                        <option value="" >{{ __('Please select...')}}</option>
                        <template x-for="[cat,issueOption] in filteredIssues">
                            <option x-text="issueOption" :value="issueOption" :selected="issueOption==issue"></option>
                        </template>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="part">{{ __('Part')}}</label>
                    <select name="part" id="part"  x-model="part" class="form-select">
                        <option value="" >{{ __('Please select...')}}</option>
                        <template x-for="[cat,partOption] in filteredParts">
                            <option x-text="partOption" :value="partOption" :selected="partOption==part"></option>
                        </template>
                    </select>
                </div>

            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="status">{{ __('Status')}} <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select">
                    {{-- <option value="" >{{ __('Please select...')}}</option> --}}
                            @foreach ($statuses as $status) 
                            <option value="{{$status->id}}"  @if ($status->id == $case->status_id)  {{ 'selected' }} @endif  >{{$status->statusname}}</option>
                            @endforeach
                    </select>
                </div>
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



            @can('review_cases')

            <hr class="my-4 border border-dark">

            <div class="text-end">

                <div class="form-group mt-4">
                    <input class="form-check-input" type="checkbox" id="donotmail" name="donotmail" value="1" checked>
                    <label class="form-check-label" for="donotmail" >Do not send an update e-mail</label>     
                </div>
                
                <div><button class="btn btn-success show-spinner" type="submit">Update Summary</button></div>
                <div class="spinner spinner-border text-success my-2 mx-5 d-none" role="status"></div>
            </div>
            @endcan
        </form>
    </div>




</div>
























