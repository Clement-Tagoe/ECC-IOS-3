<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $report->title }} — Report</title>
    <style>
        /* dompdf only supports a subset of CSS — keep it simple, avoid flex/grid */
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

        h1.report-title {
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

        /* Status badges */
        .badge-status-in_review  { background-color: #dbeafe; color: #1d4ed8; }
        .badge-status-reviewed   { background-color: #dcfce7; color: #15803d; }

        /* Priority badges */
        .badge-priority-low      { background-color: #f3f4f6; color: #4b5563; }
        .badge-priority-medium   { background-color: #dbeafe; color: #1d4ed8; }
        .badge-priority-high     { background-color: #fef3c7; color: #b45309; }
        .badge-priority-critical { background-color: #fee2e2; color: #b91c1c; }

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

        .description-box {
            font-size: 11px;
            color: #1f2937;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 10px 12px;
        }
        .description-box p { margin: 0 0 8px 0; }
        .description-box p:last-child { margin-bottom: 0; }

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

        /* Files table */
        table.files-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.files-table th {
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            padding: 5px 8px;
        }
        table.files-table td {
            font-size: 10px;
            padding: 6px 8px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        table.files-table img.file-icon {
            width: 14px;
            height: 14px;
            vertical-align: middle;
            margin-right: 5px;
        }

        .empty-note {
            font-size: 10px;
            color: #9ca3af;
            font-style: italic;
        }

        /* Comments */
        .comment {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 8px 10px;
            margin-bottom: 8px;
        }
        .comment-meta {
            font-size: 9px;
            color: #6b7280;
            margin-bottom: 4px;
        }
        .comment-meta .author {
            font-weight: bold;
            color: #111827;
        }
        .comment-body {
            font-size: 10.5px;
            color: #1f2937;
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
            Report #{{ $report->id }}
        </div>
    </header>

    <footer>
        {{ config('app.name') }} &mdash; Confidential &mdash; Page <span class="page-number"></span>
    </footer>

    <h1 class="report-title">{{ $report->title }}</h1>
    <div class="subtitle">
        {{ $report->reportType?->name ?? 'Uncategorized' }}
        &bull; {{ \Illuminate\Support\Carbon::parse($report->date)->format('F j, Y') }}
        &bull; {{ ucfirst($report->shift) }} shift
    </div>

    {{-- ============ REPORT DETAILS ============ --}}
    <div class="section avoid-break">
        <div class="section-title">Report Details</div>

        <table class="details-table">
            <tr>
                <td>
                    <span class="field-label">Report Date</span>
                    <span class="field-value">{{ \Illuminate\Support\Carbon::parse($report->date)->format('F j, Y') }}</span>
                </td>
                <td>
                    <span class="field-label">Report Type</span>
                    <span class="field-value">{{ $report->reportType?->name ?? '—' }}</span>
                </td>
                <td>
                    <span class="field-label">Shift</span>
                    <span class="field-value">{{ ucfirst($report->shift) }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Status</span>
                    <span class="badge badge-status-{{ $report->status->value }}">
                        {{ $report->status->getLabel() }}
                    </span>
                </td>
                <td>
                    <span class="field-label">Priority</span>
                    <span class="badge badge-priority-{{ $report->priority->value }}">
                        {{ $report->priority->getLabel() }}
                    </span>
                </td>
                <td>
                    <span class="field-label">Department</span>
                    @if($report->department)
                        <span class="field-value">{{ $report->department->name }}</span>
                    @else
                        <span class="field-value placeholder">No department assigned</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Collaborators</span>
                    @forelse($report->collaborators as $collaborator)
                        <span class="field-value">{{ $collaborator->name }}</span><br>
                    @empty
                        <span class="field-value placeholder">No collaborators</span>
                    @endforelse
                </td>
                <td colspan="2">
                    <span class="field-label">Sent To (Receivers)</span>
                    @forelse($report->receivers as $receiver)
                        <span class="field-value">{{ $receiver->name }}</span><br>
                    @empty
                        <span class="field-value placeholder">No receivers</span>
                    @endforelse
                </td>
            </tr>
        </table>

        <table class="details-table" style="margin-top: 4px;">
            <tr>
                <td colspan="3">
                    <span class="field-label">Description</span>
                    <div class="description-box">
                        {!! $report->description !!}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ============ ATTACHMENTS ============ --}}
    @php
        $images = $report->getMedia('report-images');
        $files = $report->getMedia('report-files');
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

        @if($files->count())
            <table class="files-table" style="margin-top: 12px;">
                <thead>
                    <tr>
                        <th>File</th>
                        <th>Type</th>
                        <th>Size</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($files as $file)
                        @php
                            $mime = $file->mime_type;
                            $fileType = match (true) {
                                \Illuminate\Support\Str::contains($mime, ['application/pdf', 'application/x-pdf', 'application/acrobat', 'application/vnd.pdf', 'text/pdf', 'text/x-pdf']) => 'PDF Document',
                                \Illuminate\Support\Str::contains($mime, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-word.document.macroEnabled.12', 'application/vnd.ms-word.template.macroEnabled.12']) => 'Microsoft Word',
                                \Illuminate\Support\Str::contains($mime, ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel.sheet.macroEnabled.12', 'application/vnd.ms-excel.template.macroEnabled.12']) => 'Microsoft Excel',
                                \Illuminate\Support\Str::contains($mime, ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-powerpoint.presentation.macroEnabled.12']) => 'Microsoft PowerPoint',
                                \Illuminate\Support\Str::contains($mime, 'video/') => 'Video',
                                \Illuminate\Support\Str::contains($mime, 'audio/') => 'Audio',
                                \Illuminate\Support\Str::contains($mime, ['zip']) => 'Zip',
                                \Illuminate\Support\Str::contains($mime, 'text/') => 'Txt-File',
                                default => 'Attachment',
                            };
                        @endphp
                        <tr>
                            <td>{{ $file->name }}</td>
                            <td>{{ $fileType }}</td>
                            <td>{{ number_format($file->size / 1024, 1) }} KB</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty-note" style="margin-top: 8px;">No files attached.</p>
        @endif
    </div>

    {{-- ============ COMMENTS ============
    @php
        $comments = $report->comments()->with('user')->latest()->get();
    @endphp

    @if($comments->count())
        <div class="section">
            <div class="section-title">Comments</div>
            @foreach($comments as $comment)
                <div class="comment avoid-break">
                    <div class="comment-meta">
                        <span class="author">{{ $comment->user?->name ?? 'Unknown user' }}</span>
                        &bull; {{ $comment->created_at->format('M j, Y g:i A') }}
                    </div>
                    <div class="comment-body">
                        {!! clean($comment->comment ?? $comment->body) !!}
                    </div>
                </div>
            @endforeach
        </div>
    @endif --}}

</body>
</html>