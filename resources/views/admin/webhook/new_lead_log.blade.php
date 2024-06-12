@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h2>
                @lang('messages.new_lead')
            </h2>
        </div>
    </div>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label for="new-lead">
                            Api to add new lead
                        </label>
                        <input type="text" class="form-control" id="new-lead" 
                            readonly value="{{route('webhook.store.new.lead')}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>@lang('messages.log')</h4>
                </div>
                <div class="col-md-12 mb-2">
                    <form method="get" action="{{ route('admin.webhook.new.lead.log') }}" enctype="multipart/form-data">
                        <!-- Existing form fields -->
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search on new lead..." id="new_lead_response_search" value="{{$search_text ?? ''}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary search_data">@lang('messages.search')</button>
                                </div>
                            </div>
                        </div>
             
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <select name="date_range" class="form-control" id="date-range-select">
                                        <option value="">Select Date Range</option>
                                        <option value="today" @if ($selectedDateRange == 'today') selected @endif>Today</option>
                                        <option value="yesterday" @if ($selectedDateRange == 'yesterday') selected @endif>Yesterday</option>
                                        <option value="last_month" @if ($selectedDateRange == 'last_month') selected @endif>Last Month</option>
                                        <option value="this_month" @if ($selectedDateRange == 'this_month') selected @endif>This Month</option>
                                        <option value="last_year" @if ($selectedDateRange == 'last_year') selected @endif>Last Year</option>
                                        <option value="this_year" @if ($selectedDateRange == 'this_year') selected @endif>This Year</option>
                                        <option value="custom_range" @if ($selectedDateRange == 'custom_range') selected @endif>Custom Range</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-secondary search_data">Select</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Custom Date Inputs -->
                        <div id="custom-date-inputs" style="display: none;">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" id="start_date" value="{{ $startDate ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" class="form-control" id="end_date" value="{{ $endDate ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>@lang('messages.created_at')</th>
                                            <th>Event Type</th>
                                            <th>@lang('messages.webhook_response')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($new_leads_history as $new_lead)
                                            <tr>
                                                <td>{{ @format_datetime($new_lead->created_at) }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $new_lead->event_type ?? '')) }}</td>
                                                <td>
                                                    @if(!empty($new_lead->lead_event_webhook_response))
                                                        {{ json_encode($new_lead->lead_event_webhook_response) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    No log found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                @if(!empty($new_leads_history->links()))
                    <div class="col-md-12 text-right mt-3">
                        {{ $new_leads_history->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateRangeSelect = document.getElementById('date-range-select');
        const customDateInputs = document.getElementById('custom-date-inputs');

        dateRangeSelect.addEventListener('change', function () {
            if (this.value === 'custom_range') {
                customDateInputs.style.display = 'block';
            } else {
                customDateInputs.style.display = 'none';
            }
        });

        if (dateRangeSelect.value === 'custom_range') {
            customDateInputs.style.display = 'block';
        } else {
            customDateInputs.style.display = 'none';
        }
    });
</script>