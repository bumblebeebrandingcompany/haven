@extends('selldo.layouts.admin')

@section('content')

    <div class="container">
        <h2>CP form</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('selldo.leads.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="sell_do_lead_id">Selldo ID</label>
                <input type="number" class="form-control" id="sell_do_lead_id" name="sell_do_lead_id">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email1">Email 1</label>
                <input type="email" class="form-control" id="email1" name="email1" required>
            </div>
            <div class="form-group">
                <label for="email2">Email 2</label>
                <input type="email" class="form-control" id="email2" name="email2">
            </div>
            <div class="form-group">
                <label for="phone1">Phone 1</label>
                <input type="text" class="form-control" id="phone1" name="phone1" required>
            </div>
            <div class="form-group">
                <label for="phone2">Phone 2</label>
                <input type="text" class="form-control" id="phone2" name="phone2">
            </div>
            <div class="form-group">
                <label class="required" for="project_id">{{ trans('cruds.lead.fields.project') }}</label>
                <br>
                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}" name="project_id"
                    id="project_id" required>
                    @foreach ($projects as $id => $entry)
                        <option value="{{ $id }}"
                            {{ old('project_id') == $id || $project_id == $id ? 'selected' : '' }}>{{ $entry }}
                        </option>
                    @endforeach
                </select>
                <br>
                @if ($errors->has('project'))
                    <span class="text-danger">{{ $errors->first('project') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.lead.fields.project_helper') }}</span>
            </div>
                <div class="form-group">
                    <label for="campaign_id">{{ trans('cruds.lead.fields.campaign') }}</label>
                    <br>
                    <select class="form-control select2 {{ $errors->has('campaign') ? 'is-invalid' : '' }}"
                        name="campaign_id" id="campaign_id">
                        @foreach ($campaigns as $id => $entry)
                            <option value="{{ $id }}" {{ old('campaign_id') == $id ? 'selected' : '' }}>
                                {{ $entry->campaign_name }}</option>
                        @endforeach
                    </select>
                    <br>
                    @if ($errors->has('campaign'))
                        <span class="text-danger">{{ $errors->first('campaign') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.lead.fields.campaign_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="source_id">{{ trans('messages.source') }}</label>
                    <br>
                    <select class="form-control select2 {{ $errors->has('source_id') ? 'is-invalid' : '' }}"
                        name="source_id" id="source_id" required>

                    </select>
                    <br>
                    @if ($errors->has('source_id'))
                        <span class="text-danger">{{ $errors->first('source_id') }}</span>
                    @endif
                </div>
            <div class="form-group">
                <label class="required" for="sub_source_id">Subsource</label>
                <br>
                <select class="form-control select2" name="sub_source_id" id="sub_source_id" required>
                </select>

                <br>
                @if ($errors->has('sub_source_id'))
                    <span class="text-danger">{{ $errors->first('sub_source_id') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        $(function() {
            function getCampaigns() {
                let data = {
                    project_id: $('#project_id').val()
                };

                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.get.campaigns') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#campaign_id').select2('destroy').empty().select2({
                            data: response
                        });
                        getSource();
                    }
                });
            }

            function getSource() {
                let data = {
                    project_id: $('#project_id').val(),
                    campaign_id: $('#campaign_id').val(),
                };
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.get.sources') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('#source_id').select2('destroy').empty().select2({
                            data: response
                        });
                        // After getting the source, call function to get sub-sources
                        getSubSource();
                    }
                });
            }

            function getSubSource() {
                let projectId = $('#project_id').val();
                let sourceId = $('#source_id').val();

                console.log("Fetching sub-sources for project_id:", projectId, "and source_id:",
                    sourceId); // Log the IDs

                let data = {
                    project_id: projectId,
                    source_id: sourceId
                };

                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.get.subsource') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        console.log("Sub-sources response:", response); // Log the response
                        $('#sub_source_id').select2('destroy').empty().select2({
                            data: response
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching sub-sources:", status, error);
                    }
                });
            }



            $(document).on('change', '#project_id', function() {
                getCampaigns();
                let index = $("#index_count").val(-1);
                $("div.lead_details").html('');
                // getLeadDetailsRowHtml();
            });

            $(document).on('change', '#campaign_id', function() {
                getSource();
            });

            $(document).on('change', '#source_id', function() {
                getSubSource(); // Call getSubSource when source changes
            });

            $(document).on('click', '.add_lead_detail', function() {
                let index = $("#index_count").val();
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.lead.detail.html') }}",
                    data: {
                        index: index
                    },
                    dataType: "html",
                    success: function(response) {
                        $("div.lead_details").append(response);
                        $("#index_count").val(+index + 1);
                    }
                });
            });

            $(document).on('click', '.delete_lead_detail_row', function() {
                if (confirm('Do you want to remove?')) {
                    $(this).closest('.row').remove();
                }
            });

            $(document).on('click', '.add_prefilled_lead_detail', function() {
                let index = $("#index_count").val();
                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.lead.detail.html') }}",
                    data: {
                        index: index,
                        project_id: $('#project_id').val()
                    },
                    dataType: "html",
                    success: function(response) {
                        $("div.lead_details").append(response);
                        $("#index_count").val(+index + 1);
                        $(".select-tags").select2();
                    }
                });
            });
        });
    </script>
@endsection
