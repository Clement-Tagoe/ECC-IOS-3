<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Monitoring Task #{{ $monitoringTask->id }}</title>
    <style>
        @page {
            margin: 90px 40px 70px 40px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11px;
            color: #1f2937;
            line-height: 1.5;
        }

        header {
            position: fixed;
            top: -70px;
            left: 0;
            right: 0;
            height: 60px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 8px;
        }

        header .company {
            font-size: 14px;
            font-weight: bold;
            color: #111827;
        }

        header .meta {
            float: right;
            text-align: right;
            font-size: 9px;
            color: #6b7280;
        }

        footer {
            position: fixed;
            bottom: -55px;
            left: 0;
            right: 0;
            height: 40px;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
        }

        .page-number:before {
            content: counter(page);
        }

        h1.doc-title {
            font-size: 20px;
            margin: 0 0 4px 0;
            color: #111827;
        }

        .subtitle {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 18px;
        }

        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Status badges — MonitoringTaskStatus */
        .badge-status-in_review { background-color: #e0e7ff; color: #4338ca; }
        .badge-status-reviewed  { background-color: #dcfce7; color: #15803d; }

        /* Shift badges — ShiftType */
        .badge-shift-morning   { background-color: #dbeafe; color: #1d4ed8; }
        .badge-shift-afternoon { background-color: #fef3c7; color: #b45309; }
        .badge-shift-night     { background-color: #f3f4f6; color: #4b5563; }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        table.details-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.details-table td {
            padding: 6px 8px;
            vertical-align: top;
            width: 33.33%;
        }

        .field-label {
            display: block;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #9ca3af;
            margin-bottom: 2px;
        }

        .field-value {
            font-size: 11px;
            color: #111827;
        }

        .field-value.placeholder {
            color: #9ca3af;
            font-style: italic;
        }

        .content-box {
            font-size: 11px;
            color: #1f2937;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 10px 12px;
        }
        .content-box p { margin: 0 0 8px 0; }
        .content-box p:last-child { margin-bottom: 0; }

        /* Image gallery */
        table.image-gallery {
            width: 100%;
            border-collapse: collapse;
        }
        table.image-gallery td {
            width: 33.33%;
            height: 140px;
            padding: 4px;
            text-align: center;
            vertical-align: top;
        }
        table.image-gallery img {
            max-width: 100%;
            max-height: 130px;
            width: auto;
            height: auto;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
        }
        .image-caption {
            font-size: 8px;
            color: #6b7280;
            margin-top: 3px;
            word-wrap: break-word;
        }

        .empty-note {
            font-size: 10px;
            color: #9ca3af;
            font-style: italic;
        }

        .avoid-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

    <header>
        <div class="company">{{ config('app.name') }}</div>
        <div class="meta">
            Generated {{ now()->format('M d, Y \a\t g:i A') }}<br>
            Monitoring Task #{{ $monitoringTask->id }}
        </div>
    </header>

    <footer>
        {{ config('app.name') }} &mdash; Confidential &mdash; Page <span class="page-number"></span>
    </footer>

    <h1 class="doc-title">Monitoring Task Report</h1>
    <div class="subtitle">
        {{ \Illuminate\Support\Carbon::parse($monitoringTask->date)->format('F j, Y') }}
        &bull; {{ \Illuminate\Support\Carbon::parse($monitoringTask->time)->format('g:i A') }}
        &bull; {{ $monitoringTask->location?->name ?? 'No location' }}
    </div>

    {{-- ============ MONITORING TASK DETAILS ============ --}}
    <div class="section avoid-break">
        <div class="section-title">Monitoring Task Details</div>

        <table class="details-table">
            <tr>
                <td>
                    <span class="field-label">Date</span>
                    <span class="field-value">{{ \Illuminate\Support\Carbon::parse($monitoringTask->date)->format('F j, Y') }}</span>
                </td>
                <td>
                    <span class="field-label">Time</span>
                    <span class="field-value">{{ \Illuminate\Support\Carbon::parse($monitoringTask->time)->format('g:i A') }}</span>
                </td>
                <td>
                    <span class="field-label">Shift</span>
                    <span class="field-value">{{ $monitoringTask->shift?->getLabel() }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Status</span>
                    <span class="badge badge-status-{{ $monitoringTask->status->value }}">
                        {{ $monitoringTask->status->getLabel() }}
                    </span>
                </td>
                <td>
                    <span class="field-label">Topics / Areas of Interest</span>
                    @forelse($monitoringTask->topics as $topic)
                        <span class="field-value">{{ $topic->name }}</span>@if(!$loop->last),@endif
                    @empty
                        <span class="field-value placeholder">No topics assigned</span>
                    @endforelse
                </td>
                <td>
                    <span class="field-label">Location</span>
                    <span class="field-value">{{ $monitoringTask->location?->name ?? '—' }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Region</span>
                    <span class="field-value">{{ $monitoringTask->region?->name ?? '—' }}</span>
                </td>
                <td>
                    <span class="field-label">Camera Names</span>
                    @forelse($monitoringTask->cameras as $camera)
                        <span class="field-value">{{ $camera->camera_name }}</span>@if(!$loop->last),@endif
                    @empty
                        <span class="field-value placeholder">No cameras assigned</span>
                    @endforelse
                </td>

            </tr>
        </table>

        <table class="details-table" style="margin-top: 4px;">
            <tr>
                <td colspan="3">
                    <span class="field-label">Observation</span>
                    <div class="content-box">
                        {!! $monitoringTask->observation !!}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ============ RECOMMENDATION ============ --}}
    <div class="section avoid-break">
        <div class="section-title">Recommendation</div>
        <div class="content-box">
            {!! $monitoringTask->recommendation !!}
        </div>
    </div>

    {{-- ============ ATTACHMENTS ============ --}}
    @php
        $images = $monitoringTask->getMedia('monitoring-images');
    @endphp

    <div class="section">
        <div class="section-title">Attachments</div>

        @if($images->count())
            <table class="image-gallery">
                <tr>
                    @foreach($images as $index => $image)
                        <td>
                            <img src="{{ $image->getPath() }}" alt="{{ $image->name }}">
                            <div class="image-caption">{{ $image->name }}</div>
                        </td>
                        @if(($index + 1) % 3 === 0 && !$loop->last)
                            </tr><tr>
                        @endif
                    @endforeach
                </tr>
            </table>
        @else
            <p class="empty-note">No images attached.</p>
        @endif
    </div>

    {{-- ===================== Section: Audit Trail (no title, 2 stacked groups of 3 cols) ===================== --}}
    <div class="section">
        <div class="section-body">
            <table class="audit-table">
                <tr>
                    <td>@include('pdf.partials.entry', ['label' => 'Created by', 'value' => optional($monitoringTask->creator)->name])</td>
                    <td>@include('pdf.partials.entry', ['label' => 'Edited by', 'value' => optional($monitoringTask->editor)->name])</td>
                    <td>@include('pdf.partials.entry', ['label' => 'Deleted by', 'value' => optional($monitoringTask->destroyer)->name])</td>
                </tr>
                <tr>
                    <td>@include('pdf.partials.entry', ['label' => 'Created At', 'value' => optional($monitoringTask->created_at)->format('d M Y, h:i A')])</td>
                    <td>@include('pdf.partials.entry', ['label' => 'Updated At', 'value' => optional($monitoringTask->updated_at)->format('d M Y, h:i A')])</td>
                    <td>@include('pdf.partials.entry', ['label' => 'Deleted At', 'value' => optional($monitoringTask->deleted_at)->format('d M Y, h:i A')])</td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>