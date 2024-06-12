<div class="m-3">
    <div class="card">
        <h3>Sub Source</h3>
        <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-projectSubSource">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>{{ trans('cruds.source.fields.campaign') }}</th>
                    <th>Source Name</th>
                    <th>Sub Source Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td>
                        @if (empty($__global_clients_filter))
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach ($campaigns as $key => $item)
                                    <option value="{{ $item->campaign_name }}">{{ $item->campaign_name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach ($project->subSources as $subSource)
                    <tr>
                        <td></td>
                        <td>{{ $subSource->source->campaign->campaign_name ?? '' }}</td>
                        <td>{{ $subSource->source->name ?? '' }}</td>
                        <td>{{ $subSource->name }}</td>
                        <td>
                            <div class="d-flex flex-wrap">
                                <div class="form-group mr-1 mb-1">
                                    <a href="{{ route('admin.subsource.show', $subSource->id) }}"
                                        class="btn btn-primary btn-sm mb-1">
                                        View
                                    </a>
                                </div>
                            </div>
                            <div class="form-group mr-1 mb-1">
                                <a href="{{ route('admin.subsource.edit', $subSource->id) }}"
                                    class="btn btn-info btn-sm mb-1">
                                    Edit
                                </a>
                            </div>

                            <div class="form-group mr-1 mb-1">
                                <a href="{{ route('admin.subsource.webhook', $subSource->id) }}"
                                    class="btn btn-info btn-sm mb-1">
                                    Incoming Webhook
                                </a>
                            </div>
                            <div class="form-group mr-1 mb-1">
                                <button type="button" class="btn btn-danger btn-sm mb-1" data-toggle="modal"
                                    data-target="#deleteModal_{{ $subSource->id }}">
                                    Delete
                                </button>
                                <div class="modal fade" id="deleteModal_{{ $subSource->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteModalLabel_{{ $subSource->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="deleteModalLabel_{{ $subSource->id }}">Confirm
                                                    Deletion
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this item?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                                <!-- Form to handle the actual deletion -->
                                                <form {{-- action="{{ route('admin.walkinform.destroy', $walkin->id) }}" --}} method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
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