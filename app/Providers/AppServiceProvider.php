<?php

namespace App\Providers;

use App\Models\BuktiPenyaluran;
use App\Models\Kampanye;
use App\Models\PenarikanDana;
use App\Models\RekeningBank;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        $this->configureDefaults();
        $this->composeAdminSidebar();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    /**
     * Share verifikasi-pending counts with the admin sidebar layout.
     */
    protected function composeAdminSidebar(): void
    {
        View::composer('layouts.admin', function ($view) {
            $view->with([
                'sidebarKampanyeMenunggu' => Kampanye::where('status', 'menunggu')->count(),
                'sidebarRekeningMenunggu' => RekeningBank::where('status', 'menunggu')->count(),
                'sidebarPenarikanDiproses' => PenarikanDana::where('status', 'diproses')->count(),
                'sidebarBuktiMenunggu' => BuktiPenyaluran::where('status', 'menunggu')->count(),
            ]);
        });
    }
}
