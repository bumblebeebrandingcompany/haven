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
            color: #ffffff;
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
            color: #ffffff;
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
            color: #ffffff;
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
            color: #ffffff;
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
            color: #ffffff;
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
            color: #ffffff;
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
            color: #ffffff;
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
            color: #ffffff;
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
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P07" onclick="display()" class="s4" dir="ltr">7</td>

<td id="P06" onclick="display()" class="s4" dir="ltr">6</td>
                    <td id="P05" onclick="display()" class="s5" dir="ltr">5</td>
                    <td id="P04" onclick="display()" class="s5" dir="ltr">4</td>
                    <td id="P03" onclick="display()" class="s5" dir="ltr">3</td>
                    <td id="P02" onclick="display()" class="s6" dir="ltr">2</td>
                    <td id="P01" class="s6" dir="ltr">1</td>
                    <td class="s7" rowspan="44"></td>
                    <td id="P174" onclick="display()" class="s5" dir="ltr">174</td>
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
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s8" colspan="7"></td>
                    <td id="P173" onclick="display()" class="s5" dir="ltr">173</td>
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
                    <td id="P08" onclick="display()" class="s6" dir="ltr" rowspan="2">8</td>
                    <td id="P09" onclick="display()" class="s5" dir="ltr" rowspan="2">9</td>
                    <td id="P10" onclick="display()" class="s4" dir="ltr" rowspan="2">10</td>
                    <td id="P11" onclick="display()" class="s4" dir="ltr" rowspan="2">11</td>
                    <td id="P12" onclick="push(10)" class="s4" dir="ltr" rowspan="2">12</td>
                    <td id="P13" onclick="display()" class="s4" dir="ltr" rowspan="2">13</td>
                    <td id="P14" onclick="display()" class="s4" dir="ltr">14</td>
                    <td id="P172" onclick="display()" class="s5" dir="ltr">172</td>
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
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s9" dir="ltr" rowspan="2">15</td>
                    <td class="s9" dir="ltr">171</td>
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
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P22" onclick="display()" class="s4" dir="ltr" rowspan="2">22</td>
                    <td id="P21" onclick="display()" class="s5" dir="ltr" rowspan="2">21</td>
                    <td id="P20" onclick="display()" class="s5" dir="ltr" rowspan="2">20</td>
                    <td id="P19" onclick="display()" class="s4" dir="ltr" rowspan="2">19</td>
                    <td id="P18" onclick="display()" class="s4" dir="ltr" rowspan="2">18</td>
                    <td id="P17" onclick="display()" class="s5" dir="ltr" rowspan="2">17</td>
                    <td id="P170" onclick="display()" class="s9" dir="ltr">170</td>
                    <td id="P168" onclick="display()" class="s4" dir="ltr" rowspan="2">168</td>
                    <td id="P167" onclick="display()" class="s4" dir="ltr" rowspan="2">167</td>
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
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P16" onclick="display()" class="s9" dir="ltr">16</td>
                    <td id="P169" onclick="display()" class="s9" dir="ltr">169</td>
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
                    <td class="s3"></td>
                    <td id="P23" onclick="display()" class="s4" dir="ltr">23</td>
                    <td id="P24" onclick="display()" class="s5" dir="ltr">24</td>
                    <td id="P25" onclick="display()" class="s6" dir="ltr">25</td>
                    <td id="P26" onclick="display()" class="s9" dir="ltr">26</td>
                    <td id="P27" onclick="display()" class="s10" dir="ltr">27</td>

