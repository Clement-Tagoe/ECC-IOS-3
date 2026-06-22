<?php

namespace App\Filament\Widgets\MainDashboard;


use App\Models\Region;
use App\Models\ValidCase;
use App\Models\ValidCaseNature;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GhanaCasesMapWidget extends Widget
{
    use InteractsWithPageFilters;
    
    protected string $view = 'filament.widgets.ghana-cases-map-widget';

    protected ?string $heading = 'Cases by Region — Ghana Map';

    protected int | string | array $columnSpan =  8;
 
    // ─────────────────────────────────────────────────────────────────────
    // Data
    // ─────────────────────────────────────────────────────────────────────
 
    public function getMapData(): array
    {
        $startDate = isset($this->pageFilters['startDate'])
            ? Carbon::parse($this->pageFilters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate'])
            ? Carbon::parse($this->pageFilters['endDate'])->endOfDay()
            : now()->endOfDay();
            
        // Apply date range scope
        $query = ValidCase::whereBetween('reporting_date', [$startDate, $endDate])
            ->select('region_id', 'valid_case_nature_id', DB::raw('count(*) as total'))
            ->groupBy('region_id', 'valid_case_nature_id');
 
        $caseRows    = $query->get();
        $regions     = Region::orderBy('name')->get()->keyBy('id');
        $caseNatures = ValidCaseNature::orderBy('name')->get();
 
        // Colour palette — one stable colour per nature (index-based)
        $palette = [
            '#ef4444', '#f97316', '#eab308', '#22c55e', '#06b6d4',
            '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6', '#f59e0b', '#6366f1',
        ];
 
        $naturesFormatted = [];
        foreach ($caseNatures as $i => $nature) {
            $naturesFormatted[$nature->id] = [
                'name'  => $nature->name,
                'color' => $palette[$i % count($palette)],
            ];
        }
 
        // Seed every region with zero counts
        $regionData = [];
        foreach ($regions as $id => $region) {
            $regionData[$id] = [
                'name'       => $region->name,
                'slug'       => Str::slug($region->name),
                'total'      => 0,
                'byNature'   => [],  // [ nature_id => ['name'=>..,'color'=>..,'count'=>N] ]
            ];
        }
 
        // Fill in counts from query rows
        foreach ($caseRows as $row) {
            $rid = $row->region_id;
            $nid = $row->valid_case_nature_id;
            $nInfo = $naturesFormatted[$nid] ?? ['name' => "Nature {$nid}", 'color' => '#94a3b8'];
 
            if (!isset($regionData[$rid])) {
                $r = $regions->get($rid);
                $regionData[$rid] = [
                    'name'     => $r?->name ?? "Region {$rid}",
                    'slug'     => Str::slug($r?->name ?? "region-{$rid}"),
                    'total'    => 0,
                    'byNature' => [],
                ];
            }
 
            $regionData[$rid]['total'] += $row->total;
 
            if (!isset($regionData[$rid]['byNature'][$nid])) {
                $regionData[$rid]['byNature'][$nid] = [
                    'name'  => $nInfo['name'],
                    'color' => $nInfo['color'],
                    'count' => 0,
                ];
            }
            $regionData[$rid]['byNature'][$nid]['count'] += $row->total;
        }
 
        // Sort each region's natures by count desc
        foreach ($regionData as &$rd) {
            arsort($rd['byNature']);  // sorts by value (array), use uasort for 'count' key
            uasort($rd['byNature'], fn ($a, $b) => $b['count'] <=> $a['count']);
        }
        unset($rd);
 
        $grandTotal = collect($regionData)->sum('total');
        $maxTotal   = max(1, collect($regionData)->max('total'));
 
        return [
            'regions'    => $regionData,
            'natures'    => $naturesFormatted,
            'grandTotal' => $grandTotal,
            'maxTotal'   => $maxTotal,
        ];
    }
}