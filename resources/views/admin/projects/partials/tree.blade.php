<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="form-group">
                <label>Select Sub Source</label>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Campaign Name</th>
                                        <th>Source Name</th>
                                        <th>Sub Source Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subSources as $subSource)
                                        <tr>
                                            <td>
                                                <label>
                                                    <input type="checkbox" name="Subsource[]"
                                                        value="{{ $subSource->id }}">
                                                </label>
                                            </td>
                                            <td>{{ $subSource->source->campaign->campaign_name ?? ''}}</td>
                                            <td>{{ $subSource->source->name?? '' }}</td>
                                            <td>{{ $subSource->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="project_id" value="{{$projects->id}}" id="project_id">
@foreach($projectsubsource as $subsource)
    <input type="hidden" name="project_subsource_id[]" value="{{$subsource->id}}" id="project_subsource_id_{{$subsource->id}}">
@endforeach


