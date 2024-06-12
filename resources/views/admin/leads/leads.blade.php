@extends('layouts.admin')
@section('content')

    <div class="container-fluid">
        @includeIf('admin.leads.partials.header')
    </div>

    @if ($lead_view == 'list' && count($leads) > 0)
        <div class="m-3">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Total Leads: {{ count($leads) }}</strong>
                    </div>

                    <div class="mb-3">
                        <form id="columnSelectForm">
                            @php $columnIndex = 1; @endphp
                            @php $columnIndex++; @endphp
                            @foreach ($fields as $fieldGroup)
                                @foreach ($fieldGroup as $field)
                                    @if (isset($field['enabled']) && $field['enabled'] === '1')
                                        <label>
                                            <input type="checkbox" class="column-select" data-column="{{ $columnIndex }}" checked>
                                            Created at Date
                                        </label>
                                    @endif
                                @endforeach
                            @endforeach
                        </form>
                    </div>

                    <div class="table-responsive fixed-header-table">
                        <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-Project">
                            <thead>
                                @php
                                    $lead = App\Models\Project::findOrFail($project->id);
                                    $fields = [
                                        'essential_fields' => $lead->essential_fields ?? [],
                                        'sales_fields' => $lead->sales_fields ?? [],
                                        'system_fields' => $lead->system_fields ?? [],
                                        'sell_do_fields' => $lead->sell_do_fields ?? [],
                                        'custom_fields' => $lead->custom_fields ?? [],
                                        'inbox_fields' => $lead->inbox_fields ?? [],
                                    ];
                                @endphp
                                <tr>
                                    <th></th>
                                    <th>Ref.Num</th>
                                    <th>OTP</th>

                                    @foreach ($fields as $fieldGroup)
                                        @foreach ($fieldGroup as $field)
                                            @if (isset($field['enabled']) && $field['enabled'] === '1' && $field['name_data'] !== 'Team Id' && $field['name_data'] !== 'Sales Id'&& $field['name_data'] !== 'Project Id')
                                                <th>{{ $field['name_data'] }}</th>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    <th>Created at Date</th>
                                    <th>Created at Time</th>
                                    <th>Updated at Date</th>
                                    <th>Updated at Time</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leads->sortByDesc('created_at') as $lead)
                                    <tr>
                                        <td></td>
                                        <td>{{ $lead->ref_num }}</td>
                                        <td>
                                            {{ $lead->otp_verified_or_not == 1 ? 'verified' : ($lead->otp_verified_or_not == 0 ? 'not verified' : '') }}
                                        </td>
                                        @foreach ($fields as $fieldType => $fieldGroup)
                                            @php
                                                $leadFields = json_decode($lead->$fieldType, true) ?? [];
                                            @endphp
                                            @foreach ($fieldGroup as $field)
                                                @if (isset($field['enabled']) && $field['enabled'] === '1' && $field['name_data'] !== 'Team Id' && $field['name_data'] !== 'Sales Id' && $field['name_data'] !== 'Project Id')
                                                    @php
                                                        $fieldName = $field['name_data'];
                                                        $fieldValue = $leadFields[$fieldName] ?? '';

                                                        if ($fieldName === 'Sell Do Id' && $fieldValue === null) {
                                                            $fieldValue = '';
                                                        }
                                                        if (is_array($fieldValue)) {
                                                            $fieldValue = json_encode($fieldValue);
                                                        }
                                                        if (is_null($fieldValue) || $fieldValue === '') {
                                                            $fieldValue = null;
                                                        }
                                                    @endphp
                                                    @if ($fieldName === 'Lead Pickup Time' || $fieldName === 'Sell Do Time' || $fieldName === 'Lead Time')
                                                        <td>{{ $fieldValue ? \Carbon\Carbon::parse($fieldValue)->format('h:i A') : '' }}</td>
                                                    @elseif ($fieldName === 'Sell Do Date' || $fieldName === 'Lead Pickup date' || $fieldName === 'Lead Date')
                                                        <td>{{ $fieldValue ? \Carbon\Carbon::parse($fieldValue)->format('Y-m-d') : '' }}</td>
                                                    @elseif ($fieldName === 'Notes')
                                                        @php
                                                            $notes = json_decode($fieldValue, true) ?? [];
                                                            $formattedNotes = [];
                                                            foreach ($notes as $key => $note) {
                                                                if ($note) {
                                                                    $formattedNotes[] = htmlspecialchars_decode($note);
                                                                }
                                                            }
                                                        @endphp
                                                        <td>{!! implode('<br>', $formattedNotes) !!}</td>
                                                    @else
                                                        <td>{{ is_string($fieldValue) ? htmlspecialchars_decode($fieldValue) : $fieldValue }}</td>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endforeach
                                        <td>{{ \Carbon\Carbon::parse($lead->created_at)->format('Y-m-d') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($lead->created_at)->format('h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($lead->updated_at)->format('Y-m-d') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($lead->updated_at)->format('h:i A') }}</td>
                                        <td>
                                            @if (auth()->user()->checkPermission('lead_view'))
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.leads.show', $lead->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endif
                                            @if (auth()->user()->checkPermission('lead_edit'))
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.leads.edit', $lead->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endif
                                            @if (auth()->user()->checkPermission('lead_delete'))
                                                <form action="{{ route('admin.leads.destroy', $lead->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @section('scripts')
                @parent
                <script>
                    $(function() {
                        @includeIf('admin.leads.partials.common_lead_js')

                        $('.column-select').change(function() {
                            var column = $(this).data('column');
                            var isChecked = $(this).is(':checked');
                            $('table tr').each(function() {
                                if (isChecked) {
                                    $(this).find('th:eq(' + column + '), td:eq(' + column + ')').show();
                                } else {
                                    $(this).find('th:eq(' + column + '), td:eq(' + column + ')').hide();
                                }
                            });
                        });
                    });
                </script>
            @endsection
        @else
            <p>No leads available.</p>
    @endif
@endsection

<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<style>
    .fixed-header-table {
        max-height: 500px;
        overflow-y: auto;
    }

    .fixed-header-table thead th {
        position: sticky;
        top: 0;
        background: white;
        z-index: 1000;
    }

    .fixed-header-table thead th {
        background-color: #f8f9fa;
        /* Use your desired header background color */
    }
</style>
