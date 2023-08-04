@php
    $fields = !empty($project->webhook_fields) ? $project->webhook_fields : [];
@endphp
@forelse($fields as $field)
    @php
        $value = $lead_details[$field] ?? '';
    @endphp
    @includeIf('admin.leads.partials.lead_detail', ['key' => $field, 'value' => $value, $index = $loop->index])
@empty
    @includeIf('admin.leads.partials.lead_detail', ['key' => '', 'value' => '', $index = 0])
@endforelse