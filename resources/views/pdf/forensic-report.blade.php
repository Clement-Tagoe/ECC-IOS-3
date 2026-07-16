{{--
    resources/views/pdf/forensic-report.blade.php

    PDF export view for a ForensicReport record, mirroring the structure of
    App\Filament\Resources\ForensicReports\Schemas\ForensicReportInfolist.

    Rendered with a library such as barryvdh/laravel-dompdf, e.g.:

        Pdf::loadView('pdf.forensic-report', ['report' => $forensicReport])
            ->setPaper('a4', 'portrait')
            ->download('forensic-report-' . $forensicReport->case_reference_number . '.pdf');

    $report is expected to be an App\Models\ForensicReport instance with its
    relations eager loaded, e.g.:
        ->load(['user', 'collaborators', 'receivers', 'media', 'comments.user'])

    Notes:
    - dompdf does not support flexbox/grid reliably, so layout uses
      floats/tables instead.
    - Narrative sections (3 onward) are rendered as stacked label/value
      blocks rather than trying to replicate the Filament column count
      exactly — this reads far better in a printed report than cramming
      long free-text fields into narrow columns.
--}}
@php
    use App\Enums\ForensicReportStatus;
    use App\Enums\ForensicReportReviewStatus;
    use Illuminate\Support\Str;

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

    $renderBadge = function ($enum) use ($colorToHex) {
        if (! $enum) {
            return '<span class="badge badge-gray">&mdash;</span>';
        }
        [$bg, $fg] = $colorToHex($enum->getColor());
        $label = e($enum->getLabel());

        return "<span class=\"badge\" style=\"background-color:{$bg}; color:{$fg};\">{$label}</span>";
    };

    $mimeToIcon = function (?string $mime) {
        $mime = $mime ?? '';

        return match (true) {
            Str::contains($mime, ['application/pdf', 'application/x-pdf', 'application/acrobat', 'application/vnd.pdf', 'text/pdf', 'text/x-pdf']) => 'pdf.png',
            Str::contains($mime, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-word.document.macroEnabled.12', 'application/vnd.ms-word.template.macroEnabled.12']) => 'word.png',
            Str::contains($mime, ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel.sheet.macroEnabled.12', 'application/vnd.ms-excel.template.macroEnabled.12']) => 'excel.png',
            Str::contains($mime, ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-powerpoint.presentation.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow', 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12', 'application/vnd.openxmlformats-officedocument.presentationml.template', 'application/vnd.ms-powerpoint.template.macroEnabled.12']) => 'powerpoint.png',
            Str::contains($mime, 'video/') => 'video.png',
            Str::contains($mime, ['audio/mpeg', 'audio/ogg', 'audio/wav', 'audio/x-m4a', 'audio/webm', 'audio/']) => 'audio.png',
            Str::contains($mime, ['application/zip', 'zip']) => 'zip.png',
            Str::contains($mime, 'text/') => 'txt-file.png',
            default => 'attach-file.png',
        };
    };

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

    /** Fetch a field's value off $report, returning a placeholder when empty. */
    $val = function (string $key, string $placeholder = '—') use ($report) {
        $value = data_get($report, $key);

        return filled($value) ? $value : $placeholder;
    };

    // Narrative sections rendered as stacked label/value blocks.
    // Each entry: [section title, [ [field_key, label, placeholder], ... ] ]
    $narrativeSections = [
        '3. Executive Summary' => [
            ['purpose_of_investigation', 'Purpose of Investigation', '—'],
            ['summary_of_findings', 'Summary of Findings', '—'],
            ['summary_of_conclusions', 'Summary of Conclusions', '—'],
        ],
        '4. Scope of Examination' => [
            ['devices_examined', 'Devices Examined', '—'],
            ['evidence_sources', 'Evidence Sources', '—'],
            ['investigation_objectives', 'Investigation Objectives', '—'],
        ],
        '5. Legal Authority' => [
            ['search_warrant_details', 'Search Warrant Details', 'N/A'],
            ['court_order_references', 'Court Order References', 'N/A'],
            ['consent_authorization', 'Consent Authorization', 'N/A'],
            ['applicable_legal_framework', 'Applicable Legal Framework', '—'],
        ],
        '6. Evidence Received' => [
            ['evidence_inventory', 'Evidence Inventory', '—'],
            ['condition_of_evidence', 'Condition of Evidence', '—'],
            ['hash_algorithm', 'Hash Algorithm', '—'],
            ['hash_verification_details', 'Hash Verification Details', '—'],
        ],
        '7. Chain of Custody' => [
            ['evidence_transfer_records', 'Evidence Transfer Records', '—'],
            ['storage_records', 'Storage Records', '—'],
            ['custodian_signatures', 'Custodian Signatures', '—'],
        ],
        '8. Methodology' => [
            ['methodology_identification', 'Identification', '—'],
            ['methodology_preservation', 'Preservation', '—'],
            ['methodology_acquisition', 'Acquisition', '—'],
            ['methodology_examination', 'Examination', '—'],
            ['methodology_analysis', 'Analysis', '—'],
            ['methodology_reporting', 'Reporting', '—'],
        ],
        '9. Forensic Environment' => [
            ['workstation_specifications', 'Workstation Specifications', '—'],
            ['write_blockers_used', 'Write Blockers Used', '—'],
            ['forensic_tools_and_versions', 'Forensic Tools and Versions', '—'],
        ],
        '10. Examination Procedures' => [
            ['imaging_procedures', 'Imaging Procedures', '—'],
            ['verification_methods', 'Verification Methods', '—'],
            ['artifact_analysis', 'Artifact Analysis', '—'],
            ['timeline_reconstruction', 'Timeline Reconstruction', '—'],
        ],
        '11. Findings and Analysis' => [
            ['user_activity_analysis', 'User Activity Analysis', 'N/A'],
            ['file_system_analysis', 'File System Analysis', 'N/A'],
            ['browser_history', 'Browser History', 'N/A'],
            ['email_analysis', 'Email Analysis', 'N/A'],
            ['usb_analysis', 'USB Analysis', 'N/A'],
            ['mobile_device_analysis', 'Mobile Device Analysis', 'N/A'],
        ],
        '12. Timeline of Events' => [
            ['chronological_reconstruction', 'Chronological Reconstruction of Activities', '—'],
            ['correlation_of_evidence_sources', 'Correlation of Evidence Sources', '—'],
        ],
        '13. Conclusion' => [
            ['investigation_conclusions', 'Investigation Conclusions', '—'],
            ['evidentiary_significance', 'Evidentiary Significance', '—'],
        ],
        '14. Expert Opinion' => [
            ['professional_opinion', 'Professional Opinion', '—'],
            ['reasonable_degree_of_forensic_certainty', 'Reasonable Degree of Forensic Certainty', '—'],
        ],
        '15. Limitations' => [
            ['scope_limitations', 'Scope Limitations', 'N/A'],
            ['potential_data_gaps', 'Potential Data Gaps', 'N/A'],
            ['timestamp_considerations', 'Timestamp Considerations', 'N/A'],
        ],
        '16. Recommendations' => [
            ['security_improvements', 'Security Improvements', 'N/A'],
            ['further_investigative_actions', 'Further Investigative Actions', 'N/A'],
            ['policy_recommendations', 'Policy Recommendations', 'N/A'],
        ],
        '17. Appendices' => [
            ['hash_values', 'Hash Values', 'N/A'],
            ['glossary_of_terms', 'Glossary of Terms', 'N/A'],
        ],
    ];

    $reportImages = $report->media->where('collection_name', 'forensic-report-images');
    $reportFiles  = $report->media->where('collection_name', 'forensic-report-files');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Forensic Report {{ $report->case_reference_number }}</title>
    <style>
        @page {
            margin: 30px 34px;
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
            margin-bottom: 18px;
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
            margin-bottom: 16px;
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

        table.grid {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.grid td {
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

        .stack-field {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .stack-field:last-child {
            margin-bottom: 0;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 9px;
            font-size: 9px;
            font-weight: bold;
        }

        /* --- Attachments --- */
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

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="title">Digital Forensic Examination Report</div>
                    <div class="subtitle">Case Reference: {{ $report->case_reference_number }}</div>
                </td>
                <td style="text-align:right;">
                    <div class="subtitle">Generated: {{ now()->format('Y-m-d H:i') }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- 1. Case Information --}}
    <div class="section">
        <div class="section-title">1. Case Information</div>
        <table class="grid">
            <tr>
                <td style="width:33.33%;">
                    <span class="field-label">Case Reference Number</span>
                    <span class="field-value">{{ $val('case_reference_number') }}</span>
                </td>
                <td style="width:33.33%;">
                    <span class="field-label">Investigation Title</span>
                    <span class="field-value">{{ $val('investigation_title') }}</span>
                </td>
                <td style="width:33.33%;">
                    <span class="field-label">Requesting Agency / Organisation</span>
                    <span class="field-value">{{ $val('requesting_agency') }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Lead Examiner</span>
                    <span class="field-value">{{ $val('lead_examiner') }}</span>
                </td>
                <td>
                    <span class="field-label">Court / Jurisdiction</span>
                    <span class="field-value">{{ $val('court_jurisdiction', 'N/A') }}</span>
                </td>
                <td>
                    <span class="field-label">Date of Examination</span>
                    <span class="field-value">{{ \Illuminate\Support\Carbon::parse($report->date_of_examination)->format('Y-m-d')}}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Status</span>
                    <span class="field-value">{!! $renderBadge($report->status instanceof ForensicReportStatus ? $report->status : null) !!}</span>
                </td>
                <td>
                    <span class="field-label">Review Status</span>
                    <span class="field-value">{!! $renderBadge($report->review_status instanceof ForensicReportReviewStatus ? $report->review_status : null) !!}</span>
                </td>
                <td>
                    <span class="field-label">Sent By</span>
                    <span class="field-value">{{ $report->user?->name ?? '—' }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="field-label">Collaborators</span>
                    <span class="field-value">
                        @forelse ($report->collaborators as $collaborator)
                            {{ $collaborator->name }}@if (! $loop->last)<br>@endif
                        @empty
                            No collaborators
                        @endforelse
                    </span>
                </td>
                <td colspan="2">
                    <span class="field-label">Sent To (Receivers)</span>
                    <span class="field-value">
                        @forelse ($report->receivers as $receiver)
                            {{ $receiver->name }}@if (! $loop->last)<br>@endif
                        @empty
                            —
                        @endforelse
                    </span>
                </td>
            </tr>
        </table>
    </div>

    {{-- 2. Declaration --}}
    <div class="section">
        <div class="section-title">2. Declaration</div>
        <div class="stack-field">
            <span class="field-label">Certification of Evidence Integrity</span>
            <span class="field-value full">{{ $val('certification_of_evidence_integrity') }}</span>
        </div>
        <div class="stack-field">
            <span class="field-label">Confirmation of Accepted Forensic Methodologies</span>
            <span class="field-value full">{{ $val('confirmation_of_methodologies') }}</span>
        </div>
        <table class="grid">
            <tr>
                <td style="width:50%;">
                    <span class="field-label">Examiner Signature</span>
                    <span class="field-value">{{ $val('examiner_signature') }}</span>
                </td>
                <td style="width:50%;">
                    <span class="field-label">Signature Date</span>
                    <span class="field-value">{{ optional($report->signature_date)->format('Y-m-d') ?? '—' }}</span>
                </td>
            </tr>
        </table>
    </div>

    {{-- 3 through 17: narrative sections, stacked label/value blocks --}}
    @foreach ($narrativeSections as $title => $fields)
        <div class="section">
            <div class="section-title">{{ $title }}</div>
            @foreach ($fields as [$key, $label, $placeholder])
                <div class="stack-field">
                    <span class="field-label">{{ $label }}</span>
                    <span class="field-value full">{{ $val($key, $placeholder) }}</span>
                </div>
            @endforeach
        </div>
    @endforeach

    {{-- Attachments --}}
    <div class="section page-break">
        <div class="section-title">Attachments</div>

        <div class="subsection-title">Evidence Photographs &amp; Screenshots</div>
        @if ($reportImages->count())
            <table style="width:100%; border-collapse:collapse;">
                @foreach ($reportImages->chunk(4) as $row)
                    <tr>
                        @foreach ($row as $image)
                            <td class="gallery-cell">
                                <img src="{{ $image->getPath() }}" alt="{{ $image->name }}">
                                <div class="gallery-caption">{{ $image->name }}</div>
                            </td>
                        @endforeach
                        @for ($i = $row->count(); $i < 4; $i++)
                            <td class="gallery-cell"></td>
                        @endfor
                    </tr>
                @endforeach
            </table>
        @else
            <div class="empty-note">No evidence photographs or screenshots attached.</div>
        @endif

        <div class="subsection-title">Forensic Report Files</div>
        @if ($reportFiles->count())
            <table class="attachments">
                <tr>
                    <th class="icon-cell"></th>
                    <th>File Name</th>
                    <th class="type-cell">File Type</th>
                    <th class="size-cell">Size</th>
                </tr>
                @foreach ($reportFiles as $file)
                    <tr>
                        <td class="icon-cell">
                            <img src="{{ public_path('images/file-icons/' . $mimeToIcon($file->mime_type)) }}" alt="">
                        </td>
                        <td>{{ $file->name }}</td>
                        <td class="type-cell">{{ $mimeToLabel($file->mime_type) }}</td>
                        <td class="size-cell">{{ $formatBytes($file->size) }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <div class="empty-note">No forensic report files attached.</div>
        @endif
    </div>

    {{-- Audit Trail --}}
    <div class="section">
        <div class="section-title">Record History</div>
        <table class="grid">
            <tr>
                <td style="width:33.33%;">
                    <span class="field-label">Created At</span>
                    <span class="field-value">{{ optional($report->created_at)->format('Y-m-d H:i') ?? '—' }}</span>
                </td>
                <td style="width:33.33%;">
                    <span class="field-label">Updated At</span>
                    <span class="field-value">{{ optional($report->updated_at)->format('Y-m-d H:i') ?? '—' }}</span>
                </td>
                <td style="width:33.33%;">
                    <span class="field-label">Deleted At</span>
                    <span class="field-value">{{ optional($report->deleted_at)->format('Y-m-d H:i') ?? '—' }}</span>
                </td>
            </tr>
        </table>
    </div>

    {{-- Comments
    <div class="section">
        <div class="section-title">Comments</div>
        @forelse ($report->comments as $comment)
            <div class="comment">
                <div class="comment-meta">
                    <span class="comment-author">{{ $comment->user?->name ?? 'Unknown user' }}</span>
                    &middot; {{ optional($comment->created_at)->format('Y-m-d H:i') }}
                </div>
                <div class="comment-body">{{ $comment->body ?? $comment->comment ?? '' }}</div>
            </div>
        @empty
            <div class="empty-note">No comments on this report.</div>
        @endforelse
    </div> --}}

    <div class="footer-note">
        This document was generated automatically and reflects the report record at the time of export.
    </div>

</body>
</html>