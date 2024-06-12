<div class="m-3">
    <div class="card">
        @if (auth()->user()->checkPermission('lead_create'))
            <div class="card-header">
                <a class="btn btn-success float-right"
                    href="{{ route('admin.leads.create', ['project_id' => $project->id]) }}">
                    {{ trans('global.add') }} {{ trans('cruds.lead.title_singular') }}
                </a>
            </div>
        @endif
        <div class="card-body">
            <div class="table-responsive">
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
                            @foreach ($fields as $fieldGroup)
                                @foreach ($fieldGroup as $field)
                                    @if (isset($field['enabled']) &&
                                            $field['enabled'] === '1' &&
                                            $field['name_data'] !== 'Team Id' &&
                                            $field['name_data'] !== 'Sales Id')
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
                        @foreach ($leads as $lead)
                            <tr>
                                <td></td>
                                <td>{{ $lead->ref_num }}</td>
                                @foreach ($fields as $fieldType => $fieldGroup)
                                    @php
                                        $leadFields = json_decode($lead->$fieldType, true) ?? [];
                                    @endphp
                                    @foreach ($fieldGroup as $field)
                                        @if (isset($field['enabled']) &&
                                                $field['enabled'] === '1' &&
                                                $field['name_data'] !== 'Team Id' &&
                                                $field['name_data'] !== 'Sales Id')
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
                                                <td>{{ $fieldValue ? \Carbon\Carbon::parse($fieldValue)->format('h:i A') : '' }}
                                                </td>
                                            @elseif ($fieldName === 'Sell Do Date' || $fieldName === 'Lead Pickup date' || $fieldName === 'Lead Date')
                                                <td>{{ $fieldValue ? \Carbon\Carbon::parse($fieldValue)->format('Y-m-d') : '' }}
                                                </td>
                                            @else
                                                <td>{{ is_string($fieldValue) ? htmlspecialchars_decode($fieldValue) : $fieldValue }}
                                                </td>
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
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.leads.show', $lead->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endif
                                    @if (auth()->user()->checkPermission('lead_edit'))
                                        <a class="btn btn-xs btn-info"
                                            href="{{ route('admin.leads.edit', $lead->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endif
                                    @if (auth()->user()->checkPermission('lead_delete'))
                                        <form action="{{ route('admin.leads.destroy', $lead->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="{{ trans('global.delete') }}">
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
</div>
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @if (auth()->user()->checkPermission('lead_delete'))
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.leads.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endif

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
                scrollY: "300px",
                scrollCollapse: true,
                paging: false,
                fixedHeader: true
            });
            let table = $('.datatable-projectLeads:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
