{{--
    resources/views/pdf/partials/entry.blade.php

    Reusable "label above value" pair, mirroring how a Filament TextEntry renders.
    Usage:
        @include('pdf.partials.entry', ['label' => 'Case ID', 'value' => $case->case_id])
--}}
<span class="entry-label">{{ $label }}</span>
<span class="entry-value {{ filled($value ?? null) ? '' : 'empty' }}">
    {{ filled($value ?? null) ? $value : '—' }}
</span>