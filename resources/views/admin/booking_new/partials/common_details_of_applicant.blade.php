<div class="col-md-6">
    <div class="form-group">
        <label for="name" class="required">
            @lang('messages.name')
        </label>
        <input type="text" name="name" id="name"
            value="@if (!empty($lead) && !empty($lead->essential_fields)) {{ json_decode($lead->essential_fields)->{'Full Name'} }} @endif"
            class="form-control" readonly>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="email" class="required">
            @lang('messages.email')
        </label>
        <input type="email" name="email" id="email"
            value="@if (!empty($lead) && !empty($lead->essential_fields)) {{ json_decode($lead->essential_fields)->{'Email'} }} @endif"
            class="form-control" readonly>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="additional_email_key">
            @lang('messages.additional_email_key')
        </label>
        <input type="text" name="additional_email" id="additional_email_key"
            value="@if (!empty($lead) && !empty($lead->essential_fields)) {{ json_decode($lead->essential_fields)->{'Addl Email'} }} @endif"
            class="form-control" @if (!empty($lead) && !empty($lead->additional_email)) readonly @endif>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="phone">
            @lang('messages.phone')
        </label>
        <input type="text" name="phone" id="phone"
            value="@if (!empty($lead) && !empty($lead->essential_fields)) {{ json_decode($lead->essential_fields)->{'Phone Number'} }} @endif"
            class="form-control input_number" readonly>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="secondary_phone_key">
            @lang('messages.secondary_phone_key')
        </label>
        <input type="text" name="secondary_phone" id="secondary_phone_key"
            value="@if (!empty($lead) && !empty($lead->essential_fields)) {{ json_decode($lead->essential_fields)->{'Addl Number'} }} @endif"
            class="form-control input_number" readonly>
    </div>
</div>
<div class="col-md-6">
    <label for="remarks">Plot No</label>
    <input class="form-control {{ $errors->has('plot_no') ? 'is-invalid' : '' }}" type="text"
        name="plot_no" id="plot_no" value="{{ $plotdetail->plot_no }}" readonly>
</div>
