<?php

namespace App\Providers;

use App\Models\StudentCase;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;
use Illuminate\Contracts\View\View;
use App\Observers\StudentCaseObserver;


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

        FilamentView::registerRenderHook(
            'panels::body.start',

            fn (): View => view('custom-page'),
        );

        FilamentView::registerRenderHook(

            'sidebar.nav.start',
            fn (): View => view('custom-page'),
        );

        FilamentView::registerRenderHook(
            'panels::head.start',
            fn (): View => view('loginpage'),
        );

        StudentCase::observe( StudentCaseObserver::class);
    }
}
