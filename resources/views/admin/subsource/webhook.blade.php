@extends('layouts.admin')
@section('content')
    <div class="row mb-2">
        <div class="col-sm-12">
            <h2>
                @lang('messages.configure_webhook_details')
                <small>
                    <strong>subSource:</strong>
                    <span class="text-primary">{{ $subsource->name }}</span>
                    <strong>Project:</strong>
                    <span class="text-primary">{{ optional($subsource->project)->name }}</span>
                </small>
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">
                                {{ trans('messages.receive_webhook') }}
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-default float-right" href="{{ route('admin.subsource.index') }}">
                                <i class="fas fa-chevron-left"></i>
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group webhook_div">
                                    <label for="webhook_url">
                                        {{ trans('messages.webhook_url') }}
                                    </label>
                                    <div class="input-group">
                                        <input type="text" id="webhook_url"
                                            value="{{ route('webhook.processor', ['secret' => $subsource->webhook_secret]) }}"
                                            class="form-control cursor-pointer copy_link" readonly>
                                        <div class="input-group-append cursor-pointer copy_link">
                                            <span class="input-group-text">
                                                <i class="fas fa-copy"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    @if (!empty($lead) && !empty($lead->lead_info))
                                        @php
                                            $decodedData = json_decode($lead->essential_fields, true) ?? [];
                                            $salesData = json_decode($lead->sales_fields, true) ?? [];
                                            $systemData = json_decode($lead->system_fields, true) ?? [];
                                            $sellDoData = json_decode($lead->sell_do_fields, true) ?? [];
                                            $customData = json_decode($lead->custom_fields, true) ?? [];
                                            $inboxData = json_decode($lead->inbox_fields, true) ?? [];
                                            $allData = array_merge(
                                                $decodedData,
                                                $salesData,
                                                $systemData,
                                                $sellDoData,
                                                $customData,
                                                $inboxData,
                                            );
                                        @endphp
                                        <pre>{{ json_encode($allData, JSON_PRETTY_PRINT) }}</pre>
                                    @else
                                        <p>{{ trans('messages.no_data_found') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('admin.update.email.and.phone.key') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="subsource_id" value="{{ $subsource->id }}"
                                        id="subsource_id">
                                    <div class="row">
                                        @if ($subsource->project->essential_fields ?? '')
                                            @foreach ($subsource->project->essential_fields as $key => $essentialField)
                                                @if (isset($essentialField['enabled']) && $essentialField['enabled'] === '1')
                                                    <input type="hidden"
                                                        name="essential_fields[{{ $key }}][name_data]"
                                                        value="{{ $essentialField['name_data'] }}" class="form-control"
                                                        readonly>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="name">{{ $essentialField['name_data'] }}</label><br>
                                                            <label
                                                                for="name">{{ $essentialField['name_value'] }}</label><br>
                                                            <input type="hidden"
                                                                name="essential_fields[{{ $key }}][name_value]"
                                                                value="{{ $essentialField['name_value'] }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <br>
                                                            <select class="form-control select2"
                                                                name="essential_fields[{{ $key }}][name_key]"
                                                                id="name_key">
                                                                <option value="">@lang('messages.please_select')</option>
                                                                @foreach ($existing_keys_and_values as $existing_key => $value)
                                                                    @if (metaphone($existing_key) === metaphone($essentialField['name_value']))
                                                                        <option value="{{ $existing_key }}"
                                                                            data-value="{{ $value }}" selected>
                                                                            {{ $existing_key }}: {{ $value }}
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $existing_key }}"
                                                                            data-value="{{ $value }}">
                                                                            {{ $existing_key }}: {{ $value }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if ($subsource->project->sales_fields ?? '')
                                            @foreach ($subsource->project->sales_fields as $key => $salesField)
                                                @if (isset($salesField['enabled']) && $salesField['enabled'] === '1')
                                                    <input type="hidden"
                                                        name="sales_fields[{{ $key }}][name_data]"
                                                        value="{{ $salesField['name_data'] }}" class="form-control"
                                                        readonly>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ $salesField['name_data'] }}
                                                            </label><br>
                                                            <label>
                                                                {{ $salesField['name_value'] }}
                                                            </label><br>
                                                            <input type="hidden"
                                                                name="sales_fields[{{ $key }}][name_value]"
                                                                value="{{ $salesField['name_value'] }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <br>
                                                            <select class="form-control select2"
                                                                name="sales_fields[{{ $key }}][name_key]"
                                                                id="name_key">
                                                                <option value="">@lang('messages.please_select')</option>
                                                                @foreach ($existing_keys_and_values as $existing_key)
                                                                    @if (metaphone($existing_key) === metaphone($salesField['name_value']))
                                                                        <option value="{{ $existing_key }}" selected>
                                                                            {{ $existing_key }}</option>
                                                                    @else
                                                                        <option value="{{ $existing_key }}">
                                                                            {{ $existing_key }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if ($subsource->project->system_fields ?? '')
                                            @foreach ($subsource->project->system_fields as $key => $systemField)
                                                @if (isset($systemField['enabled']) && $systemField['enabled'] === '1')
                                                    <input type="hidden"
                                                        name="system_fields[{{ $key }}][name_data]"
                                                        value="{{ $systemField['name_data'] }}" class="form-control"
                                                        readonly>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ $systemField['name_data'] }}
                                                            </label><br>
                                                            <label>
                                                                {{ $systemField['name_value'] }}
                                                            </label><br>
                                                            <input type="hidden"
                                                                name="system_fields[{{ $key }}][name_value]"
                                                                value="{{ $systemField['name_value'] }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <br>
                                                            <select class="form-control select2"
                                                                name="system_fields[{{ $key }}][name_key]"
                                                                id="name_key">
                                                                <option value="">@lang('messages.please_select')</option>
                                                                @foreach ($existing_keys_and_values as $existing_key => $value)
                                                                    @if (metaphone($existing_key) === metaphone($systemField['name_value']))
                                                                        <option value="{{ $existing_key }}"
                                                                            data-value="{{ $value }}" selected>
                                                                            {{ $existing_key }}: {{ $value }}
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $existing_key }}"
                                                                            data-value="{{ $value }}">
                                                                            {{ $existing_key }}: {{ $value }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if ($subsource->project->sell_do_fields ?? '')
                                            @foreach ($subsource->project->sell_do_fields as $key => $sellDoField)
                                                @if (isset($sellDoField['enabled']) && $sellDoField['enabled'] === '1')
                                                    <input type="hidden"
                                                        name="sell_do_fields[{{ $key }}][name_data]"
                                                        value="{{ $sellDoField['name_data'] }}" class="form-control"
                                                        readonly>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ $sellDoField['name_data'] }}
                                                            </label><br>
                                                            <label>
                                                                {{ $sellDoField['name_value'] }}
                                                            </label><br>
                                                            <input type="hidden"
                                                                name="sell_do_fields[{{ $key }}][name_value]"
                                                                value="{{ $sellDoField['name_value'] }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <br>
                                                            <select class="form-control select2"
                                                                name="sell_do_fields[{{ $key }}][name_key]"
                                                                id="name_key">
                                                                <option value="">@lang('messages.please_select')</option>
                                                                @foreach ($existing_keys as $existing_key)
                                                                    @if (metaphone($existing_key) === metaphone($sellDoField['name_value']))
                                                                        <option value="{{ $existing_key }}" selected>
                                                                            {{ $existing_key }}</option>
                                                                    @else
                                                                        <option value="{{ $existing_key }}">
                                                                            {{ $existing_key }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if ($subsource->project->custom_fields ?? '')
                                            @foreach ($subsource->project->custom_fields as $key => $customField)
                                                @if (isset($customField['enabled']) && $customField['enabled'] === '1')
                                                    <input type="hidden"
                                                        name="custom_fields[{{ $key }}][name_data]"
                                                        value="{{ $customField['name_data'] }}" class="form-control"
                                                        readonly>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ $customField['name_data'] }}
                                                            </label><br>
                                                            <label>
                                                                {{ $customField['name_value'] }}
                                                            </label><br>
                                                            <input type="hidden"
                                                                name="custom_fields[{{ $key }}][name_value]"
                                                                value="{{ $customField['name_value'] }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <br>
                                                            <select class="form-control select2"
                                                                name="custom_fields[{{ $key }}][name_key]"
                                                                id="name_key">
                                                                <option value="">@lang('messages.please_select')</option>
                                                                @foreach ($existing_keys_and_values as $existing_key => $value)
                                                                    @if (metaphone($existing_key) === metaphone($customField['name_value']))
                                                                        <option value="{{ $existing_key }}"
                                                                            data-value="{{ $value }}" selected>
                                                                            {{ $existing_key }}: {{ $value }}
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $existing_key }}"
                                                                            data-value="{{ $value }}">
                                                                            {{ $existing_key }}: {{ $value }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if ($subsource->project->inbox_fields ?? '')
                                            @foreach ($subsource->project->inbox_fields as $key => $inboxFields)
                                                @if (isset($inboxFields['enabled']) && $inboxFields['enabled'] === '1')
                                                    <input type="hidden"
                                                        name="inbox_fields[{{ $key }}][name_data]"
                                                        value="{{ $inboxFields['name_data'] }}" class="form-control"
                                                        readonly>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>
                                                                {{ $inboxFields['name_data'] }}
                                                            </label><br>
                                                            <label>
                                                                {{ $inboxFields['name_value'] }}
                                                            </label><br>
                                                            <input type="hidden"
                                                                name="inbox_fields[{{ $key }}][name_value]"
                                                                value="{{ $inboxFields['name_value'] }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <br>
                                                            <select class="form-control select2"
                                                                name="inbox_fields[{{ $key }}][name_key]"
                                                                id="name_key">
                                                                <option value="">@lang('messages.please_select')</option>
                                                                @foreach ($existing_keys_and_values as $existing_key => $value)
                                                                    @if (metaphone($existing_key) === metaphone($inboxFields['name_value']))
                                                                        <option value="{{ $existing_key }}"
                                                                            data-value="{{ $value }}" selected>
                                                                            {{ $existing_key }}: {{ $value }}
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $existing_key }}"
                                                                            data-value="{{ $value }}">
                                                                            {{ $existing_key }}: {{ $value }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    Campaign
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <br>
                                                <input type="text"
                                                    value="{{ @$subsource->source->campaign->campaign_name }}" name="system_fields[Campaign Name]"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    Project
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <br>
                                                <input type="text" value="{{ @$subsource->project->name }}" name="system_fields[Project]"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    Source
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <br>
                                                <input type="text" value="{{ @$subsource->source->name }}" name="system_fields[Source Name]"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    Sub Source
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <br>
                                                <input type="text" value="{{ @$subsource->name }}" name="system_fields[Sub Source]"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <label>
                                        <input type="checkbox" name="otp_verified_or_not" value="1"
                                            {{ $subsource->otp_verified_or_not ? 'checked' : '' }}>
                                        OTP Verified
                                    </label>

                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-outline-primary">
                                                {{ trans('messages.save') }}
                                            </button>
                                        </div>
                                    </div>


                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            $(document).on('click', '.copy_link', function() {
                copyToClipboard($("#webhook_url").val());
            });

            function copyToClipboard(text) {
                const textarea = document.createElement('textarea');
                textarea.value = text;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);

                const span = document.createElement('span');
                span.innerText = 'Link copied to clipboard!';
                $(".webhook_div").append(span);
                setTimeout(() => {
                    span.remove();
                }, 300);
            }

            $(document).on('click', '.refresh_latest_lead', function() {
                location.reload();
            });
        });
    </script>
@endsection
