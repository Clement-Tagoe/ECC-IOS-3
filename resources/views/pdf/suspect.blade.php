<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Suspect Record - {{ $suspect->name }}</title>
    <style>
        @page {
            margin: 30px 40px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #111827;
            padding-bottom: 10px;
            margin-bottom: 18px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0 0 4px 0;
            letter-spacing: 0.5px;
        }

        .header p {
            margin: 0;
            font-size: 11px;
            color: #6b7280;
        }

        .section {
            border: 1px solid #d1d5db;
            border-radius: 4px;
            margin-bottom: 16px;
            padding: 14px 16px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #374151;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e5e7eb;
        }

        table.grid {
            width: 100%;
            border-collapse: collapse;
        }

        table.grid td {
            vertical-align: top;
            padding: 6px 10px 6px 0;
            width: 33.33%;
        }

        .field-label {
            display: block;
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            color: #6b7280;
            letter-spacing: 0.3px;
            margin-bottom: 2px;
        }

        .field-value {
            display: block;
            font-size: 12px;
            color: #111827;
            word-wrap: break-word;
        }

        .field-value.empty {
            color: #9ca3af;
            font-style: italic;
        }

        .full-width {
            width: 100% !important;
        }

        .notes-box {
            margin-top: 4px;
            min-height: 40px;
        }

        .audit-table {
            width: 100%;
            border-collapse: collapse;
        }

        .audit-table td {
            vertical-align: top;
            padding: 6px 10px 6px 0;
            width: 16.66%;
        }

        .footer {
            margin-top: 24px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Suspect Record</h1>
        <p>Generated on {{ now()->format('F j, Y g:i A') }}</p>
    </div>

    {{-- Main details --}}
    <div class="section">
        <div class="section-title">Suspect Details</div>
        <table class="grid">
            <tr>
                <td>
                    <span class="field-label">Date</span>
                    <span class="field-value {{ $suspect->date ? '' : 'empty' }}">
                        {{ $suspect->date ? \Illuminate\Support\Carbon::parse($suspect->date)->format('M j, Y') : '—' }}
                    </span>
                </td>
                <td>
                    <span class="field-label">Name</span>
                    <span class="field-value {{ $suspect->name ? '' : 'empty' }}">
                        {{ $suspect->name ?: '—' }}
                    </span>
                </td>
                <td>
                    <span class="field-label">Officer in Charge</span>
                    <span class="field-value {{ $suspect->officer_in_charge ? '' : 'empty' }}">
                        {{ $suspect->officer_in_charge ?: '—' }}
                    </span>
                </td>
            </tr>
            <tr>
                
                <td>
                    <span class="field-label">Time In</span>
                    <span class="field-value {{ $suspect->time_in ? '' : 'empty' }}">
                        {{ $suspect->time_in ? \Illuminate\Support\Carbon::parse($suspect->time_in)->format('g:i A') : '—' }}
                    </span>
                </td>
                <td>
                    <span class="field-label">Time Out</span>
                    <span class="field-value {{ $suspect->time_out ? '' : 'empty' }}">
                        {{ $suspect->time_out ? \Illuminate\Support\Carbon::parse($suspect->time_out)->format('g:i A') : '—' }}
                    </span>
                </td>
                <td>
                    <span class="field-label">Time Stayed</span>
                    <span class="field-value {{ $suspect->time_stayed ? '' : 'empty' }}">
                        {{ $suspect->time_stayed ?: '—' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="1">
                    <span class="field-label">Personal Items</span>
                    <span class="field-value {{ $suspect->personal_items ? '' : 'empty' }}">
                        {!! $suspect->personal_items ?: '—' !!}
                    </span>
                </td>
                
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="3">
                    <span class="field-label">Notes</span>
                    <div class="field-value notes-box {{ $suspect->notes ? '' : 'empty' }}">
                        {{ $suspect->notes ?: '—' }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Audit trail --}}
    <div class="section">
        <div class="section-title">Audit Trail</div>
        <table class="audit-table">
            <tr>
                <td>
                    <span class="field-label">Created by</span>
                    <span class="field-value {{ optional($suspect->creator)->name ? '' : 'empty' }}">
                        {{ optional($suspect->creator)->name ?: '—' }}
                    </span>
                </td>
                <td>
                    <span class="field-label">Edited by</span>
                    <span class="field-value {{ optional($suspect->editor)->name ? '' : 'empty' }}">
                        {{ optional($suspect->editor)->name ?: '—' }}
                    </span>
                </td>
                <td>
                    <span class="field-label">Deleted by</span>
                    <span class="field-value {{ optional($suspect->destroyer)->name ? '' : 'empty' }}">
                        {{ optional($suspect->destroyer)->name ?: '—' }}
                    </span>
                </td>
                <td>
                    <span class="field-label">Created At</span>
                    <span class="field-value {{ $suspect->created_at ? '' : 'empty' }}">
                        {{ $suspect->created_at ? $suspect->created_at->format('M j, Y g:i A') : '—' }}
                    </span>
                </td>
                <td>
                    <span class="field-label">Updated At</span>
                    <span class="field-value {{ $suspect->updated_at ? '' : 'empty' }}">
                        {{ $suspect->updated_at ? $suspect->updated_at->format('M j, Y g:i A') : '—' }}
                    </span>
                </td>
                <td>
                    <span class="field-label">Deleted At</span>
                    <span class="field-value {{ $suspect->deleted_at ? '' : 'empty' }}">
                        {{ $suspect->deleted_at ? $suspect->deleted_at->format('M j, Y g:i A') : '—' }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Suspect Record #{{ $suspect->id }} &middot; Confidential
    </div>

</body>
</html>