<td id="P28" onclick="display()" class="s11" dir="ltr">28</td>
                    <td id="P29" onclick="display()" class="s9" dir="ltr">29</td>
                    <td id="P30" onclick="display()" class="s4" dir="ltr">30</td>
                    <td id="P160" onclick="display()" class="s4" dir="ltr">160</td>
                    <td id="P161" onclick="display()" class="s9" dir="ltr">161</td>
                    <td id="P162" onclick="display()" class="s9" dir="ltr">162</td>
                    <td id="P163" onclick="display()" class="s5" dir="ltr">163</td>
                    <td id="P164" onclick="display()" class="s9" dir="ltr">164</td>
                    <td id="P165" onclick="display()" class="s5" dir="ltr">165</td>
                    <td id="P166" onclick="display()" class="s4" dir="ltr">166</td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R12" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">13</div>
                    </th>
                    <td class="s3"></td>
                    <td id="P38" onclick="display()" class="s4" dir="ltr">38</td>
                    <td id="P37" onclick="display()" class="s4" dir="ltr">37</td>
                    <td id="P36" onclick="display()" class="s4" dir="ltr">36</td>
                    <td id="P35" onclick="display()" class="s4" dir="ltr">35</td>
                    <td id="P34" onclick="display()" class="s5" dir="ltr">34</td>
                    <td id="P33" onclick="display()" class="s4" dir="ltr">33</td>
                    <td id="P32" onclick="display()" class="s5" dir="ltr">32</td>
                    <td id="P31" onclick="display()" class="s9" dir="ltr">31</td>
                    <td id="P159" onclick="display()" class="s9" dir="ltr">159</td>
                    <td id="P158" onclick="display()" class="s5" dir="ltr">158</td>
                    <td id="P157" onclick="display()" class="s5" dir="ltr">157</td>
                    <td id="P156" onclick="display()" class="s4" dir="ltr">156</td>
                    <td id="P155" onclick="display()" class="s4" dir="ltr">155</td>
                    <td id="P154" onclick="display()" class="s4" dir="ltr">154</td>
                    <td id="P153" onclick="display()" class="s4" dir="ltr">153</td>
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
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P39" onclick="display()" class="s4" dir="ltr" rowspan="2">39</td>

<td id="P40" onclick="display()" class="s4" dir="ltr" rowspan="2">40</td>
                    <td id="P41" onclick="display()" class="s9" dir="ltr">41</td>
                    <td id="P146" onclick="display()" class="s9" dir="ltr">146</td>
                    <td id="P147" onclick="display()" class="s4" dir="ltr" rowspan="2">147</td>
                    <td id="P148" onclick="display()" class="s5" dir="ltr" rowspan="2">148</td>
                    <td id="P149" onclick="display()" class="s4" dir="ltr" rowspan="2">149</td>
                    <td id="P150" onclick="display()" class="s4" dir="ltr" rowspan="2">150</td>
                    <td id="P151" onclick="display()" class="s5" dir="ltr" rowspan="2">151</td>
                    <td id="P152" onclick="display()" class="s4" dir="ltr" rowspan="2">152</td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R16" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">17</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P42" onclick="display()" class="s12" dir="ltr" rowspan="2">42</td>
                    <td id="P145" onclick="display()" class="s4" dir="ltr" rowspan="2">145</td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R17" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">18</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P45" onclick="display()" class="s4" dir="ltr" rowspan="2">45</td>
                    <td id="P44" onclick="display()" class="s4" dir="ltr" rowspan="2">44</td>
                    <td id="P143" onclick="display()" class="s4" dir="ltr" rowspan="2">143</td>
                    <td id="P142" onclick="display()" class="s4" dir="ltr" rowspan="2">142</td>
                    <td id="P141" onclick="display()" class="s4" dir="ltr" rowspan="2">141</td>
                    <td id="P140" onclick="display()" class="s4" dir="ltr" rowspan="2">140</td>
                    <td id="P139" onclick="display()" class="s4" dir="ltr" rowspan="2">139</td>
                    <td id="P138" onclick="display()" class="s4" dir="ltr" rowspan="2">138</td>
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
                    <td id="P43" onclick="display()" class="s13" dir="ltr">43</td>
                    <td id="P144" onclick="display()" class="s4" dir="ltr">144</td>
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
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P46" onclick="display()" class="s4" dir="ltr" rowspan="2">46</td>
                    <td id="P47" onclick="display()" class="s4" dir="ltr" rowspan="2">47</td>
                    <td id="P48" onclick="display()" class="s4" dir="ltr" rowspan="2">48</td>
                    <td id="P49" onclick="display()" class="s9" dir="ltr">49</td>
                    <td id="P132" onclick="display()" class="s9" dir="ltr">132</td>
                    <td id="P133" onclick="display()" class="s4" dir="ltr" rowspan="2">133</td>
                    <td id="P134" onclick="display()" class="s4" dir="ltr" rowspan="2">134</td>
                    <td id="P135" onclick="display()" class="s4" dir="ltr" rowspan="2">135</td>
                    <td id="P136" onclick="display()" class="s5" dir="ltr" rowspan="2">136</td>
                    <td id="P137" onclick="display()" class="s4" dir="ltr" rowspan="2">137</td>
                    <td class="s1" rowspan="2"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R22" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">23</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P50" onclick="display()" class="s9" dir="ltr" rowspan="2">50</td>
                    <td id="P131" onclick="display()" class="s6" dir="ltr" rowspan="2">131</td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R23" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">24</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P54" onclick="display()" class="s4" dir="ltr" rowspan="2">54</td>
                    <td id="P53" onclick="display()" class="s6" dir="ltr" rowspan="2">53</td>
                    <td id="P52" onclick="display()" class="s6" dir="ltr" rowspan="2">52</td>
                    <td id="P129" onclick="display()" class="s5" dir="ltr" rowspan="2">129</td>
                    <td id="P128" onclick="display()" class="s4" dir="ltr" rowspan="2">128</td>
                    <td id="P127" onclick="display()" class="s4" dir="ltr" rowspan="2">127</td>
                    <td id="P126" onclick="display()" class="s5" dir="ltr" rowspan="2">126</td>

