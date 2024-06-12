<div class="form-group">
    <div class="col-md-6">
        <h4 for="system_fields">{{ trans('cruds.project.fields.system') }}</h4>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Project</label>
            <input type="hidden" name="system_fields[0][name_data]" value="Project Id">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[0][name_key]" id="email_value"
                value="project_name" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[0][name_value]" id="name_value"
                value="bbc_lms[lead][project_name]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[0][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[0][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Project</label>
            <input type="hidden" name="system_fields[1][name_data]" value="Project">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[1][name_key]" id="email_value"
                value="project_id" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[1][name_value]" id="name_value"
                value="bbc_lms[lead][project_id]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[1][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[1][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Campaign Name</label>
            <input type="hidden" name="system_fields[2][name_data]" value="Campaign Name">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[2][name_key]" id="email_value"
                value="campaign_name" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[2][name_value]" id="name_value"
                value="bbc_lms[lead][campaign_name]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[2][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[2][disabled]" value="0">
            </label>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Source Name</label>
            <input type="hidden" name="system_fields[3][name_data]" value="Source Name">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[3][name_key]" id="email_value"
                value="source_name" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[3][name_value]" id="name_value"
                value="bbc_lms[lead][source_name]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[3][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[3][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Sub Source</label>
            <input type="hidden" name="system_fields[4][name_data]" value="Sub Source">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[4][name_key]" id="email_value"
                value="sub_source" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[4][name_value]" id="name_value"
                value="bbc_lms[lead][sub_source]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[4][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[4][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Lead Date</label>
            <input type="hidden" name="system_fields[5][name_data]" value="Lead Date">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[5][name_key]" id="email_value"
                value="lead_date" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[5][name_value]" id="name_value"
                value="bbc_lms[lead][lead_date]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[5][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[5][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Lead Time</label>
            <input type="hidden" name="system_fields[6][name_data]" value="Lead Time">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[6][name_key]" id="email_value"
                value="lead_time" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[6][name_value]" id="name_value"
                value="bbc_lms[lead][lead_time]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[6][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[6][disabled]" value="0">
            </label>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Form id</label>
            <input type="hidden" name="system_fields[7][name_data]" value="Form id">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[7][name_key]" id="email_value"
                value="form_id" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[7][name_value]" id="name_value"
                value="bbc_lms[lead][form_id]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[7][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[7][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Form Name</label>
            <input type="hidden" name="system_fields[8][name_data]" value="Form Name">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[8][name_key]" id="email_value"
                value="form_name" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[8][name_value]" id="name_value"
                value="bbc_lms[lead][form_name]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[8][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[8][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Form Url</label>
            <input type="hidden" name="system_fields[9][name_data]" value="Form Url">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[9][name_key]" id="email_value"
                value="form_url" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[9][name_value]" id="name_value"
                value="bbc_lms[lead][form_url]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[9][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[9][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Utm Term</label>
            <input type="hidden" name="system_fields[10][name_data]" value="Utm Term">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[10][name_key]" id="email_value"
                value="utm_term" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[10][name_value]" id="name_value"
                value="bbc_lms[lead][utm_term]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[10][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[10][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Ip Address</label>
            <input type="hidden" name="system_fields[11][name_data]" value="Ip Address">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[11][name_key]" id="email_value"
                value="ip_address" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[11][name_value]" id="name_value"
                value="bbc_lms[lead][ip_address]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[11][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[11][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Device</label>
            <input type="hidden" name="system_fields[11][name_data]" value="Device">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[11][name_key]" id="email_value"
                value="device" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[11][name_value]" id="name_value"
                value="bbc_lms[lead][device]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[11][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[11][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Time Spent</label>
            <input type="hidden" name="system_fields[13][name_data]" value="Time Spent">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[13][name_key]" id="email_value"
                value="time_spent" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[13][name_value]" id="name_value"
                value="bbc_lms[lead][time_spent]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[13][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[13][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Utm Source</label>
            <input type="hidden" name="system_fields[14][name_data]" value="Utm Source">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[14][name_key]" id="email_value"
                value="utm_source" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[14][name_value]" id="name_value"
                value="bbc_lms[lead][utm_source]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[14][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[14][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Utm Medium</label>
            <input type="hidden" name="system_fields[15][name_data]" value="Utm Medium">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[15][name_key]" id="email_value"
                value="utm_medium" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[15][name_value]" id="name_value"
                value="bbc_lms[lead][utm_medium]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[15][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[15][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Utm Campaign</label>
            <input type="hidden" name="system_fields[16][name_data]" value="Utm Campaign">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[16][name_key]" id="email_value"
                value="utm_campaign" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[16][name_value]" id="name_value"
                value="bbc_lms[lead][utm_campaign]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[16][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[16][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Browser</label>
            <input type="hidden" name="system_fields[17][name_data]" value="Browser">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[17][name_key]" id="email_value"
                value="browser" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[17][name_value]" id="name_value"
                value="bbc_lms[lead][browser]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[17][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[17][disabled]" value="0">
            </label>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3">
            <label for="system_fields">Traffic Source</label>
            <input type="hidden" name="system_fields[18][name_data]" value="Traffic Source">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[18][name_key]" id="email_value"
                value="traffic_source" readonly>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="system_fields[18][name_value]" id="name_value"
                value="bbc_lms[lead][traffic_source]" readonly>
        </div>
        <div class="col-md-1">
            <label class="switch">
                <input type="checkbox" name="system_fields[18][enabled]" value="1">
                <span class="slider round"></span>
                <input type="hidden" name="system_fields[18][disabled]" value="0">
            </label>
        </div>
    </div>
</div>
<div id="system-fields-container">
</div>
