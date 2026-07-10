<?php

namespace App\Providers\Filament;

use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Data\AuthPageConfig;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Waguilar\FilamentGuardian\FilamentGuardianPlugin;



class AuthPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('auth')
            ->path('auth')
            ->viteTheme([
                'resources/css/filament/auth/theme.css',
                'resources/css/app.css',
                ])
            ->login()
            ->colors([
                'primary' => Color::Orange,
                'secondary' => Color::Emerald,
                'auxiliary' => Color::Rose,
                'tertiary' => Color::Purple,
                'nonary' => Color::Teal,
            ])
            ->brandName('ECC-IOS')
            ->databaseNotifications()
            ->broadcasting()
            ->plugins([
                FilamentEditProfilePlugin::make()
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowBrowserSessionsForm(false)
                    ->setNavigationLabel('My Profile')
                    ->setIcon('heroicon-o-user'),
                FilamentGuardianPlugin::make()
                    ->navigationLabel('Roles')
                    ->navigationIcon('heroicon-o-shield-check')
                    ->activeNavigationIcon('heroicon-s-shield-check')
                    ->registerNavigation(true),
            ])
            ->userMenuItems([
                'profile' => Action::make('profile')
                    ->label(fn() => Auth::user()->name)
                    ->url(fn (): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle')
                    ->sort(-1),
            ])
            // ->registration()
            // ->profile()
            ->navigationGroups([
                'Dashboards',
                'General',
                'Call-Taking',
                'Monitoring',
                'Estate & Logistics',
                'Forensics',
                'Visitor Management',
                'Vehicle Management',
                'Others'
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([])
            // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => Blade::render('@wirechatStyles'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => Blade::render('@wirechatAssets'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => <<<'HTML'
                    <script>
                        document.addEventListener('alpine:init', () => {

                            Alpine.data('ghanaCasesMap', () => ({
                                hovered: null,
                                tt: { visible: false, x: 0, y: 0, name: '', total: 0, byNature: [] },
                                init() {},
                                onEnter(event, data) {
                                    this.hovered = event.currentTarget.dataset.slug;
                                    this.tt = { visible: true, x: event.clientX + 16, y: event.clientY - 12, name: data.name, total: data.total, byNature: data.byNature ?? [] };
                                },
                                onLeave()     { this.hovered = null; this.tt.visible = false; },
                                onMove(event) { this.tt.x = event.clientX + 16; this.tt.y = event.clientY - 12; },
                            }));
                        });
                    </script>
                HTML,
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
