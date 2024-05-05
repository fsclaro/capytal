<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Pages\Profile;
use App\Http\Middleware\FilamentSettings;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('dashboard')
            ->path('dashboard')
            ->login()
            ->registration()
            ->passwordReset()
            ->profile(Profile::class)
            ->emailVerification()
            ->font('Roboto')
            ->sidebarCollapsibleOnDesktop()
            ->sidebarFullyCollapsibleOnDesktop()
            ->favicon('images/favicon/favicon-32x32.png')
            ->colors([
                'danger'  => auth()->user()?->settings['colors']['danger'] ?? config('filament.theme.colors.danger'),
                'gray'    => auth()->user()?->settings['colors']['gray'] ?? config('filament.theme.colors.gray'),
                'info'    => auth()->user()?->settings['colors']['info'] ?? config('filament.theme.colors.info'),
                'success' => auth()->user()?->settings['colors']['success'] ?? config('filament.theme.colors.success'),
                'warning' => auth()->user()?->settings['colors']['warning'] ?? config('filament.theme.colors.warning'),
                'primary' => auth()->user()?->settings['colors']['primary'] ?? config('filament.theme.colors.primary'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //
            ])
            ->plugins([
                FilamentApexChartsPlugin::make()
            ])
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
                FilamentSettings::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
