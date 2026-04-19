<?php

namespace App\Http\Middleware;

use App\Models\ThemeMode;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareActiveTheme
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $request->user()->loadMissing('themeMode');
            $userThemeId = $request->user()->theme_mode_id;

            $modes = ThemeMode::query()
                ->where('is_active', true)
                ->where(function ($q) use ($userThemeId) {
                    $q->where('is_user_selectable', true);
                    if ($userThemeId) {
                        $q->orWhere('id', $userThemeId);
                    }
                })
                ->orderBy('sort_order')
                ->get();

            $mode = $request->user()->themeMode;
            if (! $mode || ! $mode->is_active) {
                $mode = ThemeMode::query()
                    ->where('is_active', true)
                    ->where('is_user_selectable', true)
                    ->orderBy('sort_order')
                    ->first();
            }

            $slug = $mode?->slug ?? ThemeMode::defaultSlug();

            View::share('selectableThemeModes', $modes);
            View::share('activeThemeSlug', $slug);
            View::share('activeThemeMode', $mode);
        } else {
            View::share('selectableThemeModes', collect());
            View::share('activeThemeSlug', 'light');
            View::share('activeThemeMode', null);
        }

        return $next($request);
    }
}
