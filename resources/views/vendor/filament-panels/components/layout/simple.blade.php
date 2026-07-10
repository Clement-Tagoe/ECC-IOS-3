@php
    use Filament\Support\Enums\Width;

    $livewire ??= null;

    $renderHookScopes = $livewire?->getRenderHookScopes();
    $maxContentWidth ??= (filament()->getSimplePageMaxContentWidth() ?? Width::Large);

    if (is_string($maxContentWidth)) {
        $maxContentWidth = Width::tryFrom($maxContentWidth) ?? $maxContentWidth;
    }
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
    @props([
        'after' => null,
        'heading' => null,
        'subheading' => null,
    ])

    <div class="fi-simple-layout">
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_LAYOUT_START, scopes: $renderHookScopes) }}

        @if (($hasTopbar ?? true) && filament()->auth()->check())
            <div class="fi-simple-layout-header">
                @if (filament()->hasDatabaseNotifications())
                    @livewire(Filament\Livewire\DatabaseNotifications::class, [
                        'lazy' => filament()->hasLazyLoadedDatabaseNotifications(),
                        'position' => \Filament\Enums\DatabaseNotificationsPosition::Topbar,
                    ])
                @endif

                @if (filament()->hasUserMenu())
                    @livewire(Filament\Livewire\SimpleUserMenu::class)
                @endif
            </div>
        @endif

        <div class="fi-simple-main-ctn">
            <section class="brand-panel" aria-label="ECC secure access overview">
                <div class="brand-content">
                <div class="brand-lockup">
                    <img
                    class="brand-logo"
                    src={{asset('images/national-emblem.jpg')}}
                    alt="National Signals Bureau logo"
                    />
                    <div>
                    <strong>Emergency Command Centre <br> Internal Operations System </strong>
                    <span>National Security Council Secretariat <br> & <br> National Signals Bureau</span>
                    </div>
                </div>

                <h1>Secured Command Access.</h1>
                <p>
                    Sign in to continue to your assigned ECC workspace for reports, case
                    coordination, monitoring, dispatch visibility, and operational
                    review.
                </p>
                </div>

                <div class="brand-footer" aria-label="Platform highlights">
                <div class="brand-stat">
                    <b>24/7</b>
                    <span>Live operational access</span>
                </div>
                <div class="brand-stat">
                    <b>RBAC</b>
                    <span>Role-based dashboards</span>
                </div>
                <div class="brand-stat">
                    <b>Audit</b>
                    <span>Tracked secure sessions</span>
                </div>
                </div>
            </section>
            <main
                @class([
                    'fi-simple-main',
                    ($maxContentWidth instanceof Width) ? "fi-width-{$maxContentWidth->value}" : $maxContentWidth,
                ])
            >
                {{ $slot }}
            </main>
        </div>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::FOOTER, scopes: $renderHookScopes) }}

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_LAYOUT_END, scopes: $renderHookScopes) }}
    </div>
</x-filament-panels::layout.base>
