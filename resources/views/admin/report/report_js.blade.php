    if ($(".date_range").length) {
    @if (isset($fetchFilteredData['start_date']) &&
            isset($fetchFilteredData['end_date']) &&
            !empty($fetchFilteredData['start_date']) &&
            !empty($fetchFilteredData['end_date']))
        const startDate = moment("{{ $fetchFilteredData['start_date'] }}") || moment().subtract(29, 'days');
        const endDate = moment("{{ $fetchFilteredData['end_date'] }}") || moment();
    @else
        const startDate = moment().subtract(6, 'months'); // Updated to last 6 months
        const endDate = moment();
    @endif
    $('.date_range').daterangepicker({
    startDate: startDate,
    endDate: endDate,
    ranges: {
    'Today': [moment(), moment()],
    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    'Last 60 Days': [moment().subtract(59, 'days'), moment()],
    'Last 6 Months': [moment().subtract(6, 'months'), moment()],
    'This Month': [moment().startOf('month'), moment().endOf('month')],
    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,'month').endOf('month')]
    },
    locale: {
    cancelLabel: 'Clear'
    },
    // Event handler for when date range changes
    // This will trigger the update of the pie chart
    apply: function(event, picker) {
    var startDate = picker.startDate.format('YYYY-MM-DD');
    var endDate = picker.endDate.format('YYYY-MM-DD');
    updatePieChart(startDate, endDate);
    }
    });
    }
    // Assuming you have the dynamic lead counts for campaigns
    var campaignLeads = <?php echo json_encode($campaignLeads); ?>;
    var campaignLabels = <?php echo json_encode($campaignLabels); ?>;

    var ctxPie = document.getElementById('campaignPieChart').getContext('2d');
    // Predefined dark colors
    var darkColors = [
    'rgba(255, 234, 136, 1)', // Dark Blue
    'rgba(255, 129, 83, 1)', // Dark Red
    'rgba(74, 202, 180, 1)', // Dark Magenta
    'rgba(135, 139, 182, 1)' // Yellow (added color)
    // Add more dark colors as needed
    ];

    var darkBorderColors = [
    'rgba(0, 0, 139, 1)', // Dark Blue
    'rgba(139, 0, 0, 1)', // Dark Red
    'rgba(139, 0, 139, 1)', // Dark Magenta
    'rgba(0, 100, 0, 1)'
    // Add more dark colors as needed
    ];

    // Pie Chart
    var pieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
    labels: campaignLabels,
    datasets: [{
    data: campaignLeads,
    backgroundColor: darkColors,
    borderColor: darkBorderColors,
    borderWidth: 0.5,
    barThickness: 20
    }]
    },
    options: {
    tooltips: {
    enabled: false // Disable tooltips
    },
    plugins: {
    datalabels: {
    formatter: function(value, context) {
    return value;
    },
    color: '#fff',
    anchor: 'end',
    align: 'start'
    }
    }
    }
    });
    // Function to update pie chart based on date range
    function updatePieChart(startDate, endDate) {
    // Perform an AJAX request to fetch filtered data based on the date range
    $.ajax({
    url: 'your_endpoint_to_fetch_filtered_data',
    method: 'GET',
    data: {
    startDate: startDate,
    endDate: endDate
    },
    success: function(response) {
    // Assuming response contains updated campaignLeads data
    pieChart.data.datasets[0].data = response.campaignLeads;
    pieChart.update(); // Update the chart with new data
    },
    error: function(xhr, status, error) {
    console.error('Error fetching filtered data:', error);
    }
    });
    }

    // Initial pie chart setup
    var pieChart = new Chart(ctxPie, {
    // Your existing configuration
    });
