<div class="row">
    <div class="col-md-12">
        @if(!empty($event))
            <input type="hidden" name="lead_event_id" class="form-control" value="{{$event->id}}">
        @endif
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="row">
            
                    {{-- <div class="col-md-6">
                        <div class="form-group"> --}}
                            {{-- <label class="required" for="project_id">{{ trans('messages.project') }}</label> --}}
                            {{-- <select name="project_id" id="project_id" class="form-control {{ $errors->has('project_id') ? 'is-invalid' : '' }}" >
                                @foreach($projects as $id => $project)
                                    <option value="{{$id}}">
                                        {{$project}}
                                    </option>
                                @endforeach
                            </select> --}}
                            {{-- <div class="form-group"> --}}
                                <input type="hidden" name="plot_id" id="plot_id" class="form-control" value="{{ $plotdetail->id }}">
                            {{-- </div> --}}
                            {{-- @if($errors->has('project_id'))
                                <span class="text-danger">Project is required.</span>
                            @endif
                            <span class="help-block text-muted">{{ trans('messages.choose_project') }}</span> --}}
                        {{-- </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="search_phone" class="required">
                                @lang('messages.phone')
                            </label>
                            <div class="input-group">
                                <input type="text" name="search_phone" id="search_phone" value="{{ old('search_phone') ? old('search_phone') : ($phone ?? '') }}" class="form-control input_number">
                                <div class="input-group-append search_lead cursor-pointer">
                                    <span class="input-group-text">
                                        Search
                                    </span>
                                </div>
                            </div>
                            <span class="help-block text-muted">
                                {{ trans('messages.search_lead_by_phone') }} <br>
                                Enter phone number including country code without + sign.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row info_section sell_do_and_lead_info">
    @includeIf('admin.booking_new.partials.sell_do_and_lead_info')
</div>