<td id="P125" onclick="display()" class="s4" dir="ltr" rowspan="2">125</td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R24" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">25</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P51" onclick="display()" class="s5" dir="ltr">51</td>
                    <td id="P130" onclick="display()" class="s5" dir="ltr">130</td>
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
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P55" onclick="display()" class="s9" dir="ltr">55</td>
                    <td id="P78" onclick="display()" class="s4" dir="ltr">78</td>
                    <td id="P79" onclick="display()" class="s4" dir="ltr">79</td>
                    <td class="s7" rowspan="21"></td>
                    <td id="P124" onclick="display()" class="s4" dir="ltr">124</td>
                    <td id="P120" onclick="display()" class="s4" dir="ltr" rowspan="4">120</td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R28" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">29</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P56" onclick="display()" class="s5" dir="ltr">56</td>

<td id="P77" onclick="display()" class="s4" dir="ltr">77</td>
                    <td id="P80" onclick="display()" class="s9" dir="ltr">80</td>
                    <td id="P123" onclick="display()" class="s4" dir="ltr">123</td>
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
                    <td id="P57" onclick="display()" class="s4" dir="ltr">57</td>
                    <td id="P76" onclick="display()" class="s5" dir="ltr">76</td>
                    <td id="P81" onclick="display()"class="s4" dir="ltr">81</td>
                    <td id="P122" onclick="display()"class="s4" dir="ltr">122</td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R30" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">31</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P58" onclick="display()" class="s4" dir="ltr">58</td>
                    <td id="P75" onclick="display()"class="s5" dir="ltr">75</td>
                    <td id="P82" onclick="display()" class="s5" dir="ltr">82</td>
                    <td id="P121" onclick="display()"class="s4" dir="ltr">121</td>
                    <td class="s0"></td>
                    <td class="s0"></td>
                    <td class="s4"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R31" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">32</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P59" onclick="display()" class="s6" dir="ltr">59</td>
                    <td id="P74" onclick="display()" class="s5" dir="ltr">74</td>
                    <td id="P83" onclick="display()"class="s4" dir="ltr">83</td>
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
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>

