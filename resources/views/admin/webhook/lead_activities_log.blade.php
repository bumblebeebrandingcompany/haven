@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2>@lang('messages.lead_activities')</h2>
            </div>
        </div>
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="lead-activity">Api to add lead activity</label>
                            <input type="text" class="form-control" id="lead-activity" readonly
                                value="{{ route('webhook.store.lead.activity') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>@lang('messages.log')</h4>
                    </div>
                    <div class="col-md-12 mb-2">
                        <form method="get" action="{{ route('admin.webhook.lead.activities.log') }}"
                            enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search on lead activities..."
                                                id="lead_activities_response_search" value="{{ $search_text ?? '' }}">
                                            <div class="input-group-append">
                                                <button type="submit"
                                                    class="btn btn-secondary search_data">@lang('messages.search')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select name="event_type" class="form-control">
                                                <option value="">All Events</option>
                                                @foreach ($eventTypes as $eventType)
                                                    <option value="{{ $eventType }}"
                                                        @if ($eventType == $selectedEventType) selected @endif>
                                                        {{ ucfirst(str_replace('_', ' ', $eventType)) }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-secondary search_data">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select name="date_range" class="form-control" id="date-range-select">
                                                <option value="">Select Date Range</option>
                                                <option value="today" @if ($selectedDateRange == 'today') selected @endif>
                                                    Today</option>
                                                <option value="yesterday" @if ($selectedDateRange == 'yesterday') selected @endif>
                                                    Yesterday</option>
                                                <option value="last_month"
                                                    @if ($selectedDateRange == 'last_month') selected @endif>Last Month</option>
                                                <option value="this_month"
                                                    @if ($selectedDateRange == 'this_month') selected @endif>This Month</option>
                                                <option value="last_year" @if ($selectedDateRange == 'last_year') selected @endif>
                                                    Last Year</option>
                                                <option value="this_year" @if ($selectedDateRange == 'this_year') selected @endif>
                                                    This Year</option>
                                                <option value="custom_range"
                                                    @if ($selectedDateRange == 'custom_range') selected @endif>Custom Range</option>
                                            </select>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-secondary search_data">Select</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-2 custom-range" style="display:none;">
                                    <!-- Custom range start date input -->
                                    <div class="form-group">
                                        <label for="start_date">Start Date:</label>
                                        <input type="date" name="start_date" class="form-control" id="start-date-input">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2 custom-range" style="display:none;">
                                    <!-- Custom range end date input -->
                                    <div class="form-group">
                                        <label for="end_date">End Date:</label>
                                        <input type="date" name="end_date" class="form-control" id="end-date-input">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.created_at')</th>
                                        <th>@lang('messages.event_type')</th>
                                        <th>@lang('messages.webhook_response')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leads_activities_history as $lead_activity)
                                        <tr>
                                            <td>{{ @format_datetime($lead_activity->created_at) }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $lead_activity->event_type)) }}</td>
                                            <td data-toggle="modal" data-target="#webhookModal{{ $loop->index }}">

                                                @if (!empty($lead_activity->webhook_data))
                                                    <pre>{{ json_encode($lead_activity->webhook_data) }}</pre>
                                                @endif
                                                <div class="modal fade" id="webhookModal{{ $loop->index }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="webhookModalLabel{{ $loop->index }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="webhookModalLabel{{ $loop->index }}">Webhook Data
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if (!empty($lead_activity->webhook_data))
                                                                    <pre>{{ json_encode($lead_activity->webhook_data, JSON_PRETTY_PRINT) }}</pre>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if (!empty($leads_activities_history->links()))
                        <div class="col-md-12 text-right mt-3">
                            {{ $leads_activities_history->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Function to toggle custom range inputs
            function toggleCustomRange() {
                var selectedValue = $('#date-range-select').val();
                if (selectedValue === 'custom_range') {
                    $('.custom-range').show();
                } else {
                    $('.custom-range').hide();
                }
            }

            // Initial call to toggle custom range based on selected value
            toggleCustomRange();

            // Event listener for change in date range select
            $('#date-range-select').change(function() {
                toggleCustomRange();
            });
        });
    </script>
@endpush
<!-- Button to trigger modal -->


<!-- Modal -->
