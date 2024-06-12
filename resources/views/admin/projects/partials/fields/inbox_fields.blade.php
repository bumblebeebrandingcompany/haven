<div class="form-group">
    <div class="col-md-6">
        <label for="inbox_fields">Inbox Fields</label>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="inbox_fields">Data Id</label>
            <input type="hidden" name="inbox_fields[0][name_data]" value="Data Id">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="inbox_fields[0][name_key]" id="email_value" value="data_id"
                readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="inbox_fields[0][name_value]" id="name_value"
                value="bbc_lms[lead][data_id]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="inbox_fields[0][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="inbox_fields[0][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="inbox_fields">Inbox User Id</label>
            <input type="hidden" name="inbox_fields[1][name_data]" value="Inbox User Id">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="inbox_fields[1][name_key]" id="email_value" value="user_id"
                readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="inbox_fields[1][name_value]" id="name_value"
                value="bbc_lms[lead][user_id]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="inbox_fields[1][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="inbox_fields[1][disabled]" value="0">
            </label>
        </div>
    </div>
    
    <div id="inbox-fields-container">
    </div>
</div>