<td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s0"></td>
                    <td class="s4"></td>
                    <td id="P60" onclick="display()" class="s4" dir="ltr">60</td>
                    <td id="P73" onclick="display()" class="s5" dir="ltr">73</td>
                    <td id="P84" onclick="display()" class="s5" dir="ltr">84</td>
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
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s4"></td>
                    <td id="P176" onclick="display()" class="s5" dir="ltr">176</td>
                    <td id="P175" onclick="display()" class="s5" dir="ltr">175</td>
                    <td id="P61" onclick="display()" class="s4" dir="ltr">61</td>
                    <td id="P72" onclick="display()" class="s5" dir="ltr">72</td>
                    <td id="P85" onclick="display()" class="s5" dir="ltr">85</td>
                    <td id="P115" onclick="display()" class="s4" dir="ltr">115</td>
                    <td id="P116" onclick="display()" class="s4" dir="ltr" rowspan="2">116</td>
                    <td id="P117" onclick="display()" class="s4" dir="ltr" rowspan="2">117</td>
                    <td id="P118" onclick="display()" class="s4" dir="ltr" rowspan="2">118</td>
                    <td id="P119" onclick="display()" class="s4" dir="ltr" rowspan="2">119</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R34" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">35</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td id="P71" onclick="display()" class="s5" dir="ltr">71</td>
                    <td id="P86" onclick="display()" class="s5" dir="ltr">86</td>
                    <td class="s4" dir="ltr" rowspan="2">114</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R35" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">36</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td id="P70" onclick="display()" class="s4" dir="ltr">70</td>
                    <td id="P87" onclick="display()" class="s4" dir="ltr">87</td>
                    <td id="P112" onclick="display()" class="s4" dir="ltr" rowspan="2">112</td>
                    <td id="P111" onclick="display()" class="s4" dir="ltr" rowspan="2">111</td>
                    <td id="P110" onclick="display()" class="s4" dir="ltr" rowspan="2">110</td>

<td id="P109" onclick="display()" class="s4" dir="ltr" rowspan="2">109</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R36" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">37</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P177" onclick="display()" class="s5" dir="ltr">177</td>
                    <td id="P178" onclick="display()" class="s5" dir="ltr">178</td>
                    <td id="P179" onclick="display()" class="s6" dir="ltr">179</td>
                    <td id="P62" onclick="display()" class="s5" dir="ltr">62</td>
                    <td id="P69" onclick="display()" class="s4" dir="ltr">69</td>
                    <td id="P88" onclick="display()" class="s5" dir="ltr">88</td>
                    <td id="P113" onclick="display()" class="s4" dir="ltr">113</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R37" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">38</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s4"></td>
                    <td id="P182" onclick="display()" class="s4" dir="ltr">182</td>
                    <td id="P181" onclick="display()" class="s4" dir="ltr">181</td>
                    <td id="P180" onclick="display()" class="s5" dir="ltr">180</td>
                    <td id="P63" onclick="display()" class="s5" dir="ltr">63</td>
                    <td id="P68" onclick="display()" class="s4" dir="ltr">68</td>
                    <td id="P89" onclick="display()" class="s6" dir="ltr">89</td>
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
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td class="s14"></td>
                    <td id="P67" onclick="display()" class="s4" dir="ltr">67</td>
                    <td id="P90" onclick="display()" class="s5" dir="ltr">90</td>
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
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s14"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s14"></td>

<td class="s8"></td>
                    <td id="P66" onclick="display()" class="s4" dir="ltr">66</td>
                    <td id="P91" onclick="display()" class="s4" dir="ltr">91</td>
                    <td id="P104" onclick="display()" class="s6" dir="ltr">104</td>
                    <td id="P105" onclick="display()" class="s4" dir="ltr" rowspan="2">105</td>
                    <td id="P106" onclick="display()" class="s4" dir="ltr" rowspan="2">106</td>
                    <td id="P107" onclick="display()" class="s4" dir="ltr" rowspan="2">107</td>
                    <td id="P108" onclick="display()" class="s4" dir="ltr" rowspan="2">108</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R40" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">41</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="P183" onclick="display()" class="s4" dir="ltr">183</td>
                    <td id="P206" onclick="display()" class="s9" dir="ltr">206</td>
                    <td class="s15"></td>
                    <td id="P207" onclick="display()" class="s5" dir="ltr">207</td>
                    <td id="P65" onclick="display()" class="s4" dir="ltr">65</td>
                    <td id="P92" onclick="display()" class="s5" dir="ltr">92</td>
                    <td id="P103" onclick="display()" class="s4" dir="ltr" rowspan="2">103</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R41" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">42</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="P184" onclick="display()" class="s4" dir="ltr">184</td>
                    <td id="P205" onclick="display()" class="s9" dir="ltr">205</td>
                    <td class="s15"></td>
                    <td id="P208" onclick="display()" class="s4" dir="ltr">208</td>
                    <td id="P64" onclick="display()" class="s4" dir="ltr">64</td>
                    <td id="P93" onclick="display()" class="s4" dir="ltr">93</td>
                    <td id="P101" onclick="display()" class="s4" dir="ltr" rowspan="2">101</td>
                    <td id="P100" onclick="display()" class="s4" dir="ltr" rowspan="2">100</td>
                    <td id="P99" onclick="display()" class="s4" dir="ltr" rowspan="2">99</td>
                    <td id="P98" onclick="display()" class="s4" dir="ltr" rowspan="2">98</td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R42" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">43</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="P185" onclick="display()" class="s5" dir="ltr">185</td>
                    <td id="P204" onclick="display()" class="s5" dir="ltr">204</td>
                    <td class="s15"></td>
                    <td id="P209" onclick="display()" class="s4" dir="ltr">209</td>
                    <td class="s16"></td>
                    <td class="s17"></td>
                    <td class="s4" dir="ltr">102</td>
                    <td class="s1"></td>
                </tr>

