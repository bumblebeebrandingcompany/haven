// Function to generate URL with the 'view' parameter
function generateUrl(baseRoute, view) {
    return `${baseRoute}?view=${view}`;
}

// Event handler for filtering leads
$(document).on('click', '#filter_leads', function() {
    let url = generateUrl("{{ route('admin.leads.lead', [$project->id]) }}", 'kanban');
    sessionStorage.setItem("leadListUrl", url);
    window.location.href = url; // Use window.location.href for navigation
});

// Event handler for sending bulk outgoing webhooks
$(document).on('click', '#send_bulk_outgoing_webhook', function() {
    let selected_ids = [];
    
    $(".lead_ids").each(function(){
        if($(this).is(":checked")) {
            selected_ids.push($(this).val());
        }
    });

    if (selected_ids.length === 0) {
        alert('{{ trans('messages.no_leads_selected') }}')
        return;
    }

    // Assuming sendOutgoingWebhooks is a function defined elsewhere
    sendOutgoingWebhooks(selected_ids);
});
