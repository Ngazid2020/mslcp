<?php

namespace App\Providers;

use App\Models\Bilan;
use App\Models\BilanHormonal;
use App\Observers\BilanObserver;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use App\Models\BilanUrinaire;
use App\Policies\BilanUrinairePolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(BilanUrinaire::class, BilanUrinairePolicy::class);

        RateLimiter::for('login', fn(Request $request) =>
            Limit::perMinute(5)->by($request->input('email', $request->ip()))
        );

        FilamentAsset::register([
            Js::make('mslcp-app', Vite::asset('resources/js/app.js')),
        ]);

        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
            fn() => view('filament.topbar-quicklinks'),
        );

        Bilan::observe(BilanObserver::class);
        BilanHormonal::observe(BilanObserver::class);
    }
}