<tr style="height: 20px">
                    <th id="0R43" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">44</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="P186" onclick="display()" class="s5" dir="ltr">186</td>
                    <td id="P203" onclick="display()" class="s4" dir="ltr">203</td>
                    <td class="s15"></td>
                    <td id="P210" onclick="display()" class="s4" dir="ltr">210</td>
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
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="P187" onclick="display()" class="s4" dir="ltr">187</td>
                    <td id="P202" onclick="display()" class="s6" dir="ltr">202</td>
                    <td class="s15"></td>
                    <td id="P211" onclick="display()" class="s4" dir="ltr">211</td>
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
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="P188" onclick="display()" class="s4" dir="ltr">188</td>
                    <td id="P201" onclick="display()" class="s5" dir="ltr">201</td>
                    <td class="s15"></td>
                    <td class="s3" dir="ltr"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P95" onclick="display()" class="s4" dir="ltr">95</td>
                    <td id="P96" onclick="display()" class="s4" dir="ltr">96</td>
                    <td id="P97" onclick="display()" class="s4" dir="ltr">97</td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s1"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R46" style="height: 20px" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px">47</div>
                    </th>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="P189" onclick="display()" class="s4" dir="ltr">189</td>
                    <td id="P200" onclick="display()" class="s5" dir="ltr">200</td>
                    <td class="s15"></td>
                    <td class="s3"></td>

<td class="s1"></td>
                    <td class="s3"></td>
                    <td id="P94" onclick="display()" class="s4" dir="ltr">94</td>
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
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="P190" onclick="display()" class="s4" dir="ltr">190</td>
                    <td id="P199" onclick="display()" class="s5" dir="ltr">199</td>
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
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="P191" onclick="display()" class="s4" dir="ltr">191</td>
                    <td id="P198" onclick="display()" class="s5" dir="ltr">198</td>
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
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="P192" onclick="display()" class="s4" dir="ltr">192</td>
                    <td id="P197" onclick="display()" class="s4" dir="ltr">197</td>
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
                    <td class="s18" dir="ltr"></td>
                    <td class="s1"></td>

<td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s15"></td>
                    <td id="P193" onclick="display()" class="s4" dir="ltr">193</td>
                    <td id="P196" onclick="display()" class="s4" dir="ltr">196</td>
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
                    <td class="s19" dir="ltr"></td>
                    <td class="s1"></td>
                    <td class="s1"></td>
                    <td class="s3"></td>
                    <td class="s7"></td>
                    <td id="P194" onclick="display()" class="s5" dir="ltr">194</td>
                    <td id="P195" onclick="display()" class="s4" dir="ltr">195</td>
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
                    <td class="s25 softmerge" dir="ltr">
                        <div class="softmerge-inner" style="width: 298px; left: -1px">
                            (included in Premier booked)
                        </div>
                    </td>
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
        function push(value) {
            // Send an AJAX request to your Laravel backend
            $.ajax({
                url: '{{ route("admin.booking.plots", ":plotdetails") }}'.replace(':plotdetails', value),
                method: 'GET',
                success: function(response) {
                    $('body').html(response);
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle errors if any
                    console.error(error);
                }
            });
        }
    </script>
    
@endsection