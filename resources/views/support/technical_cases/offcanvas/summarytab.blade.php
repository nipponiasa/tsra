@can('reporting_data_entry')

<div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="pills-setting-tab">  
    {{-- "show active" is the class to defaul show --}}
    <div class="card-body">
        <form class="form-horizontal"  method="POST" action="/technical_reports/update_summary">
                @csrf
                <input type="hidden" id="supportid" name="supportid" value="{{$support_case->id}}">


        <div class="form-group">
                <label for="casesummary">{{ __('Summary')}}</label>
                <textarea name="casesummary" name="casesummary" rows="5" class="form-control">{!!$support_case->summary!!}</textarea>
            </div>

            <div class="form-group">
                <label for="status">{{ __('Select Status')}}</label>
                <select name="status" id="status" class="form-control">
                <option value="" >{{ __('Select Status')}}</option>
                        @foreach ($statuses_array as $status) 
                        <option value="{{$status->id}}"   @if ($status->id == $support_case->status_id)  {{ 'selected' }} @else @endif >{{$status->statusname}}</option>
                        @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="issue1">{{ __('Select Category')}}</label>
                <select onchange="updateissue2()" name="issue1" id="issue1" class="form-control">
                <option value="" >{{ __('Select Category')}}</option>
                @foreach ($categories_array as $category) 
                        <option value="{{$category->id}}"   @if ($category->id == $support_case->issue1)  {{ 'selected' }} @else @endif >{{$category->issuename}}</option>
                        @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="issue2">{{ __('Select Issue')}}</label>
                <select onchange="updateissue3()" name="issue2" id="issue2" disabled class="form-control">
                <option value="" >{{ __('Select Issue')}}</option>
                @foreach ($issues_array as $issue) 
                        <option value="{{$issue->id}}"   @if ($issue->id == $support_case->issue2)  {{ 'selected' }} @else @endif >{{$issue->issuename}}</option>
                        @endforeach
                </select>
            </div>
            

            <div class="form-group">
                <label for="issue3">{{ __('Specify More')}}</label>
                <select name="issue3" id="issue3" disabled class="form-control">
                <option value="" >{{ __('Specify More')}}</option>
                @foreach ($specifymore_array as $specifymore) 
                        <option value="{{$specifymore->id}}"   @if ($specifymore->id == $support_case->issue3)  {{ 'selected' }} @else @endif >{{$specifymore->issuename}}</option>
                @endforeach
                </select>
            </div>

            @can('approve_claims')
                <div class="form-group">
                <input class="border-checkbox" type="checkbox" id="claimapproved" name="claimapproved"  @if ($support_case->claim_approved == 1)  {{ 'checked' }} @endif  >
                        <label class="border-checkbox-label" for="claimapproved" >Claim approved?</label>
                      
            </div>
            @endcan

            <div class="form-group">
                <input class="border-checkbox" type="checkbox" id="nextorderreminder" name="nextorderreminder" value={!!$support_case->nextorderreminder!!} @if ($support_case->nextorderreminder == 1)  {{ 'checked' }} @endif  >
                        <label class="border-checkbox-label" for="nextorderreminder" >Reminder for next order?</label>
                      
            </div>


            <div class="form-group">
                <label for="nextorderremindert">{{ __('Reminder')}}</label>
                <textarea name="nextorderremindert" id="nextorderremindert" rows="5" class="form-control" @unless ($support_case->nextorderreminder == 1)  {{ 'disabled' }} @endunless >{!!$support_case->nextorderremindert!!}</textarea>
            </div>


{{-- VIN table --}}


            <div class="form-group">
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
                            <tbody>





@foreach($rel_vins as $result) 
<tr>
<td>{{$result->vin}}</td>
<td>{{$result->model}}</td>
<td>{{$result->po}}</td>
<td>{{$result->color}}</td>
</tr>
@endforeach






</tbody>
</table>
</div>



            {{-- VIN table --}}









            <button class="btn btn-success" type="submit">Update Summary</button>
        </form>
    </div>




</div>
























@endcan

@push('script')
<script src="{{ asset('js/va/nextorderreminder.js') }}"></script>
@endpush