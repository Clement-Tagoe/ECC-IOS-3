<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Visitor Record - {{ $visitor->name }}</title>
    <style>
        @page {
            margin: 30px 35px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1f2937;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #111827;
            padding-bottom: 10px;
            margin-bottom: 16px;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
        }

        .header .title {
            font-size: 18px;
            font-weight: bold;
            color: #111827;
        }

        .header .subtitle {
            font-size: 10px;
            color: #6b7280;
        }

        .header .meta {
            text-align: right;
            font-size: 9px;
            color: #6b7280;
        }

        .section {
            border: 1px solid #d1d5db;
            border-radius: 4px;
            margin-bottom: 14px;
            padding: 12px 14px;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #374151;
            margin-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 4px;
        }

        table.grid {
            width: 100%;
            border-collapse: collapse;
        }

        table.grid td {
            width: 33.33%;
            vertical-align: top;
            padding: 6px 8px;
        }

        .field-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .field-value {
            font-size: 11px;
            color: #111827;
            font-weight: 500;
        }

        .full-width {
            width: 100% !important;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            background-color: #f3f4f6;
            color: #111827;
        }

        .audit-table {
            width: 100%;
            border-collapse: collapse;
        }

        .audit-table td {
            width: 33.33%;
            vertical-align: top;
            padding: 6px 8px;
            font-size: 10px;
        }

        .audit-table .field-label {
            font-size: 8.5px;
        }

        .footer {
            position: fixed;
            bottom: -15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="title">Visitor Record</div>
                    <div class="subtitle">Visitor Management System</div>
                </td>
                <td class="meta">
                    Generated: {{ now()->format('d M Y, h:i A') }}<br>
                    Record ID: {{ $visitor->id }}
                </td>
            </tr>
        </table>
    </div>

    {{-- Main Details --}}
    <div class="section">
        <div class="section-title">Visitor Details</div>
        <table class="grid">
            <tr>
                <td>
                    <div class="field-label">Date</div>
                    <div class="field-value">{{ \Illuminate\Support\Carbon::parse($visitor->date)->format('d M Y') }}</div>
                </td>
                <td>
                    <div class="field-label">Name</div>
                    <div class="field-value">{{ $visitor->name ?? '-' }}</div>
                </td>
                <td>
                    <div class="field-label">Contact</div>
                    <div class="field-value">{{ $visitor->contact ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="field-label">Nationality</div>
                    <div class="field-value">{{ $visitor->nationality ?? '-' }}</div>
                </td>
                <td>
                    <div class="field-label">Department</div>
                    <div class="field-value">{{ $visitor->department->name ?? '-' }}</div>
                </td>
                <td>
                    <div class="field-label">Purpose</div>
                    <div class="field-value">{{ $visitor->purpose ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="field-label">Sex</div>
                    <div class="field-value">{{ $visitor->sex ?? '-' }}</div>
                </td>
                <td>
                    <div class="field-label">Status</div>
                    <div class="field-value">
                        <span class="badge">{{ $visitor->status ?? '-' }}</span>
                    </div>
                </td>
                <td>
                    <div class="field-label">Card Number</div>
                    <div class="field-value">{{ $visitor->card_number ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="field-label">Time In</div>
                    <div class="field-value">{{ \Illuminate\Support\Carbon::parse($visitor->time_in)->format('h:i A') ?? '-' }}</div>
                </td>
                <td>
                    <div class="field-label">Time Out</div>
                    <div class="field-value">{{ \Illuminate\Support\Carbon::parse($visitor->time_out)->format('h:i A') ?? '-' }}</div>
                </td>
                <td>
                    <div class="field-label">Time Stayed</div>
                    <div class="field-value">{{ $visitor->time_stayed ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td class="full-width" colspan="3">
                    <div class="field-label">Remarks</div>
                    <div class="field-value">{{ $visitor->remarks ?? '-' }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Audit Trail --}}
    <div class="section">
        <div class="section-title">Record Activity</div>
        <table class="audit-table">
            <tr>
                <td>
                    <div class="field-label">Created by</div>
                    <div class="field-value">{{ $visitor->creator->name ?? '-' }}</div>
                </td>
                <td>
                    <div class="field-label">Edited by</div>
                    <div class="field-value">{{ $visitor->editor->name ?? '-' }}</div>
                </td>
                <td>
                    <div class="field-label">Deleted by</div>
                    <div class="field-value">{{ $visitor->destroyer->name ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="field-label">Created at</div>
                    <div class="field-value">{{ optional($visitor->created_at)->format('d M Y, h:i A') ?? '-' }}</div>
                </td>
                <td>
                    <div class="field-label">Updated at</div>
                    <div class="field-value">{{ optional($visitor->updated_at)->format('d M Y, h:i A') ?? '-' }}</div>
                </td>
                <td>
                    <div class="field-label">Deleted at</div>
                    <div class="field-value">{{ optional($visitor->deleted_at)->format('d M Y, h:i A') ?? '-' }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        This document was generated automatically and is intended for internal use only.
    </div>

</body>
</html>