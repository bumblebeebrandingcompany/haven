@php
    $sellDoFields = json_decode($lead->sell_do_fields, true);
@endphp

<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center position-relative">
            @php
                $avatar = 'https://ui-avatars.com/api/?background=random&font-size=0.7&name=' . $lead->name;
            @endphp
            <div class="hotness-badge position-absolute bg-danger circle text-white d-flex align-items-center justify-content-center"
                style="top: -1px; left: calc(55% - 15px); z-index: 1;">
                <span>{{ $sellDoFields['Hotness'] ?? 'N/A' }}</span>
            </div>
            <img class="profile-user-img img-fluid img-circle" src="{{ $avatar }}" alt="{{ $lead->name ?? '' }}">
        </div>
        @php
            $essentialFields = json_decode($lead->essential_fields, true);
            $sellDoFields = json_decode($lead->sell_do_fields, true);
        @endphp
        </br>
        </br>


        <ul class="list-group list-group-flush">
            <div class="row">
                @foreach ($essentialFields as $key => $value)
                    <div class="col-4">
                        <b>{{ ucfirst($key) }}</b><br>
                        <span>{{ is_string($value) ? htmlspecialchars($value) : '-' }}</span>

                    </div>
                @endforeach
            </div>
            </br>

            <div class="row">
                <b>Sell Do Fields:</b>
                <div class="row">
                    @foreach ($sellDoFields as $key => $value)
                        <div class="col-4">
                            <b>{{ ucfirst($key) }}</b><br>
                            @if ($key === 'Sell Do Id')
                                <span>{{ $value }}</span>
                            @elseif ($key === 'Sell Do Date')
                                <span>{{ \Carbon\Carbon::parse($value)->format('Y-m-d') }}</span>
                            @elseif ($key === 'Sell Do Time')
                                <span>{{ \Carbon\Carbon::parse($value)->format('h:i A') }}</span>
                            @else
                                <span>{{ is_string($value) ? htmlspecialchars($value) : '-' }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>

            </div>
        </ul>
    </div>
</div>
@php
    $systemFields = json_decode($lead->system_fields, true);
@endphp

@if (!empty($systemFields))
    @if (isset($systemFields['Project']) || isset($systemFields['Lead Date']))
        <!-- Single entry for system fields -->
        <div class="card">
            <div class="card-header">
                System Fields
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            @foreach ($systemFields as $key => $value)
                                @if (!in_array($key, ['Project Id', 'Form id', 'Form Name', 'Form Url']))
                                    <div class="col-4">
                                        <b>{{ ucfirst($key) }}</b><br>
                                        @if ($key === 'Lead Date')
                                            <span>{{ \Carbon\Carbon::parse($value)->format('Y-m-d') }}</span>
                                        @elseif ($key === 'Lead Time')
                                            <span>{{ \Carbon\Carbon::parse($value)->format('h:i A') }}</span>
                                        @else
                                            <span>{{ is_string($value) ? htmlspecialchars($value) : '-' }}</span>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Campaign Responses
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            @foreach ($systemFields as $key => $value)
                                <div class="col-4">
                                    <b>{{ ucfirst($key) }}</b><br>
                                    @if ($key === 'Lead Date')
                                        <span>{{ \Carbon\Carbon::parse($value)->format('Y-m-d') }}</span>
                                    @elseif ($key === 'Lead Time')
                                        <span>{{ \Carbon\Carbon::parse($value)->format('h:i A') }}</span>
                                    @else
                                        <span>{{ is_string($value) ? htmlspecialchars($value) : '-' }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header">
                Intrested Projects
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach ($systemFields as $fields)
                        <li class="list-group-item">
                            <div class="row">
                                @foreach ($fields as $key => $value)
                                    @if (!in_array($key, ['Campaign Name', 'Source Name', 'Sub Source']))
                                        <div class="col-4">
                                            <b>{{ ucfirst($key) }}</b><br>
                                            @if ($key === 'Lead Date')
                                                <span>{{ \Carbon\Carbon::parse($value)->format('Y-m-d') }}</span>
                                            @elseif ($key === 'Lead Time')
                                                <span>{{ \Carbon\Carbon::parse($value)->format('h:i A') }}</span>
                                            @else
                                                <span>{{ is_string($value) ? htmlspecialchars($value) : '-' }}</span>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Campaign Responses
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach ($systemFields as $fields)
                        <li class="list-group-item">
                            <div class="row">
                                @foreach ($fields as $key => $value)
                                    <div class="col-4">
                                        <b>{{ ucfirst($key) }}</b><br>
                                        @if ($key === 'Lead Date')
                                            <span>{{ \Carbon\Carbon::parse($value)->format('Y-m-d') }}</span>
                                        @elseif ($key === 'Lead Time')
                                            <span>{{ \Carbon\Carbon::parse($value)->format('h:i A') }}</span>
                                        @else
                                        <span>{{ is_string($value) ? htmlspecialchars($value) : '-' }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

@endif
