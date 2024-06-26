<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
    rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
<link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
<style type="text/css">
    .cursor-pointer {
        cursor: pointer;
    }

    textarea {
        min-height: auto;
    }

    .error {
        color: #ff3d3d;
    }

    .cardd {
        border: 1px solid #ccc;
        border-radius: 25px;
        width: 200px;
        height: 200px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 35px;
        color: #000;
        box-shadow: 1px 2px 3px 4px rgba(10, 10, 10, 0.1);
    }

    .cardd-content {
        text-align: center;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }



    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
    
</style>

{{-- <style>
    .tableFixHead {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
    }

    .tableFixHead tbody {
        display: block;
        width: auto;
        overflow: auto;
        height: 510px;
    }

    .tableFixHead thead {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    .tableFixHead th,
    .tableFixHead td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: center;
        white-space: nowrap;
    }

    th {
        background: #ABDD93;
    }
</style> --}}
