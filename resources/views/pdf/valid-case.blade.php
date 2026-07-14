{{--
    resources/views/pdf/valid-case.blade.php

    Print/PDF view mirroring App\Filament\Resources\ValidCases\Schemas\ValidCaseInfolist.
    Built for barryvdh/laravel-dompdf (dompdf has limited CSS support, so this
    intentionally sticks to tables/floats instead of flexbox/grid).

    Expects a $record variable (the ValidCase model) with relations:
    location, region, validCaseNature, agency, creator, editor, destroyer.

    Example controller usage:
        $pdf = Pdf::loadView('pdf.valid-case', [
            'case' => $validCase->load([
                'location', 'region', 'validCaseNature', 'agency',
                'creator', 'editor', 'destroyer',
            ]),
        ]);
        return $pdf->download("case-{$validCase->case_id}.pdf");
--}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Valid Case {{ $record->case_id }}</title>
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

        /* ---------- Entry grid (mirrors ->columns(n)) ---------- */
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

        .entry-value.prose {
            /* for ->html() entries like description */
            font-size: 10.5px;
        }

        .entry-value.prose p {
            margin: 0 0 6px 0;
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

        /* Matches App\Enums\ValidCaseStatus::getColor() */
        .badge-in_review { background-color: #f59e0b; } /* Filament 'primary' */
        .badge-reviewed { background-color: #16a34a; }  /* Filament 'success' */

        /* ---------- Audit trail footer section ---------- */
        .audit-table {
            width: 100%;
            border-collapse: collapse;
        }

        .audit-table td {
            width: 33.33%;
            vertical-align: top;
            padding: 5px 10px 5px 0;
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
            <h1 class="doc-title">Valid Case Report</h1>
            <div class="doc-subtitle">Case ID: {{ $record->case_id }}</div>
        </td>
        <td class="generated-at">
            Generated: {{ now()->format('d M Y, h:i A') }}
        </td>
    </tr>
</table>

{{-- ===================== Section: Valid Case Details (3 cols) ===================== --}}
<div class="section">
    <div class="section-title">Valid Case Details</div>
    <div class="section-body">
        <table class="entry-table">
            <tr>
                <td>@include('pdf.partials.entry', ['label' => 'Case ID', 'value' => $record->case_id])</td>
                <td>@include('pdf.partials.entry', ['label' => 'Reporting Time', 'value' => \Illuminate\Support\Carbon::parse($record->reporting_time)->format('h:i A')])</td>
                <td>@include('pdf.partials.entry', ['label' => 'Reporting Date', 'value' => \Illuminate\Support\Carbon::parse($record->reporting_date)->format('d M Y')])</td>
            </tr>
            <tr>
                <td>@include('pdf.partials.entry', ['label' => 'Location', 'value' => optional($record->location)->name])</td>
                <td>@include('pdf.partials.entry', ['label' => 'Region', 'value' => optional($record->region)->name])</td>
                <td>@include('pdf.partials.entry', ['label' => 'Contact Name', 'value' => $record->contact_name])</td>
            </tr>
            <tr>
                <td>@include('pdf.partials.entry', ['label' => 'Contact Number', 'value' => $record->contact_number])</td>
                <td>@include('pdf.partials.entry', ['label' => 'Case Nature', 'value' => optional($record->validCaseNature)->name])</td>
                <td>
                    @php
                        $status = $record->status instanceof \App\Enums\ValidCaseStatus
                            ? $record->status
                            : \App\Enums\ValidCaseStatus::from($record->status);
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
    </div>
</div>

{{-- ===================== Section: Responding Agency Details (2 cols) ===================== --}}
<div class="section">
    <div class="section-title">Responding Agency Details</div>
    <div class="section-body">
        <table class="entry-table">
            <tr>
                <td>@include('pdf.partials.entry', ['label' => 'Responding Agency', 'value' => optional($record->agency)->name])</td>
                <td>@include('pdf.partials.entry', ['label' => 'Dispatched Time', 'value' => $record->dispatched_time ? \Illuminate\Support\Carbon::parse($record->dispatched_time)->format('h:i A') : null])</td>
            </tr>
            <tr>
                <td>@include('pdf.partials.entry', ['label' => 'Agency Arrival Time', 'value' => $record->agency_arrival_time ? \Illuminate\Support\Carbon::parse($record->agency_arrival_time)->format('h:i A') : null])</td>
                <td>@include('pdf.partials.entry', ['label' => 'Agency Response Time', 'value' => $record->agency_response_time ? \Illuminate\Support\Carbon::parse($record->agency_response_time)->format('h:i A') : null])</td>
            </tr>
        </table>
    </div>
</div>

{{-- ===================== Section: Description & Feedback (2 cols) ===================== --}}
<div class="section">
    <div class="section-title">Description &amp; Feedback</div>
    <div class="section-body">
        <table class="entry-table">
            <tr>
                <td style="width: 50%;">
                    <span class="entry-label">Description</span>
                    <div class="entry-value prose">
                        {!! $record->description ?: '<span class="empty">&mdash;</span>' !!}
                    </div>
                </td>
                <td style="width: 50%;">
                    @include('pdf.partials.entry', ['label' => 'Feedback Comment', 'value' => $record->feedback_comment])
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- ===================== Section: Audit Trail (no title, 2 stacked groups of 3 cols) ===================== --}}
<div class="section">
    <div class="section-body">
        <table class="audit-table">
            <tr>
                <td>@include('pdf.partials.entry', ['label' => 'Created by', 'value' => optional($record->creator)->name])</td>
                <td>@include('pdf.partials.entry', ['label' => 'Edited by', 'value' => optional($record->editor)->name])</td>
                <td>@include('pdf.partials.entry', ['label' => 'Deleted by', 'value' => optional($record->destroyer)->name])</td>
            </tr>
            <tr>
                <td>@include('pdf.partials.entry', ['label' => 'Created At', 'value' => optional($record->created_at)->format('d M Y, h:i A')])</td>
                <td>@include('pdf.partials.entry', ['label' => 'Updated At', 'value' => optional($record->updated_at)->format('d M Y, h:i A')])</td>
                <td>@include('pdf.partials.entry', ['label' => 'Deleted At', 'value' => optional($record->deleted_at)->format('d M Y, h:i A')])</td>
            </tr>
        </table>
    </div>
</div>

<div class="footer-note">
    This document was generated automatically and reflects the case record at the time of export.
</div>

</body>
</html>