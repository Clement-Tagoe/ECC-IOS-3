<x-filament-widgets::widget>
    <x-filament::section>
        {{--
            GhanaCasesMapWidget Blade View
            ──────────────────────────────────────────────────────────────────────
            Choropleth of Ghana's 16 regions coloured by valid case intensity.
            Blue scale: light (#dbeafe) → dark (#1d4ed8).
        
            Sidebar:   all 16 regions listed, each with a per-nature count table.
            Tooltip:   region name, grand total, per-nature breakdown with coloured dots.
            Filter:    Today | 7 Days | 30 Days | 90 Days  (Livewire wire:click)
        ──────────────────────────────────────────────────────────────────────────
        --}}
        @php
            // use Illuminate\Support\Str;
        
            $d           = $this->getMapData();
            $regions     = $d['regions'];
            $natures     = $d['natures'];     // [ id => ['name','color'] ]
            $grandTotal  = $d['grandTotal'];
            $maxTotal    = $d['maxTotal'];
        
            // SVG path data for Ghana's 16 regions
            $regionPaths = [
                'Greater Accra' => ['path' => 'M295,430 L330,418 L345,435 L340,455 L310,460 L290,450 Z',                                               'lx' => 315, 'ly' => 441],
                'Central'       => ['path' => 'M215,400 L295,390 L290,430 L295,430 L290,450 L260,465 L230,455 L210,435 Z',                             'lx' => 255, 'ly' => 430],
                'Western'       => ['path' => 'M130,380 L215,360 L215,400 L210,435 L180,460 L140,450 L115,420 Z',                                      'lx' => 170, 'ly' => 415],
                'Western North' => ['path' => 'M100,290 L175,275 L210,285 L215,360 L130,380 L115,350 L95,330 Z',                                       'lx' => 158, 'ly' => 328],
                'Ashanti'       => ['path' => 'M210,285 L300,270 L335,285 L340,330 L310,355 L295,390 L215,360 Z',                                      'lx' => 272, 'ly' => 328],
                'Eastern'       => ['path' => 'M295,390 L340,330 L370,335 L390,360 L370,390 L345,418 L330,418 L295,430 Z',                             'lx' => 340, 'ly' => 378],
                'Volta'         => ['path' => 'M370,335 L410,300 L440,310 L450,350 L440,390 L420,420 L390,425 L370,410 L370,390 L390,360 Z',           'lx' => 415, 'ly' => 365],
                'Oti'           => ['path' => 'M340,220 L390,210 L410,230 L410,300 L370,335 L340,330 L335,285 Z',                                      'lx' => 378, 'ly' => 272],
                'Bono East'     => ['path' => 'M270,195 L340,185 L340,220 L335,285 L300,270 L265,260 Z',                                               'lx' => 308, 'ly' => 235],
                'Ahafo'         => ['path' => 'M175,240 L210,230 L265,235 L265,260 L300,270 L210,285 L175,275 Z',                                      'lx' => 232, 'ly' => 260],
                'Bono'          => ['path' => 'M140,195 L210,185 L270,195 L265,235 L210,230 L175,240 L145,235 Z',                                      'lx' => 210, 'ly' => 213],
                'Northern'      => ['path' => 'M155,100 L270,90 L340,100 L340,185 L270,195 L140,195 L145,160 Z',                                       'lx' => 240, 'ly' => 148],
                'Savannah'      => ['path' => 'M100,130 L155,100 L145,160 L140,195 L100,200 L80,175 L85,150 Z',                                        'lx' => 114, 'ly' => 160],
                'North East'    => ['path' => 'M270,90 L370,80 L390,100 L390,140 L340,150 L340,100 Z',                                                 'lx' => 345, 'ly' => 116],
                'Upper East'    => ['path' => 'M270,30 L390,20 L390,80 L370,80 L270,90 L255,60 Z',                                                     'lx' => 325, 'ly' => 56],
                'Upper West'    => ['path' => 'M130,30 L270,30 L255,60 L270,90 L155,100 L100,130 L90,80 Z',                                            'lx' => 190, 'ly' => 70],
            ];
        
            // Helper: find region data by name
            $resolve = function (string $name) use ($regions): array {
                foreach ($regions as $r) {
                    if (strtolower($r['name']) === strtolower($name)) return $r;
                }
                return ['name' => $name, 'slug' => Str::slug($name), 'total' => 0, 'byNature' => []];
            };
        
            // Helper: compute blue choropleth fill from intensity 0–1
            $fill = function (int $value, int $max): string {
                if ($value === 0) return '#e2e8f0';
                $t = min(1, $value / $max);
                $r = (int) round(219 - $t * (219 - 29));
                $g = (int) round(234 - $t * (234 - 78));
                $b = (int) round(254 - $t * (254 - 216));
                return "rgb({$r},{$g},{$b})";
            };
        @endphp
 
        <div
            style="font-family:'Figtree','DM Sans',ui-sans-serif,system-ui,sans-serif;background:var(--fi-bg,#f8fafc);border-radius:12px;overflow:hidden"
            x-data="ghanaCasesMap()"
            x-init="init()"
        >
        
            {{-- ── Header ──────────────────────────────────────────────────────── --}}
            <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;padding:1rem 1.25rem .875rem;border-bottom:1px solid rgba(0,0,0,.07)">
                <div>
                    <p style="font-size:14px;font-weight:600;color:#0f172a;margin:0 0 2px">
                        Valid Cases by Region — Ghana
                    </p>
                    <p style="font-size:12px;color:#64748b;margin:0">
                        <span style="color:#1d4ed8;font-weight:600">{{ number_format($grandTotal) }} case{{ $grandTotal !== 1 ? 's' : '' }}</span>
                        across all regions · grouped by case nature
                    </p>
                </div>
        
                {{-- Date range filter --}}
                {{-- <div style="display:flex;gap:0;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;background:#fff">
                    @foreach(['today' => 'Today', '7d' => '7 Days', '30d' => '30 Days', '90d' => '90 Days'] as $val => $label)
                    <button
                        wire:click="setDateRange('{{ $val }}')"
                        style="
                            padding:6px 14px;font-size:12px;font-weight:500;cursor:pointer;border:none;
                            {{ !$loop->first ? 'border-left:1px solid #e2e8f0;' : '' }}
                            {{ $dateRange === $val
                                ? 'background:#1d4ed8;color:#fff'
                                : 'background:#fff;color:#475569' }}
                        "
                    >{{ $label }}</button>
                    @endforeach
                </div> --}}
            </div>
        
            {{-- ── Case nature legend pills ─────────────────────────────────────── --}}
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:5px;padding:.625rem 1.25rem;border-bottom:1px solid rgba(0,0,0,.04);background:#f8fafc">
                <span style="font-size:11px;font-weight:600;color:#64748b;margin-right:4px">Case natures:</span>
                @foreach($natures as $nid => $nInfo)
                <span style="display:inline-flex;align-items:center;gap:4px;font-size:11px;color:#374151;background:#fff;border:1px solid #e2e8f0;border-radius:20px;padding:2px 9px;white-space:nowrap">
                    <span style="width:7px;height:7px;border-radius:50%;background:{{ $nInfo['color'] }};flex-shrink:0"></span>
                    {{ $nInfo['name'] }}
                </span>
                @endforeach
                @if(empty($natures))
                <span style="font-size:11px;color:#94a3b8;font-style:italic">No case natures configured</span>
                @endif
            </div>
        
            {{-- ── Body ─────────────────────────────────────────────────────────── --}}
            <div style="display:flex;min-height:520px">
        
                {{-- SVG map ─────────────────────────────────────────────────────── --}}
                <div style="flex:1;min-width:0;padding:1.25rem 1rem 1rem 1.5rem;display:flex;flex-direction:column">
                    <svg
                        viewBox="60 10 410 470"
                        xmlns="http://www.w3.org/2000/svg"
                        style="width:100%;max-height:460px;display:block"
                        role="img"
                        aria-label="Choropleth map of Ghana showing valid cases by region"
                    >
                        <defs>
                            <filter id="cs-shadow" x="-10%" y="-10%" width="120%" height="120%">
                                <feDropShadow dx="0" dy="1" stdDeviation="2" flood-color="rgba(0,0,0,.15)"/>
                            </filter>
                            <filter id="cs-shadow-h" x="-15%" y="-15%" width="130%" height="130%">
                                <feDropShadow dx="0" dy="3" stdDeviation="5" flood-color="rgba(0,0,0,.28)"/>
                            </filter>
                        </defs>
        
                        @foreach($regionPaths as $regionName => $pd)
                        @php
                            $rd        = $resolve($regionName);
                            $slug      = $rd['slug'];
                            $total     = $rd['total'];
                            $intensity = $maxTotal > 0 ? $total / $maxTotal : 0;
                            $bgFill    = $fill($total, $maxTotal);
                            $lightText = $intensity > 0.52;
        
                            // Tooltip payload
                            $ttPayload = json_encode([
                                'name'     => $regionName,
                                'total'    => $total,
                                'byNature' => array_values($rd['byNature']),
                            ]);
                        @endphp
                        <g
                            data-slug="{{ $slug }}"
                            @mouseenter="onEnter($event, {{ $ttPayload }})"
                            @mouseleave="onLeave()"
                            @mousemove="onMove($event)"
                            style="cursor:pointer"
                        >
                            <path
                                d="{{ $pd['path'] }}"
                                fill="{{ $bgFill }}"
                                stroke="#fff"
                                stroke-width="1.5"
                                stroke-linejoin="round"
                                :style="hovered === '{{ $slug }}'
                                    ? 'filter:url(#cs-shadow-h);opacity:.85;stroke-width:2.5'
                                    : 'filter:url(#cs-shadow)'"
                                style="transition:opacity .12s"
                            />
        
                            {{-- Region label --}}
                            <text
                                x="{{ $pd['lx'] }}" y="{{ $pd['ly'] - ($total > 0 ? 5 : 0) }}"
                                text-anchor="middle" dominant-baseline="middle"
                                font-size="7.5" font-weight="600" pointer-events="none"
                                fill="{{ $lightText ? '#fff' : '#1e293b' }}"
                                style="user-select:none"
                            >{{ Str::limit($regionName, 12) }}</text>
        
                            {{-- Case count --}}
                            @if($total > 0)
                            <text
                                x="{{ $pd['lx'] }}" y="{{ $pd['ly'] + 6 }}"
                                text-anchor="middle" dominant-baseline="middle"
                                font-size="8" font-weight="800" pointer-events="none"
                                fill="{{ $lightText ? 'rgba(255,255,255,.9)' : '#1d4ed8' }}"
                                style="user-select:none"
                            >{{ number_format($total) }}</text>
                            @endif
                        </g>
                        @endforeach
        
                        {{-- Compass --}}
                        <g transform="translate(88,455)">
                            <circle cx="0" cy="0" r="10" fill="white" stroke="#cbd5e1" stroke-width="1"/>
                            <text x="0" y="-3" text-anchor="middle" font-size="7" font-weight="700" fill="#475569">N</text>
                            <polygon points="0,-2 2,2 -2,2" fill="#475569"/>
                        </g>
        
                        {{-- Scale bar --}}
                        <g transform="translate(335,465)">
                            <line x1="0" y1="0" x2="64" y2="0" stroke="#94a3b8" stroke-width="1.5"/>
                            <line x1="0" y1="-3" x2="0" y2="3" stroke="#94a3b8" stroke-width="1.5"/>
                            <line x1="64" y1="-3" x2="64" y2="3" stroke="#94a3b8" stroke-width="1.5"/>
                            <text x="32" y="-6" text-anchor="middle" font-size="6" fill="#94a3b8">~300 km</text>
                        </g>
                    </svg>
        
                    {{-- Intensity gradient bar --}}
                    <div style="display:flex;align-items:center;gap:8px;margin-top:.625rem;font-size:11px;color:#64748b">
                        <span>0 cases</span>
                        <div style="width:130px;height:9px;border-radius:5px;background:linear-gradient(to right,#dbeafe,#1d4ed8);border:1px solid #e2e8f0"></div>
                        <span>{{ number_format($maxTotal) }} cases</span>
                    </div>
                </div>
        
                {{-- ── Right sidebar ────────────────────────────────────────────── --}}
                <div style="width:272px;flex-shrink:0;border-left:1px solid rgba(0,0,0,.07);overflow-y:auto;max-height:560px;padding:.75rem .875rem">
        
                    <p style="font-size:10px;font-weight:700;color:#94a3b8;letter-spacing:.07em;text-transform:uppercase;margin:0 0 .625rem">
                        All Regions
                    </p>
        
                    @foreach($regionPaths as $regionName => $__)
                    @php
                        $rd    = $resolve($regionName);
                        $slug  = $rd['slug'];
                        $total = $rd['total'];
                        $pct   = $grandTotal > 0 ? round($total / $grandTotal * 100, 1) : 0;
                    @endphp
                    <div
                        style="margin-bottom:.625rem;padding:.5rem .625rem;border-radius:8px;{{ $total === 0 ? 'opacity:.45' : '' }}"
                        @mouseenter="hovered = '{{ $slug }}'"
                        @mouseleave="hovered = null"
                        :style="hovered === '{{ $slug }}' ? 'background:#eff6ff;box-shadow:0 0 0 1px #bfdbfe' : ''"
                        style="transition:background .1s"
                    >
                        {{-- Region name + total --}}
                        <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:4px">
                            <span style="font-size:12px;font-weight:600;color:#0f172a">{{ $regionName }}</span>
                            <span style="font-size:13px;font-weight:800;color:{{ $total > 0 ? '#1d4ed8' : '#cbd5e1' }}">
                                {{ number_format($total) }}
                            </span>
                        </div>
        
                        {{-- Blue progress bar --}}
                        <div style="height:4px;background:#e2e8f0;border-radius:2px;overflow:hidden;margin-bottom:6px">
                            <div style="height:100%;width:{{ $pct }}%;background:linear-gradient(to right,#93c5fd,#1d4ed8);border-radius:2px;transition:width .3s"></div>
                        </div>
        
                        {{-- Per-nature breakdown table --}}
                        @if(!empty($rd['byNature']))
                        <div style="display:flex;flex-direction:column;gap:3px">
                            @foreach($rd['byNature'] as $nid => $nData)
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:6px">
                                <div style="display:flex;align-items:center;gap:5px;min-width:0">
                                    <span style="width:7px;height:7px;border-radius:50%;background:{{ $nData['color'] }};flex-shrink:0"></span>
                                    <span style="font-size:10.5px;color:#475569;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                        {{ $nData['name'] }}
                                    </span>
                                </div>
                                <span style="font-size:11px;font-weight:700;color:#0f172a;flex-shrink:0">
                                    {{ number_format($nData['count']) }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p style="font-size:10.5px;color:#94a3b8;font-style:italic;margin:0">No cases in this period</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        
            {{-- ── Floating tooltip ─────────────────────────────────────────────── --}}
            <div
                x-show="tt.visible"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                :style="`position:fixed;left:${tt.x}px;top:${tt.y}px;z-index:9999;pointer-events:none`"
                style="display:none"
            >
                <div style="background:rgba(10,15,30,.96);color:#f1f5f9;border-radius:12px;padding:.75rem 1rem;min-width:200px;max-width:260px;box-shadow:0 12px 32px rgba(0,0,0,.45);font-size:12px;backdrop-filter:blur(10px)">
        
                    {{-- Region name --}}
                    <p style="font-weight:700;font-size:13px;margin:0 0 2px;color:#fff" x-text="tt.name"></p>
                    <p style="font-size:11px;color:#93c5fd;margin:0 0 8px;font-weight:500">
                        <span x-text="tt.total.toLocaleString()"></span> case<span x-show="tt.total !== 1">s</span>
                    </p>
        
                    {{-- Divider --}}
                    <div style="height:1px;background:rgba(255,255,255,.1);margin-bottom:8px"></div>
        
                    {{-- Per-nature rows --}}
                    <template x-if="tt.byNature.length > 0">
                        <div>
                            <template x-for="n in tt.byNature" :key="n.name">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                                    <div style="display:flex;align-items:center;gap:6px">
                                        <span :style="`width:7px;height:7px;border-radius:50%;background:${n.color};flex-shrink:0`"></span>
                                        <span style="color:#cbd5e1;font-size:11px" x-text="n.name"></span>
                                    </div>
                                    <span style="font-weight:700;color:#fff;font-size:11px;margin-left:12px" x-text="n.count.toLocaleString()"></span>
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="tt.byNature.length === 0">
                        <p style="color:#475569;font-style:italic;font-size:11px;margin:0">No cases in this period</p>
                    </template>
                </div>
            </div>
        
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
