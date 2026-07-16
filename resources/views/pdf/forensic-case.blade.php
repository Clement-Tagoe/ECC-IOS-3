{{--
    resources/views/pdf/forensic-case.blade.php

    PDF export view for a ForensicCase record, mirroring the structure of
    App\Filament\Resources\ForensicCases\Schemas\ForensicCaseInfolist.

    Rendered with a library such as barryvdh/laravel-dompdf, e.g.:

        Pdf::loadView('pdf.forensic-case', ['case' => $forensicCase])
            ->setPaper('a4', 'portrait')
            ->download('forensic-case-' . $forensicCase->reference_id . '.pdf');

    Notes:
    - dompdf does not support flexbox/grid reliably, so layout uses
      floats/tables instead.
    - $case is expected to be an App\Models\ForensicCase instance with its
      relations (user, collaborators, receivers, media, comments) eager
      loaded, e.g. ->load(['user', 'collaborators', 'receivers', 'media', 'comments.user']).
--}}
@php
    use App\Enums\ForensicCaseStatus;
    use App\Enums\ForensicCaseReviewStatus;
    use Illuminate\Support\Str;

    /**
     * Map a Filament color name to a hex pair [background, text] used for badges.
     */
    $colorToHex = function (?string $color) {
        return match ($color) {
            'primary' => ['#e0e7ff', '#3730a3'],
            'success' => ['#dcfce7', '#166534'],
            'warning' => ['#fef3c7', '#92400e'],
            'danger'  => ['#fee2e2', '#991b1b'],
            'gray'    => ['#f3f4f6', '#374151'],
            default   => ['#f3f4f6', '#374151'],
        };
    };

    /** Render a badge <span> for a Filament HasColor/HasLabel enum instance. */
    $renderBadge = function ($enum) use ($colorToHex) {
        if (! $enum) {
            return '<span class="badge badge-gray">&mdash;</span>';
        }
        [$bg, $fg] = $colorToHex($enum->getColor());
        $label = e($enum->getLabel());

        return "<span class=\"badge\" style=\"background-color:{$bg}; color:{$fg};\">{$label}</span>";
    };

    /** Determine a file-type label from a mime type (mirrors the infolist logic). */
    $mimeToLabel = function (?string $mime) {
        $mime = $mime ?? '';

        return match (true) {
            Str::contains($mime, ['application/pdf', 'application/x-pdf', 'application/acrobat', 'application/vnd.pdf', 'text/pdf', 'text/x-pdf']) => 'PDF Document',
            Str::contains($mime, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-word.document.macroEnabled.12', 'application/vnd.ms-word.template.macroEnabled.12']) => 'Microsoft Word',
            Str::contains($mime, ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel.sheet.macroEnabled.12', 'application/vnd.ms-excel.template.macroEnabled.12']) => 'Microsoft Excel',
            Str::contains($mime, ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-powerpoint.presentation.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow', 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.template', 'application/vnd.ms-powerpoint.template.macroEnabled.12']) => 'Microsoft PowerPoint',
            Str::contains($mime, ['video/']) => 'Video',
            Str::contains($mime, ['audio/']) => 'Audio',
            Str::contains($mime, ['zip']) => 'Zip',
            Str::contains($mime, ['text/']) => 'Txt-File',
            default => 'Attachment',
        };
    };

    $formatBytes = function (?int $bytes) {
        if (! $bytes) {
            return '';
        }
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        $bytes = (float) $bytes;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 1) . ' ' . $units[$i];
    };

    $evidenceFiles = $case->media->where('collection_name', 'forensic-evidence-files');
    $custodyFiles  = $case->media->where('collection_name', 'forensic-chain-of-custody-files');
    $images        = $case->media->where('collection_name', 'forensic-images');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Forensic Case {{ $case->reference_id }}</title>
    <style>
        @page {
            margin: 28px 32px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        .header {
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

        .section {
            margin-bottom: 18px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #111827;
            background-color: #f3f4f6;
            padding: 6px 10px;
            margin: 0 0 8px 0;
            border-left: 3px solid #4338ca;
        }

        /* --- Details grid (3 columns, mimics Section::columns(3)) --- */
        table.details {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.details td {
            width: 33.33%;
            vertical-align: top;
            padding: 6px 10px;
        }

        .field-label {
            display: block;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .field-value {
            font-size: 11px;
            color: #111827;
        }

        .field-value.full {
            white-space: pre-wrap;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 9px;
            font-size: 9px;
            font-weight: bold;
        }

        /* --- Attachments tables --- */
        table.attachments {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.attachments th {
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 1px solid #d1d5db;
            padding: 4px 6px;
        }

        table.attachments td {
            font-size: 10px;
            padding: 5px 6px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        table.attachments .icon-cell {
            width: 22px;
        }

        table.attachments .icon-cell img {
            width: 16px;
            height: 16px;
        }

        table.attachments .type-cell {
            width: 130px;
        }

        table.attachments .size-cell {
            width: 70px;
            text-align: right;
        }

        .empty-note {
            font-size: 10px;
            color: #9ca3af;
            font-style: italic;
            padding: 6px 6px 10px;
        }

        .subsection-title {
            font-size: 10px;
            font-weight: bold;
            color: #374151;
            margin: 4px 0 4px;
        }

        /* --- Image gallery --- */
        .gallery-cell {
            width: 25%;
            text-align: center;
            padding: 4px;
            vertical-align: top;
        }

        .gallery-cell img {
            width: 100%;
            max-height: 110px;
            border: 1px solid #e5e7eb;
        }

        .gallery-caption {
            font-size: 8px;
            color: #6b7280;
            margin-top: 2px;
            word-wrap: break-word;
        }

        /* --- Timestamps --- */
        table.timestamps td {
            width: 33.33%;
            padding: 6px 10px;
        }

        /* --- Comments --- */
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

        .comment-author {
            font-weight: bold;
            color: #111827;
        }

        .comment-body {
            font-size: 10px;
            color: #1f2937;
            white-space: pre-wrap;
        }

        .footer-note {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #d1d5db;
            font-size: 8px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="title">Forensic Case Report</div>
                    <div class="subtitle">Reference: {{ $case->reference_id }}</div>
                </td>
                <td style="text-align:right;">
                    <div class="subtitle">Generated: {{ now()->format('Y-m-d H:i') }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Case details --}}
    <div class="section">
        <table class="details">
            <tr>
                <td>
                    <span class="field-label">Reference ID</span>
                    <span class="field-value">{{ $case->reference_id ?? '—' }}</span>
                </td>
                <td>
                    <span class="field-label">Case Title</span>
                    <span class="field-value">{{ $case->case_title ?? '—' }}</span>
                </td>
                <td>
                    <span class="field-label">Location</span>
                    <span class="field-value">{{ $case->location ?? '—' }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Status</span>
                    <span class="field-value">
                        {!! $renderBadge($case->status instanceof ForensicCaseStatus ? $case->status : null) !!}
                    </span>
                </td>
                <td>
                    <span class="field-label">Review Status</span>
                    <span class="field-value">
                        {!! $renderBadge($case->review_status instanceof ForensicCaseReviewStatus ? $case->review_status : null) !!}
                    </span>
                </td>
                <td>
                    <span class="field-label">Sent By</span>
                    <span class="field-value">{{ $case->user?->name ?? '—' }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Collaborators</span>
                    <span class="field-value">
                        @forelse ($case->collaborators as $collaborator)
                            {{ $collaborator->name }}@if (! $loop->last)<br>@endif
                        @empty
                            No collaborators
                        @endforelse
                    </span>
                </td>
                <td colspan="2">
                    <span class="field-label">Sent To (Receivers)</span>
                    <span class="field-value">
                        @forelse ($case->receivers as $receiver)
                            {{ $receiver->name }}@if (! $loop->last)<br>@endif
                        @empty
                            —
                        @endforelse
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <span class="field-label">Description</span>
                    <span class="field-value full">{{ $case->description ?? '—' }}</span>
                </td>
            </tr>
        </table>
    </div>

    {{-- Attachments --}}
    <div class="section">
        <div class="section-title">Attachments</div>

        <div class="subsection-title">Evidence Files</div>
        @if ($evidenceFiles->count())
            <table class="attachments">
                <tr>
                    <th class="icon-cell"></th>
                    <th>File Name</th>
                    <th class="type-cell">File Type</th>
                    <th class="size-cell">Size</th>
                </tr>
                @foreach ($evidenceFiles as $file)
                    <tr>
                        <td class="icon-cell">
                            <img src="{{ public_path('images/file-icons/' . match (true) {
                                Str::contains($file->mime_type, ['application/pdf', 'application/x-pdf', 'application/acrobat', 'application/vnd.pdf', 'text/pdf', 'text/x-pdf']) => 'pdf.png',
                                Str::contains($file->mime_type, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-word.document.macroEnabled.12', 'application/vnd.ms-word.template.macroEnabled.12']) => 'word.png',
                                Str::contains($file->mime_type, ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel.sheet.macroEnabled.12', 'application/vnd.ms-excel.template.macroEnabled.12']) => 'excel.png',
                                Str::contains($file->mime_type, ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-powerpoint.presentation.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow', 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.template', 'application/vnd.ms-powerpoint.template.macroEnabled.12']) => 'powerpoint.png',
                                Str::contains($file->mime_type, 'video/') => 'video.png',
                                Str::contains($file->mime_type, ['audio/mpeg', 'audio/ogg', 'audio/wav', 'audio/x-m4a', 'audio/webm', 'audio/']) => 'audio.png',
                                Str::contains($file->mime_type, ['application/zip', 'zip']) => 'zip.png',
                                Str::contains($file->mime_type, 'text/') => 'txt-file.png',
                                default => 'attach-file.png',
                            }) }}" alt="">
                        </td>
                        <td>{{ $file->name }}</td>
                        <td class="type-cell">{{ $mimeToLabel($file->mime_type) }}</td>
                        <td class="size-cell">{{ $formatBytes($file->size) }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <div class="empty-note">No evidence files attached.</div>
        @endif

        <div class="subsection-title">Chain of Custody Files</div>
        @if ($custodyFiles->count())
            <table class="attachments">
                <tr>
                    <th class="icon-cell"></th>
                    <th>File Name</th>
                    <th class="type-cell">File Type</th>
                    <th class="size-cell">Size</th>
                </tr>
                @foreach ($custodyFiles as $file)
                    <tr>
                        <td class="icon-cell">
                            <img src="{{ public_path('images/file-icons/' . match (true) {
                                Str::contains($file->mime_type, ['application/pdf', 'application/x-pdf', 'application/acrobat', 'application/vnd.pdf', 'text/pdf', 'text/x-pdf']) => 'pdf.png',
                                Str::contains($file->mime_type, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-word.document.macroEnabled.12', 'application/vnd.ms-word.template.macroEnabled.12']) => 'word.png',
                                Str::contains($file->mime_type, ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel.sheet.macroEnabled.12', 'application/vnd.ms-excel.template.macroEnabled.12']) => 'excel.png',
                                Str::contains($file->mime_type, ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-powerpoint.presentation.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow', 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.template', 'application/vnd.ms-powerpoint.template.macroEnabled.12']) => 'powerpoint.png',
                                Str::contains($file->mime_type, 'video/') => 'video.png',
                                Str::contains($file->mime_type, ['audio/mpeg', 'audio/ogg', 'audio/wav', 'audio/x-m4a', 'audio/webm', 'audio/']) => 'audio.png',
                                Str::contains($file->mime_type, ['application/zip', 'zip']) => 'zip.png',
                                Str::contains($file->mime_type, 'text/') => 'txt-file.png',
                                default => 'attach-file.png',
                            }) }}" alt="">
                        </td>
                        <td>{{ $file->name }}</td>
                        <td class="type-cell">{{ $mimeToLabel($file->mime_type) }}</td>
                        <td class="size-cell">{{ $formatBytes($file->size) }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <div class="empty-note">No chain of custody files attached.</div>
        @endif

        <div class="subsection-title">Images</div>
        @if ($images->count())
            <table style="width:100%; border-collapse:collapse;">
                @foreach ($images->chunk(4) as $row)
                    <tr>
                        @foreach ($row as $image)
                            <td class="gallery-cell">
                                <img src="{{ $image->getPath() }}" alt="{{ $image->name }}">
                                <div class="gallery-caption">{{ $image->name }}</div>
                            </td>
                        @endforeach
                        {{-- pad remaining cells so the row stays 4 columns wide --}}
                        @for ($i = $row->count(); $i < 4; $i++)
                            <td class="gallery-cell"></td>
                        @endfor
                    </tr>
                @endforeach
            </table>
        @else
            <div class="empty-note">No images attached.</div>
        @endif
    </div>

    {{-- Timestamps --}}
    <div class="section">
        <div class="section-title">Record History</div>
        <table class="timestamps">
            <tr>
                <td>
                    <span class="field-label">Created At</span>
                    <span class="field-value">{{ optional($case->created_at)->format('Y-m-d H:i') ?? '—' }}</span>
                </td>
                <td>
                    <span class="field-label">Updated At</span>
                    <span class="field-value">{{ optional($case->updated_at)->format('Y-m-d H:i') ?? '—' }}</span>
                </td>
                <td>
                    <span class="field-label">Deleted At</span>
                    <span class="field-value">{{ optional($case->deleted_at)->format('Y-m-d H:i') ?? '—' }}</span>
                </td>
            </tr>
        </table>
    </div>

    {{-- Comments --}}
    {{-- <div class="section">
        <div class="section-title">Comments</div>
        @forelse ($case->comments as $comment)
            <div class="comment">
                <div class="comment-meta">
                    <span class="comment-author">{{ $comment->user?->name ?? 'Unknown user' }}</span>
                    &middot; {{ optional($comment->created_at)->format('Y-m-d H:i') }}
                </div>
                <div class="comment-body">{{ $comment->body ?? $comment->comment ?? '' }}</div>
            </div>
        @empty
            <div class="empty-note">No comments on this case.</div>
        @endforelse
    </div> --}}

    <div class="footer-note">
        This document was generated automatically and reflects the case record at the time of export.
    </div>

</body>
</html>