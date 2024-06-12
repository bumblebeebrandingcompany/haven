@extends('layouts.admin')
@section('content')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link type="text/css" rel="stylesheet" href="resources/sheet.css">
    <style type="text/css">
        .ritz .waffle a {
            color: inherit;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .ritz .waffle .s25 {
            border-right: none;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s2 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 25pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s10 {
            border-bottom: 1px SOLID #000000;
            border-right: 3px SOLID #0000ff;
            background-color: #ff0000;
            text-align: center;
            font-weight: bold;
            color: ##000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s20 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s30 {
            border-bottom: 1px SOLID #000000;
            border-right: 3px SOLID #0000ff;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s1 {
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s9 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ff0000;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s7 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #b7b7b7;
            text-align: center;
            color: #000000;
            font-weight: bold;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s17 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: bottom;
            font-weight: bold;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s27 {
            border-left: none;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            font-weight: bold;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s4 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-weight: bold;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s5 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #d9ead3;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s19 {
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s31 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 13pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s14 {
            background-color: #b7b7b7;
            text-align: center;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s16 {
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s24 {
            border-bottom: 1px SOLID #0000ff;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 13pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s26 {
            border-left: none;
            border-right: none;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s22 {
            border-bottom: 3px SOLID #ff6d01;
            border-right: 1px SOLID #000000;
            background-color: #38761d;
            text-align: center;
            font-weight: bold;
            color: ##000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s18 {
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s21 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 13pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s15 {
            border-right: 1px SOLID #000000;
            background-color: #b7b7b7;
            text-align: center;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s6 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #38761d;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s8 {
            border-bottom: 1px SOLID #000000;
            background-color: #b7b7b7;
            text-align: center;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s29 {
            border-bottom: 3px SOLID #0000ff;
            border-right: 1px SOLID #000000;
            background-color: #ff0000;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s23 {
            border-bottom: 1px SOLID #0000ff;
            border-right: 3px SOLID #ff6d01;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s3 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s28 {
            border-bottom: 1px SOLID #0000ff;
            border-right: 1px SOLID #0000ff;
            background-color: #d9d9d9;
            text-align: left;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s12 {
            border-bottom: 3px SOLID #ff6d01;
            border-right: 1px SOLID #000000;
            background-color: #ff0000;
            text-align: center;
            font-weight: bold;
            color: ##000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s13 {
            border-bottom: 3px SOLID #ff6d01;
            border-right: 3px SOLID #ff6d01;
            background-color: #38761d;
            text-align: center;
            font-weight: bold;
            color: ##000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s0 {
            border-bottom: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s11 {
            border-bottom: 3px SOLID #0000ff;
            border-right: 3px SOLID #0000ff;
            background-color: #ff0000;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: "docs-Nunito", Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }
    </style>
    <div class="ritz grid-container" dir="ltr">
        <table class="waffle no-grid" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="row-header freezebar-origin-ltr"></th>
                    <th id="0C0" style="width: 198px" class="column-headers-background">

                    </th>
                    <th id="0C1" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C2" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C3" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C4" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C5" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C6" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C7" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C8" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C9" style="width: 86px" class="column-headers-background">

                    </th>
                    <th id="0C10" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C11" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C12" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C13" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C14" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C15" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C16" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C17" style="width: 100px" class="column-headers-background">

                    </th>
                    <th id="0C18" style="width: 100px" class="column-headers-background">

                    </th>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 20px">
                    <th id="0R0" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">1</div>
                    </th>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R1" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">2</div>
                    </th>
                    <td class="s2" dir="ltr" colspan="18">
                        Aztec Premier vs Merlom Layout
                    </td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R2" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">3</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R3" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">4</div>
                    </th>
                    @php
                        $plotNo = ['P1', 'P2', 'P3', 'P4', 'P5', 'P6', 'P7', 'P174'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp

                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id='{{ $plotNo[6] }}' onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) ?? '4' }}" class="s4"
                        dir="ltr">{{ $plotdetails[6]->plot_no }}</td>
                    <td id='{{ $plotNo[5] }}' onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}" class="s4"
                        dir="ltr">{{ $plotdetails[5]->plot_no }}</td>
                    <td id='{{ $plotNo[4] }}' onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}" class="s5"
                        dir="ltr">{{ $plotdetails[4]->plot_no }}</td>
                    <td id='{{ $plotNo[3] }}' onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}" class="s5"
                        dir="ltr">{{ $plotdetails[3]->plot_no }}</td>
                    <td id='{{ $plotNo[2] }}' onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}" class="s5"
                        dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td id='{{ $plotNo[1] }}' onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" class="s6"
                        dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id='{{ $plotNo[0] }}' onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s6"
                        dir="ltr">{{ $plotdetails[0]->plot_no }}</td>

                    <td class="s7" rowspan="44"></td>
                    <td id='{{ $plotNo[7] }}' onclick="push({{ $plotdetails[7]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[7]->status_id) ?? '4' }}" class="s5"
                        dir="ltr">{{ $plotdetails[7]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 39px">
                    <th id="0R4" style="height: 39px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 39px">5</div>
                    </th>
                    @php
                        $plotNo = ['P173'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s8" colspan="7"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s5"
                        dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R5" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">6</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    @php
                        $plotNo = ['P8', 'P9', 'P10', 'P11', 'P12', 'P13', 'P14', 'P172'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp

                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) }}" class="s6"
                        dir="ltr" rowspan="2">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}"onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) }}" class="s5"
                        dir="ltr" rowspan="2">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) }}" class="s5"
                        dir="ltr" rowspan="2">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[6] }}" onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[6]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) }}" class="s4"
                        dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[7] }}" onclick="push({{ $plotdetails[7]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[7]->status_id) }}" class="s5"
                        dir="ltr">
                        {{ $plotdetails[7]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R6" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">7</div>
                    </th>
                    @php
                        $plotNo = ['P15', 'P171'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s9" id='{{ $plotNo[0] }}' onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" dir="ltr"
                        rowspan="2">{{ $plotdetails[0]->plot_no }}</td>
                    <td class="s9" id='{{ $plotNo[1] }}' onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" dir="ltr">
                        {{ $plotdetails[1]->plot_no }}</td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R7" style="height: 20px" class="row-headers-background">

                        <div class="row-header-wrapper" style="line-height: 20px">8</div>
                    </th>
                    @php
                        $plotNo = ['P17', 'P18', 'P19', 'P20', 'P21', 'P22', 'P167', 'P168', 'P170'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp

                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}" class="s5"
                        dir="ltr" rowspan="2">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}" class="s5"
                        dir="ltr" rowspan="2">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s5"
                        dir="ltr" rowspan="2">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[8] }}" onclick="push({{ $plotdetails[8]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[8]->status_id) ?? '4' }}" class="s9"
                        dir="ltr">{{ $plotdetails[8]->plot_no }}</td>
                    <td id="{{ $plotNo[7] }}" onclick="push({{ $plotdetails[7]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[7]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[7]->plot_no }}</td>
                    <td id="{{ $plotNo[6] }}" onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[6]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>

                <tr style="height: 20px">
                    <th id="0R8" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">9</div>
                    </th>
                    @php
                        $plotNo = ['P16', 'P169'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P16"id='{{ $plotNo[0] }}' onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s9"
                        dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="P169"id='{{ $plotNo[1] }}' onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" class="s9"
                        dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R9" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">10</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s8" colspan="7" rowspan="2"></td>
                    <td class="s7" colspan="3" rowspan="2"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R10" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">11</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s4"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R11" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">12</div>
                    </th>
                    @php
                        $plotNo = [
                            'P30',
                            'P160',
                            'P23',
                            'P24',
                            'P25',
                            'P26',
                            'P27',
                            'P28',
                            'P29',
                            'P161',
                            'P162',
                            'P163',
                            'P164',
                            'P165',
                            'P166',
                        ];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s3"></td>

                    <td id='{{ $plotNo[2] }}' onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}" class="s4"
                        dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td id='{{ $plotNo[3] }}' onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}" class="s5"
                        dir="ltr">{{ $plotdetails[3]->plot_no }}</td>
                    <td id='{{ $plotNo[4] }}' onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}" class="s6"
                        dir="ltr">{{ $plotdetails[4]->plot_no }}</td>
                    <td id='{{ $plotNo[5] }}' onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}" class="s9"
                        dir="ltr">{{ $plotdetails[5]->plot_no }}</td>
                    <td id='{{ $plotNo[6] }}' onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) ?? '4' }}" class="s10"
                        dir="ltr">{{ $plotdetails[6]->plot_no }}</td>
                    <td id='{{ $plotNo[7] }}' onclick="push({{ $plotdetails[7]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[7]->status_id) ?? '4' }}" class="s11"
                        dir="ltr">{{ $plotdetails[7]->plot_no }}</td>
                    <td id='{{ $plotNo[8] }}' onclick="push({{ $plotdetails[8]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[8]->status_id) ?? '4' }}" class="s9"
                        dir="ltr">{{ $plotdetails[8]->plot_no }}</td>
                    <td id='{{ $plotNo[0] }}' onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s4"
                        dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id='{{ $plotNo[1] }}' onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" class="s4"
                        dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id='{{ $plotNo[9] }}' onclick="push({{ $plotdetails[9]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[9]->status_id) ?? '4' }}" class="s9"
                        dir="ltr">{{ $plotdetails[9]->plot_no }}</td>
                    <td id='{{ $plotNo[10] }}' onclick="push({{ $plotdetails[10]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[10]->status_id) ?? '4' }}"
                        class="s9" dir="ltr">{{ $plotdetails[10]->plot_no }}</td>
                    <td id='{{ $plotNo[11] }}' onclick="push({{ $plotdetails[11]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[11]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[11]->plot_no }}</td>
                    <td id='{{ $plotNo[12] }}' onclick="push({{ $plotdetails[12]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[12]->status_id) ?? '4' }}"
                        class="s9" dir="ltr">{{ $plotdetails[12]->plot_no }}</td>
                    <td id='{{ $plotNo[13] }}' onclick="push({{ $plotdetails[13]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[13]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[13]->plot_no }}</td>
                    <td id='{{ $plotNo[14] }}' onclick="push({{ $plotdetails[14]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[14]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[14]->plot_no }}</td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R12" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">13</div>
                    </th>
                    @php
                        $plotNo = [
                            'P31',
                            'P159',
                            'P32',
                            'P33',
                            'P34',
                            'P35',
                            'P36',
                            'P37',
                            'P38',
                            'P153',
                            'P154',
                            'P155',
                            'P156',
                            'P157',
                            'P158',
                        ];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp

                    <td class="s3"></td>
                    <td id='{{ $plotNo[8] }}' onclick="push({{ $plotdetails[8]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[8]->status_id) ?? '4' }}" class="s4"
                        dir="ltr">{{ $plotdetails[8]->plot_no }}</td>
                    <td id='{{ $plotNo[7] }}' onclick="push({{ $plotdetails[7]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[7]->status_id) ?? '4' }}" class="s4"
                        dir="ltr">{{ $plotdetails[7]->plot_no }}</td>
                    <td id='{{ $plotNo[6] }}' onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) ?? '4' }}" class="s4"
                        dir="ltr">{{ $plotdetails[6]->plot_no }}</td>
                    <td id='{{ $plotNo[5] }}' onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}" class="s4"
                        dir="ltr">{{ $plotdetails[5]->plot_no }}</td>
                    <td id='{{ $plotNo[4] }}' onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}" class="s5"
                        dir="ltr">{{ $plotdetails[4]->plot_no }}</td>
                    <td id='{{ $plotNo[3] }}' onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}" class="s4"
                        dir="ltr">{{ $plotdetails[3]->plot_no }}</td>
                    <td id='{{ $plotNo[2] }}' onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}" class="s5"
                        dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td id='{{ $plotNo[0] }}' onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s9"
                        dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id='{{ $plotNo[1] }}' onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" class="s9"
                        dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id='{{ $plotNo[14] }}' onclick="push({{ $plotdetails[14]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[14]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[14]->plot_no }}</td>
                    <td id='{{ $plotNo[13] }}' onclick="push({{ $plotdetails[13]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[13]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[13]->plot_no }}</td>
                    <td id='{{ $plotNo[12] }}' onclick="push({{ $plotdetails[12]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[12]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[12]->plot_no }}</td>
                    <td id='{{ $plotNo[11] }}' onclick="push({{ $plotdetails[11]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[11]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[11]->plot_no }}</td>
                    <td id='{{ $plotNo[10] }}' onclick="push({{ $plotdetails[10]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[10]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[10]->plot_no }}</td>
                    <td id='{{ $plotNo[9] }}' onclick="push({{ $plotdetails[9]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[9]->status_id) ?? '4' }}" class="s4"
                        dir="ltr">{{ $plotdetails[9]->plot_no }}</td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R13" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">14</div>
                    </th>
                    <td class="s3"></td>
                    <td class="s8" colspan="8" rowspan="2"></td>
                    <td class="s7" colspan="7" rowspan="2"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R14" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">15</div>
                    </th>
                    <td class="s3"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R15" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">16</div>
                    </th>
                    @php
                        $plotNo = ['P40', 'P146', 'P41', 'P147', 'P148', 'P149', 'P150', 'P151', 'P152', 'P39'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>

                    <td id="{{ $plotNo[9] }}" onclick="push({{ $plotdetails[9]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[9]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[9]->plot_no }}</td>

                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s9"
                        dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" class="s9"
                        dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}" class="s5"
                        dir="ltr" rowspan="2">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[6] }}" onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[6]->plot_no }}</td>
                    <td id="{{ $plotNo[7] }}" onclick="push({{ $plotdetails[7]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[7]->status_id) ?? '4' }}" class="s5"
                        dir="ltr" rowspan="2">{{ $plotdetails[7]->plot_no }}</td>
                    <td id="{{ $plotNo[8] }}" onclick="push({{ $plotdetails[8]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[8]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[8]->plot_no }}</td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R16" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">17</div>
                    </th>
                    @php
                        $plotNo = ['P42', 'P145'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>

                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s12"
                        dir="ltr" rowspan="2">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R17" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">18</div>
                    </th>
                    @php
                        $plotNo = ['P44', 'P138', 'P139', 'P140', 'P141', 'P142', 'P143', 'P45'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>

                    <td id="{{ $plotNo[7] }}" onclick="push({{ $plotdetails[7]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[7]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[7]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[6] }}" onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[6]->plot_no }}</td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R18" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">19</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s4"></td>
                    @php
                        $plotNo = ['P43', 'P144'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s13"
                        dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" class="s4"
                        dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R19" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">20</div>
                    </th>

                    <td class="s3"></td>
                    <td class="s8" colspan="8" rowspan="2"></td>
                    <td class="s7" colspan="7" rowspan="2"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R20" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">21</div>
                    </th>
                    <td class="s3"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R21" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">22</div>
                    </th>
                    @php
                        $plotNo = ['P49', 'P132', 'P47', 'P48', 'P133', 'P134', 'P135', 'P136', 'P137', 'P46'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="{{ $plotNo[9] }}" onclick="push({{ $plotdetails[9]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[9]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[9]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s9"
                        dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" class="s9"
                        dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[6] }}" onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[6]->plot_no }}</td>
                    <td id="{{ $plotNo[7] }}" onclick="push({{ $plotdetails[7]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[7]->status_id) ?? '4' }}" class="s5"
                        dir="ltr" rowspan="2">{{ $plotdetails[7]->plot_no }}</td>
                    <td id="{{ $plotNo[8] }}" onclick="push({{ $plotdetails[8]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[8]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[8]->plot_no }}</td>
                    <td class="s1" rowspan="2"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R22" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">23</div>
                    </th>
                    @php
                        $plotNo = ['P50', 'P131'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s9"
                        dir="ltr" rowspan="2">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" class="s6"
                        dir="ltr" rowspan="2">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R23" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">24</div>
                    </th>
                    @php
                        $plotNo = ['P52', 'P53', 'P125', 'P126', 'P127', 'P128', 'P129', 'P54'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="{{ $plotNo[7] }}" onclick="push({{ $plotdetails[7]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[7]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[7]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}" class="s6"
                        dir="ltr" rowspan="2">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s6"
                        dir="ltr" rowspan="2">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[6] }}" onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) ?? '4' }}" class="s5"
                        dir="ltr" rowspan="2">{{ $plotdetails[6]->plot_no }}</td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}" class="s5"
                        dir="ltr" rowspan="2">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}" class="s4"
                        dir="ltr" rowspan="2">{{ $plotdetails[2]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R24" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">25</div>
                    </th>
                    @php
                        $plotNo = ['P51', 'P130'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}" class="s5"
                        dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s0"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R25" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">26</div>
                    </th>

                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s8" rowspan="4"></td>
                    <td class="s8" colspan="3" rowspan="2"></td>
                    <td class="s7" colspan="7" rowspan="2"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R26" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">27</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R27" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">28</div>
                    </th>
                    @php
                        $plotNo = ['P55', 'P78', 'P79', 'P124', 'P120'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s9" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td class="s7" rowspan="21"></td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="4">{{ $plotdetails[4]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R28" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">29</div>
                    </th>
                    @php
                        $plotNo = ['P56', 'P80', 'P77', 'P123'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s9" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[3]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R29" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">30</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    @php
                        $plotNo = ['P57', 'P81', 'P76', 'P122'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"class="s4"
                        dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"class="s4"
                        dir="ltr">{{ $plotdetails[3]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R30" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">31</div>
                    </th>
                    @php
                        $plotNo = ['P121', 'P58', 'P82', 'P75'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"class="s5"
                        dir="ltr">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"class="s4"
                        dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s4"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R31" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">32</div>
                    </th>
                    @php
                        $plotNo = ['P59', 'P83', 'P74'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s6" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"class="s4"
                        dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s15"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R32" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">33</div>
                    </th>
                    @php
                        $plotNo = ['P60', 'P84', 'P73'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>

                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s0"></td>
                    <td class="s4"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s7"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R33" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">34</div>
                    </th>
                    @php
                        $plotNo = ['P61', 'P115', 'P85', 'P116', 'P117', 'P118', 'P119','P175','P176','P72'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s4"></td>
                    <td id="{{ $plotNo[8] }}" onclick="push({{ $plotdetails[8]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[8]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[8]->plot_no }}</td>
                    <td id="{{ $plotNo[7] }}" onclick="push({{ $plotdetails[7]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[7]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[7]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[9] }}" onclick="push({{ $plotdetails[9]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[9]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[9]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[6] }}" onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[6]->plot_no }}</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R34" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">35</div>
                    </th>
                    @php
                        $plotNo = [  'P86','P71','P114'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td class="s4" id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        dir="ltr" rowspan="2">{{ $plotdetails[2]->plot_no }}</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R35" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">36</div>
                    </th>
                    @php
                        $plotNo = [ 'P87', 'P109', 'P110', 'P111', 'P112','P70'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[2]->plot_no }}</td>

                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R36" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">37</div>
                    </th>
                    @php
                        $plotNo = ['P62', 'P113', 'P88', 'P177', 'P178', 'P179', 'P69'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}"
                        class="s6" dir="ltr">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[6] }}" onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[6]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R37" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">38</div>
                    </th>
                    @php
                        $plotNo = ['P63', 'P89', 'P180', 'P181','P182','P68'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s4"></td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s6" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s15"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R38" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">39</div>
                    </th>
                    @php
                        $plotNo = [ 'P90','P67'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s7"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R39" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">40</div>
                    </th>
                    @php
                        $plotNo = ['P104', 'P91',  'P105', 'P106','P107','P66','P108'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s14"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s14"></td>

                    <td class="s8"></td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s6" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[6] }}" onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[6]->plot_no }}</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R40" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">41</div>
                    </th>
                    @php
                        $plotNo = ['P183', 'P206', 'P207', 'P92', 'P65', 'P103'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s9" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[5]->plot_no }}</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R41" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">42</div>
                    </th>
                    @php
                        $plotNo = ['P93','P184', 'P205', 'P98', 'P99', 'P100',  'P101', 'P64', 'P208'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s9" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[8] }}" onclick="push({{ $plotdetails[8]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[8]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[8]->plot_no }}</td>
                    <td id="{{ $plotNo[7] }}" onclick="push({{ $plotdetails[7]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[7]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[7]->plot_no }}</td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[6] }}" onclick="push({{ $plotdetails[6]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[6]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[6]->plot_no }}</td>
                    <td id="{{ $plotNo[5] }}" onclick="push({{ $plotdetails[5]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[5]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[5]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[4]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"
                        class="s4" dir="ltr" rowspan="2">{{ $plotdetails[3]->plot_no }}</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R42" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">43</div>
                    </th>
                    @php
                        $plotNo = [ 'P102','P185', 'P204', 'P209'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[3]->plot_no }}</td>
                    <td class="s16"></td>
                    <td class="s17"></td>
                    <td class="s4"id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td class="s1"></td>
                </tr>

                <tr style="height: 20px">
                    <th id="0R43" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">44</div>
                    </th>
                    @php
                        $plotNo = ['P186', 'P203', 'P210'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s15"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R44" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">45</div>
                    </th>
                    @php
                        $plotNo = ['P187', 'P202', 'P211'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s6" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s7"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R45" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">46</div>
                    </th>
                    @php
                        $plotNo = [ 'P95','P188', 'P201', 'P96', 'P97'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td class="s15"></td>
                    <td class="s3" dir="ltr"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[3] }}" onclick="push({{ $plotdetails[3]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[3]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[3]->plot_no }}</td>
                    <td id="{{ $plotNo[4] }}" onclick="push({{ $plotdetails[4]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[4]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[4]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R46" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">47</div>
                    </th>
                    @php
                        $plotNo = ['P189', 'P200', 'P94'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s15"></td>
                    <td class="s3"></td>

                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="{{ $plotNo[2] }}" onclick="push({{ $plotdetails[2]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[2]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[2]->plot_no }}</td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R47" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">48</div>
                    </th>
                    @php
                        $plotNo = ['P190', 'P199'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s15"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s16"></td>
                    <td class="s16"></td>
                    <td class="s16"></td>
                    <td class="s16"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R48" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">49</div>
                    </th>
                    @php
                        $plotNo = ['P191', 'P198'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s15"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R49" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">50</div>
                    </th>
                    @php
                        $plotNo = ['P192', 'P197'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s15"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R50" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">51</div>
                    </th>
                    @php
                        $plotNo = ['P193', 'P196'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s18" dir="ltr"></td>
                    <td class="s1"></td>

                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s15"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R51" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">52</div>
                    </th>
                    @php
                        $plotNo = ['P194', 'P195'];
                        $plotdetails = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->get();
                        if (!function_exists('getStatusColor')) {
                            function getStatusColor($status_id)
                            {
                                switch ($status_id) {
                                    case 1:
                                        return 'red';
                                    case 2:
                                        return 'blue';
                                    case 3:
                                        return 'green';
                                    case 4:
                                        return 'yellow';
                                    default:
                                        return 'transparent';
                                }
                            }
                        }

                        $plotdetail = App\Models\PlotDetail::whereIn('plot_id', $plotNo)->first();
                    @endphp
                    <td class="s19" dir="ltr"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s7"></td>
                    <td id="{{ $plotNo[0] }}" onclick="push({{ $plotdetails[0]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[0]->status_id) ?? '4' }}"
                        class="s5" dir="ltr">{{ $plotdetails[0]->plot_no }}</td>
                    <td id="{{ $plotNo[1] }}" onclick="push({{ $plotdetails[1]->id }})"
                        style="background-color: {{ getStatusColor($plotdetails[1]->status_id) ?? '4' }}"
                        class="s4" dir="ltr">{{ $plotdetails[1]->plot_no }}</td>
                    <td class="s7"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R52" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">53</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R53" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">54</div>
                    </th>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">

                    <th id="0R54" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">55</div>
                    </th>
                    <td class="s20" dir="ltr">Premier - Blocked</td>
                    <td class="s5" dir="ltr"></td>
                    <td class="s21">54</td>
                    <td class="s1"></td>
                    <td class="s1" dir="ltr"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R55" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">56</div>
                    </th>
                    <td class="s20" dir="ltr">Premier - Booked</td>
                    <td class="s22" dir="ltr"></td>
                    <td class="s21">13</td>
                    <td class="s1"></td>
                    <td class="s1" dir="ltr"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R56" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">57</div>
                    </th>
                    <td class="s23" dir="ltr">Disputed - Plot 43</td>
                    <td class="s13" dir="ltr"></td>
                    <td class="s24">1</td>
                    {{-- <td class="s25 softmerge" dir="ltr">
                        <div class="softmerge-inner" style="width: 298px; left: -1px">
                            (included in Premier booked)
                        </div>
                    </td> --}}
                    <td class="s26"></td>
                    <td class="s27"></td>
                    <td class="s27"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R57" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">58</div>
                    </th>
                    <td class="s28" dir="ltr" colspan="3"></td>
                    <td class="s19" dir="ltr"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>

                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R58" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">59</div>
                    </th>
                    <td class="s20" dir="ltr">Merlom - Booked</td>
                    <td class="s29" dir="ltr"></td>
                    <td class="s21">23</td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R59" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">60</div>
                    </th>
                    <td class="s30" dir="ltr">Merlom - Registered</td>
                    <td class="s11" dir="ltr"></td>
                    <td class="s31">1</td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s4"></td>
                    <td class="s1"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="popup" class="popup">
        <p>Plot No: 45</p>
        <button onclick="option1()">Option 1</button>
        <button onclick="option2()">Option 2</button>
    </div>
    <script>
        // Function to handle popstate event
        window.onpopstate = function(event) {
            // Reload the original content if it's not already loaded
            if (event.state && event.state.originalContent) {
                $('body').html(event.state.originalContent);
            }
        };

        function push(value) {
            $.ajax({
                url: '{{ route('admin.booking.plots', ':plotdetails') }}'.replace(':plotdetails', value),
                method: 'GET',
                success: function(response) {
                    $('body').html(response);
                    console.log(response);
                    // Update the URL using pushState
                    history.pushState({
                        originalContent: response
                    }, '', '{{ route('admin.booking.plots', ':plotdetails') }}'.replace(
                        ':plotdetails',
                        value));
                },
                error: function(xhr, status, error) {
                    // Handle errors if any
                    console.error(error);
                }
            });
        }
    </script>
@endsection
