<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Filament\Support\Facades\FilamentColor;
use Symfony\Component\HttpFoundation\Response;

class FilamentSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $colorPrimary = auth()->user()?->settings['colors']['primary'] ?? config('filament.theme.colors.primary');
        $colorDanger = auth()->user()?->settings['colors']['danger'] ?? config('filament.theme.colors.danger');
        $colorWarning = auth()->user()?->settings['colors']['warning'] ?? config('filament.theme.colors.warning');
        $colorSuccess = auth()->user()?->settings['colors']['success'] ?? config('filament.theme.colors.success');
        $colorInfo = auth()->user()?->settings['colors']['info'] ?? config('filament.theme.colors.info');
        $colorGray = auth()->user()?->settings['colors']['gray'] ?? config('filament.theme.colors.gray');

        FilamentColor::register([
            'primary' => $colorPrimary,
            'danger' => $colorDanger,
            'warning' => $colorWarning,
            'success' => $colorSuccess,
            'info' => $colorInfo,
            'gray' => $colorGray,
        ]);

        return $next($request);
    }
}
