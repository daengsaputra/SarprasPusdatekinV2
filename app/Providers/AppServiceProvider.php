<?php

namespace App\Providers;

use App\Models\Loan;
use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
URL::forceScheme('https');
 Paginator::useBootstrapFive();

        if (Schema::hasTable('loans')) {
            View::composer('layouts.horizontal', function ($view) {
                $overdueLoans = Loan::with('asset:id,name')
                    ->whereIn('status', ['borrowed', 'partial'])
                    ->whereNull('return_date_actual')
                    ->whereNotNull('return_date_planned')
                    ->whereDate('return_date_planned', '<', now()->toDateString())
                    ->orderBy('return_date_planned')
                    ->limit(8)
                    ->get();

                $notifications = $overdueLoans->map(function (Loan $loan) {
                    $dueDate = $loan->return_date_planned;
                    return [
                        'id' => $loan->id,
                        'asset_name' => optional($loan->asset)->name ?? 'Barang tidak dikenal',
                        'borrower_name' => $loan->borrower_name,
                        'unit' => $loan->unit,
                        'due_date' => optional($dueDate)->format('d M Y'),
                        'late_days' => $dueDate ? $dueDate->diffInDays(now()) : 0,
                    ];
                });

                $view->with('overdueLoanNotifications', $notifications)
                    ->with('overdueLoanNotificationCount', $overdueLoans->count());
            });
        }

        // Bagikan tema landing hanya jika tabel sudah tersedia.
        if (Schema::hasTable('site_settings')) {
            $activeTheme = SiteSetting::landingTheme();
            $activeSurfaces = SiteSetting::landingThemeSurfaces();
            $activeHeroVariant = SiteSetting::dashboardHeroVariant();
            $adminPageToggles = SiteSetting::pageToggles();
            $rolePageAccessMap = SiteSetting::rolePageAccess();
            $adminBroadcast = SiteSetting::adminBroadcast();
            $systemModeMeta = SiteSetting::currentSystemModeMeta();

            View::share('activeLandingTheme', $activeTheme);
            View::share('activeLandingThemeSurfaces', $activeSurfaces);
            View::share('activeHeroVariant', $activeHeroVariant);
            View::share('adminPageToggles', $adminPageToggles);
            View::share('rolePageAccessMap', $rolePageAccessMap);
            View::share('adminBroadcastMessage', $adminBroadcast);
            View::share('systemModeMeta', $systemModeMeta);
        }
    }
}
