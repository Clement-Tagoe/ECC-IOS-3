{{--
    resources/views/pdf/call-log.blade.php

    Print/PDF view mirroring App\Filament\Resources\CallLogs\Schemas\CallLogInfolist.
    Built for barryvdh/laravel-dompdf (tables/floats only — no flexbox/grid).

    Expects a $callLog variable (the CallLog model) with:
        - relations: creator, editor
        - relation: agentActivity (hasMany), each with a callStaff relation

    Example controller usage:
        $pdf = Pdf::loadView('pdf.call-log', [
            'callLog' => $callLog->load([
                'creator', 'editor',
                'agentActivity.callStaff',
            ]),
        ]);
        return $pdf->download("call-log-{$callLog->id}.pdf");

    NOTE: `status` casts to App\Enums\CallLogStatus and `shift` casts to
    App\Enums\ShiftType on the CallLog model — both badges below render the
    real enum labels/colors, matching each enum's getLabel()/getColor().
--}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Call Log {{ \Illuminate\Support\Carbon::parse($callLog->date)->format('d M Y') ?? $callLog->id }}</title>
    <style>
        @page {
            margin: 28px 32px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11px;
            color: #1f2933;
            line-height: 1.45;
        }

        h1, h2 {
            margin: 0;
            padding: 0;
        }

        /* ---------- Document header ---------- */
        .doc-header {
            width: 100%;
            border-bottom: 2px solid #1f2933;
            padding-bottom: 10px;
            margin-bottom: 18px;
        }

        .doc-header td {
            vertical-align: middle;
        }

        .doc-title {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .doc-subtitle {
            font-size: 10px;
            color: #52606d;
            margin-top: 2px;
        }

        .doc-header .generated-at {
            text-align: right;
            font-size: 9px;
            color: #7b8794;
        }

        /* ---------- Section (mirrors Filament Section::make) ---------- */
        .section {
            border: 1px solid #d9dfe4;
            border-radius: 4px;
            margin-bottom: 14px;
            page-break-inside: avoid;
        }

        .section-title {
            background-color: #f4f6f8;
            border-bottom: 1px solid #d9dfe4;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: bold;
            color: #1f2933;
        }

        .section-body {
            padding: 10px 12px;
        }

        /* ---------- Grid (mirrors Grid::make(n)) ---------- */
        .grid-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .grid-table > tr > td {
            vertical-align: top;
            padding: 0 10px 0 0;
        }

        .grid-table > tr > td:last-child {
            padding-right: 0;
        }

        /* ---------- Entry grid (mirrors Group::make(...)->columns(n)) ---------- */
        .entry-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .entry-table td {
            vertical-align: top;
            padding: 5px 10px 5px 0;
        }

        .entry-label {
            display: block;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #7b8794;
            margin-bottom: 2px;
        }

        .entry-value {
            display: block;
            font-size: 11px;
            color: #1f2933;
            word-wrap: break-word;
        }

        .entry-value.empty {
            color: #9aa5b1;
            font-style: italic;
        }

        /* ---------- Badge (mirrors ->badge()) ---------- */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 8px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            color: #ffffff;
            background-color: #6b7280; /* default/fallback */
        }

        /* Matches App\Enums\CallLogStatus::getColor() */
        .badge-in_review { background-color: #f59e0b; } /* Filament 'primary' */
        .badge-reviewed { background-color: #16a34a; }  /* Filament 'success' */

        /* Matches App\Enums\ShiftType::getColor() */
        .badge-morning { background-color: #0ea5e9; }   /* Filament 'info' */
        .badge-afternoon { background-color: #d97706; } /* Filament 'warning' */
        .badge-night { background-color: #6b7280; }      /* Filament 'gray' */

        /* ---------- Repeatable table (mirrors RepeatableEntry->table()) ---------- */
        .repeatable-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        .repeatable-table th {
            background-color: #f4f6f8;
            border: 1px solid #d9dfe4;
            padding: 5px 6px;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #52606d;
            text-align: left;
        }

        .repeatable-table td {
            border: 1px solid #d9dfe4;
            padding: 5px 6px;
            font-size: 10px;
            vertical-align: top;
        }

        .repeatable-table tbody tr:nth-child(even) {
            background-color: #fafbfc;
        }

        .repeatable-table .empty-row td {
            text-align: center;
            font-style: italic;
            color: #9aa5b1;
            padding: 10px 6px;
        }

        .footer-note {
            margin-top: 16px;
            text-align: center;
            font-size: 8.5px;
            color: #9aa5b1;
        }
    </style>
</head>
<body>

{{-- ===================== Document header ===================== --}}
<table class="doc-header">
    <tr>
        <td>
            <h1 class="doc-title">Call Log Report</h1>
            <div class="doc-subtitle">
                Date: {{ \Illuminate\Support\Carbon::parse($callLog->date)->format('d M Y') ?? '—' }}
                &nbsp;&bull;&nbsp;
                Shift: {{ ($callLog->shift instanceof \App\Enums\ShiftType ? $callLog->shift : \App\Enums\ShiftType::from($callLog->shift))->getLabel() }}
            </div>
        </td>
        <td class="generated-at">
            Generated: {{ now()->format('d M Y, h:i A') }}
        </td>
    </tr>
</table>

{{-- ===================== Section: Calls ===================== --}}
<div class="section">
    <div class="section-title">Calls</div>
    <div class="section-body">
        <table class="grid-table">
            <tr>
                <td style="width: 50%;">
                    <table class="entry-table">
                        <tr>
                            <td>@include('pdf.partials.entry', ['label' => 'Incoming Calls', 'value' => $callLog->incoming_calls])</td>
                        </tr>
                        <tr>
                            <td>@include('pdf.partials.entry', ['label' => 'Total Calls Received', 'value' => $callLog->total_calls_received])</td>
                        </tr>
                        <tr>
                            <td>@include('pdf.partials.entry', ['label' => 'Valid Calls', 'value' => $callLog->valid_calls])</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%;">
                    <table class="entry-table">
                        <tr>
                            <td>@include('pdf.partials.entry', ['label' => 'Prank Calls', 'value' => $callLog->prank_calls])</td>
                        </tr>
                        <tr>
                            <td>@include('pdf.partials.entry', ['label' => 'Unanswered Calls', 'value' => $callLog->unanswered_calls])</td>
                        </tr>
                        <tr>
                            <td>
                                @php
                                    $status = $callLog->status instanceof \App\Enums\CallLogStatus
                                        ? $callLog->status
                                        : \App\Enums\CallLogStatus::from($callLog->status);
                                @endphp
                                <span class="entry-label">Status</span>
                                <span class="entry-value">
                                    <span class="badge badge-{{ $status->value }}">
                                        {{ $status->getLabel() }}
                                    </span>
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- ===================== Section: Duty Details & Duration ===================== --}}
<div class="section">
    <div class="section-title">Duty Details &amp; Duration</div>
    <div class="section-body">
        <table class="grid-table">
            <tr>
                <td style="width: 100%;" colspan="2">
                    {{-- Group 1: columns(3), columnSpan(2) --}}
                    <table class="entry-table">
                        <tr>
                            <td style="width: 33.33%;">
                                @php
                                    $shift = $callLog->shift instanceof \App\Enums\ShiftType
                                        ? $callLog->shift
                                        : \App\Enums\ShiftType::from($callLog->shift);
                                @endphp
                                <span class="entry-label">Shift</span>
                                <span class="entry-value">
                                    <span class="badge badge-{{ $shift->value }}">
                                        {{ $shift->getLabel() }}
                                    </span>
                                </span>
                            </td>
                            <td style="width: 33.33%;">@include('pdf.partials.entry', ['label' => 'Date', 'value' =>\Illuminate\Support\Carbon::parse($callLog->date)->format('d M Y')])</td>
                            <td style="width: 33.33%;">@include('pdf.partials.entry', ['label' => 'Start Time', 'value' => \Illuminate\Support\Carbon::parse($callLog->start_time)->format('h:i A')])</td>
                        </tr>
                        <tr>
                            <td>@include('pdf.partials.entry', ['label' => 'End Time', 'value' => \Illuminate\Support\Carbon::parse($callLog->end_time)->format('h:i A')])</td>
                            <td>@include('pdf.partials.entry', ['label' => 'Created by', 'value' => optional($callLog->creator)->name])</td>
                            <td>@include('pdf.partials.entry', ['label' => 'Edited by', 'value' => optional($callLog->editor)->name])</td>
                        </tr>
                    </table>

                    {{-- Group 2: columns(3), columnSpan(2) --}}
                    <table class="entry-table" style="margin-top: 8px;">
                        <tr>
                            <td style="width: 33.33%;">@include('pdf.partials.entry', ['label' => 'Created At', 'value' => optional($callLog->created_at)->format('d M Y, h:i A')])</td>
                            <td style="width: 33.33%;">@include('pdf.partials.entry', ['label' => 'Updated At', 'value' => optional($callLog->updated_at)->format('d M Y, h:i A')])</td>
                            <td style="width: 33.33%;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- ===================== Section: Agents on Duty ===================== --}}
<div class="section">
    <div class="section-title">Agents on Duty</div>
    <div class="section-body">
        <table class="repeatable-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th style="width: 120px;">Call Taker ID</th>
                    <th style="width: 90px;">Attendance</th>
                    <th style="width: 90px;">Console ID</th>
                    <th style="width: 90px;">Incoming</th>
                    <th style="width: 90px;">Received</th>
                    <th style="width: 90px;">Unanswered</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($callLog->agentActivity as $activity)
                    <tr>
                        <td>{{ optional($activity->callStaff)->name ?? '—' }}</td>
                        <td>{{ $activity->call_taker_id ?? '—' }}</td>
                        <td>{{ $activity->attendance ?? '—' }}</td>
                        <td>{{ $activity->console_id ?? '—' }}</td>
                        <td>{{ $activity->incoming ?? '—' }}</td>
                        <td>{{ $activity->received ?? '—' }}</td>
                        <td>{{ $activity->unanswered ?? '—' }}</td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="7">No agents recorded for this shift.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="footer-note">
    This document was generated automatically and reflects the call log record at the time of export.
</div>

</body>
</html>